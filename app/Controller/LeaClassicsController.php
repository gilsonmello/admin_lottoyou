<?php

App::uses('CakeEmail', 'Network/Email');

use GuzzleHttp\Client;

/**
 * Class RetiradasController
 *
 */
class LeaClassicsController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    var $uses = [
        'League',
        'LeaClassic'
    ];

    public function index($modal = 0) {
        $this->League->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
                'League.context' => 'classic'
            ],
            'limit' => 50,
            'order' => array('League.id' => 'desc'),
            'contain' => [],
            'joins' => [
                [
                    'alias' => 'LeaClassic',
                    'table' => 'lea_classics',
                    'type' => 'INNER',
                    'conditions' => 'LeaClassic.league_id = League.id'
                ]
            ],
            'fields' => array('League.*', 'LeaClassic.*'),
        );

        if(isset($query['name'])) {
            $options['conditions']['League.name LIKE'] = '%'.$query['name'].'%';
        }

        /*if(isset($query['email'])) {
           $options['conditions']['Contato.email LIKE'] = '%'.$query['email'].'%';
       }

       if(isset($query['dt_begin']) && $query['dt_begin'] != '') {
           $dt_inicio = implode('-', array_reverse(explode('/', $query['dt_begin'])));
           $options['conditions']['Contato.created >='] = $dt_inicio . ' 00:00:00';
       }

       if(isset($query['dt_end']) && $query['dt_end'] != '') {
           $dt_fim = implode('-', array_reverse(explode('/', $query['dt_end'])));
           $options['conditions']['Contato.created <='] = $dt_fim . ' 23:59:59';
       }

       if(isset($query['answered']) && $query['answered'] != '') {
           $options['conditions']['Contato.answered'] = $query['answered'];
       }*/

        $this->paginate = $options;

        $dados = $this->paginate('League');

        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));

        $this->set('query', http_build_query($query));
        $this->set('model', $this->League);

        //die(var_dump($this->request->method()));
        if ($this->request->is('ajax') && $this->request->method() == 'GET') {
            $this->layout = false;
            $this->render('index_table');
        }

    }

    public function add() {
        $this->League->recursive = -1;
        $this->LeaClassic->recursive = -1;
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['League']['value'] = $this->App->formataValorDouble($this->request->data['League']['value']);
            $league = $this->request->data;
            $league['League']['context'] = 'classic';
            unset($league['League']['bg_image']);

            $this->addValidateFields();
            if ($this->League->save($league)) {
                $this->LeaClassic->create();
                $leaClassic['LeaClassic']['league_id'] = $this->League->id;
                $leaClassic['LeaClassic']['type_award_id'] = $league['League']['type_award_id'];
                $leaClassic['LeaClassic']['min_players'] = $league['League']['min_players'];
                $leaClassic['LeaClassic']['max_players'] = $league['League']['max_players'];
                $leaClassic['LeaClassic']['last_round'] = $league['League']['last_round'];
                $this->LeaClassic->save($leaClassic);

                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    public function atualizarPontuacao($id = null)
    {
        $this->LeaClassic->id = $id;
        $this->LeaClassic->recursive = -1;
        //Verifica se a liga mata mata existe
        if (!$this->LeaClassic->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $rodadaRequest = $this->getRodada();
            $rodada = $rodadaRequest->rodada_atual;
            //$rodada = 25;
            $turno = $rodada <= 18 ? 1 : 2;


            $leaClassic = $this->LeaClassic->read(null, $id);
            if($rodada > $leaClassic['LeaClassic']['last_round']) {
                echo json_encode([
                    'msg' => 'Rodada atual '.$rodada.' é maior do que a última rodada cadastrada na liga',
                    'status' => 'error'
                ]);
                die;
            }

            $league = $this->League->read(null, $leaClassic['LeaClassic']['league_id']);

            $this->loadModel('LeaClassicTeam');
            $this->LeaClassicTeam->recursive = -1;

            $this->loadModel('LeaClassicTeamPoint');
            $this->LeaClassicTeamPoint->recursive = -1;

            $this->loadModel('LeaClassicTeamPM');
            $this->LeaClassicTeamPM->recursive = -1;

            $this->loadModel('LeaClassicTeamPT');
            $this->LeaClassicTeamPT->recursive = -1;

            $updated = $this->LeaClassicTeamPoint->find('first', [
                'conditions' => [
                    'LeaClassicTeamPoint.round' => $rodada,
                    'LeaClassicTeamPoint.lea_classic_id' => $leaClassic['LeaClassic']['id']
                ]
            ]);

            //Tipos de ordenamentos
            $typeOrders = [
                0 => '',
                1 => 'p_c',
                2 => 'p_m',
                3 => 'p_m',
                4 => 'p_p',
                5 => 'p_r',
            ];

            //Se já atualizou na rodada
            if(count($updated) > 0) {
                echo json_encode([
                    'msg' => 'A rodada já foi atualizada',
                    'status' => 'error'
                ]);
                die;
            }

            $this->loadModel('CartoleandoTeam');
            $this->CartoleandoTeam->recursive = -1;

            //Pegando os times inseridos na liga clássica
            $leaClassicTeams = $this->LeaClassicTeam->find('all', [
                'conditions' => [
                    'LeaClassicTeam.lea_classic_id' => $leaClassic['LeaClassic']['id']
                ]
            ]);

            //Percorrendo todos os times
            foreach($leaClassicTeams as $leaClassicTeam) {
                //Buscando dados do time na API do cartola
                $team = $this->CartoleandoTeam->read(null, $leaClassicTeam['LeaClassicTeam']['team_id']);
                $client = new Client(['base_uri' => 'http://api.cartolafc.globo.com/']);
                $response = $client->request('GET', 'time/slug/'.$team['CartoleandoTeam']['slug'].'/'.$rodada,  [
                    'headers' => [
                        'x-glb-token' => env('X_GLB_TOKEN')
                    ]
                ]);
                $body = json_decode($response->getBody());
                $pontos = !isset($body->pontos) ? 0 : $body->pontos;
                $patrimonio = !isset($body->patrimonio) ? 0 : $body->patrimonio;

                //Salvando uma espécie de log de atualizações
                $now = date('Y-m-d H:i:s');
                $month = date('m');
                $leaClassicTeamPoint['LeaClassicTeamPoint']['lea_classic_team_id'] = $leaClassicTeam['LeaClassicTeam']['id'];
                $leaClassicTeamPoint['LeaClassicTeamPoint']['lea_classic_id'] = $leaClassic['LeaClassic']['id'];
                $leaClassicTeamPoint['LeaClassicTeamPoint']['round'] = $rodada;
                $leaClassicTeamPoint['LeaClassicTeamPoint']['owner_id'] = $leaClassicTeam['LeaClassicTeam']['owner_id'];
                $leaClassicTeamPoint['LeaClassicTeamPoint']['points'] = $pontos;
                $leaClassicTeamPoint['LeaClassicTeamPoint']['checked_in'] = $now;
                $this->LeaClassicTeamPoint->create();
                $this->LeaClassicTeamPoint->validate = [];
                $this->LeaClassicTeamPoint->save($leaClassicTeamPoint);


                //Se ainda não atualizou ou for diferente do atual
                if($leaClassicTeam['LeaClassicTeam']['current_turn'] == null || $leaClassicTeam['LeaClassicTeam']['current_turn'] != $turno) {
                    $leaClassicTeam['LeaClassicTeam']['p_t'] = $pontos;
                    $this->LeaClassicTeamPT->create();
                    $PT['LeaClassicTeamPT']['lea_classic_team_id'] = $leaClassicTeam['LeaClassicTeam']['id'];
                    $PT['LeaClassicTeamPT']['points'] = $pontos;
                    $PT['LeaClassicTeamPT']['turn'] = $turno;
                    $this->LeaClassicTeamPT->validate = [];
                    $this->LeaClassicTeamPT->save($PT);
                } else if($leaClassicTeam['LeaClassicTeam']['current_turn'] == $turno) {
                    //Pontos por turno
                    $leaClassicTeam['LeaClassicTeam']['p_t'] = $leaClassicTeam['LeaClassicTeam']['p_t'] + $pontos;
                    $PT = $this->LeaClassicTeamPT->find('first', [
                        'conditions' => [
                            'LeaClassicTeamPT.turn' => $turno,
                            'LeaClassicTeamPT.lea_classic_team_id' => $leaClassicTeam['LeaClassicTeam']['id'],
                        ]
                    ]);
                    $PT['LeaClassicTeamPT']['points'] = $leaClassicTeam['LeaClassicTeam']['p_t'];
                    $this->LeaClassicTeamPT->validate = [];
                    $this->LeaClassicTeamPT->save($PT);
                }

                //Se ainda não atualizou
                if($leaClassicTeam['LeaClassicTeam']['_month'] == null || $leaClassicTeam['LeaClassicTeam']['_month'] != $month) {
                    $leaClassicTeam['LeaClassicTeam']['p_m'] = $pontos;
                    $this->LeaClassicTeamPM->create();
                    $PM['LeaClassicTeamPM']['lea_classic_team_id'] = $leaClassicTeam['LeaClassicTeam']['id'];
                    $PM['LeaClassicTeamPM']['points'] = $pontos;
                    $PM['LeaClassicTeamPM']['_month'] = $month;
                    $this->LeaClassicTeamPM->validate = [];
                    $this->LeaClassicTeamPM->save($PM);
                } else if($leaClassicTeam['LeaClassicTeam']['_month'] == $month ) {
                    //Pontos por turno
                    $leaClassicTeam['LeaClassicTeam']['p_m'] = $leaClassicTeam['LeaClassicTeam']['p_m'] + $pontos;
                    $PM = $this->LeaClassicTeamPM->find('first', [
                        'conditions' => [
                            'LeaClassicTeamPM._month' => $month,
                            'LeaClassicTeamPM.lea_classic_team_id' => $leaClassicTeam['LeaClassicTeam']['id']
                        ]
                    ]);
                    $PM['LeaClassicTeamPM']['points'] = $leaClassicTeam['LeaClassicTeam']['p_m'];
                    $this->LeaClassicTeamPM->validate = [];
                    $this->LeaClassicTeamPM->save($PM);
                }

                //Atualizando os pontos
                $leaClassicTeam['LeaClassicTeam']['_month'] = $month;
                $leaClassicTeam['LeaClassicTeam']['p_r'] = $pontos;
                $leaClassicTeam['LeaClassicTeam']['p_c'] = $leaClassicTeam['LeaClassicTeam']['p_c'] + $pontos;
                $leaClassicTeam['LeaClassicTeam']['p_p'] = $patrimonio;
                $leaClassicTeam['LeaClassicTeam']['current_round'] = $rodada;
                $leaClassicTeam['LeaClassicTeam']['current_turn'] = $turno;
                $this->LeaClassicTeam->validate = [];
                $this->LeaClassicTeam->save($leaClassicTeam);
            }

            //Ordenar de acordo com o tipo de ordenamento da liga
            $typeOrder = $typeOrders[$leaClassic['LeaClassic']['type_award_id']];
            $leaClassicTeams = $this->LeaClassicTeam->find('all', [
                'conditions' => [
                    'LeaClassicTeam.lea_classic_id' => $leaClassic['LeaClassic']['id']
                ],
                'order' => [
                    'LeaClassicTeam.'.$typeOrder.' desc'
                ]
            ]);

            //Atualizando ranking
            foreach($leaClassicTeams as $key => $leaClassicTeam) {
                $leaClassicTeam['LeaClassicTeam']['position'] = $key + 1;
                $this->LeaClassicTeam->save($leaClassicTeam);
            }

            //Se for a última rodada
            if($leaClassic['LeaClassic']['last_round'] == $rodada) {

                //Desativando a liga
                $league['League']['active'] = '0';
                $league['League']['open'] = '0';
                $league['League']['new'] = '0';
                $this->League->validate = null;
                $this->League->save($league);

                //Busca primeiro colocado
                $primeiro = $this->LeaClassicTeam->find('first', [
                    'conditions' => [
                        'LeaClassicTeam.lea_classic_id' => $leaClassic['LeaClassic']['id'],
                        'LeaClassicTeam.position' => 1
                    ]
                ]);

                //Busca segundo colocado
                $segundo = $this->LeaClassicTeam->find('first', [
                    'conditions' => [
                        'LeaClassicTeam.lea_classic_id' => $leaClassic['LeaClassic']['id'],
                        'LeaClassicTeam.position' => 2
                    ]
                ]);

                //Busca terceiro colocado
                $terceiro = $this->LeaClassicTeam->find('first', [
                    'conditions' => [
                        'LeaClassicTeam.lea_classic_id' => $leaClassic['LeaClassic']['id'],
                        'LeaClassicTeam.position' => 3
                    ]
                ]);

                //Busca quarto colocado
                $quarto = $this->LeaClassicTeam->find('first', [
                    'conditions' => [
                        'LeaClassicTeam.lea_classic_id' => $leaClassic['LeaClassic']['id'],
                        'LeaClassicTeam.position' => 4
                    ]
                ]);
                $leaClassic['LeaClassic']['winner_id'] = $primeiro['LeaClassicTeam']['team_id'];
                $leaClassic['LeaClassic']['loser_id'] = $segundo['LeaClassicTeam']['team_id'];
                $leaClassic['LeaClassic']['third_id'] = $terceiro['LeaClassicTeam']['team_id'];
                $leaClassic['LeaClassic']['fourth_id'] = $quarto['LeaClassicTeam']['team_id'];
                $leaClassic['LeaClassic']['show_podium'] = 1;
                $this->LeaClassic->validate = [];
                $this->LeaClassic->save($leaClassic);
            }

            $this->response->type('json');
            $this->response->statusCode(200);
            $this->response->body(json_encode([
                'msg' => 'ok'
            ]));
            $this->layout = false;
            $this->autoRender = false;
            $this->render(false);
            echo json_encode([
                'msg' => 'ok',
                'status' => 'success'
            ]);
            die;
        }

    }

    private function addValidateFields() {
        $this->League->validate['type_award_id'] = [
            'required' => [
                'rule' => array('checkVazio', 'type_award_id'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ]
        ];
        $this->League->validate['min_players'] = [
            'required' => [
                'rule' => array('checkVazio', 'min_players'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ]
        ];
        $this->League->validate['last_round'] = [
            'required' => [
                'rule' => array('checkVazio', 'last_round'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ]
        ];
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LeaClassic->id = $id;
        $this->LeaClassic->recursive = -1;

        //Verifica se a liga clássica existe
        if (!$this->LeaClassic->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $leaClassic = $this->LeaClassic->read(null, $id);
            //Pegando os dados da liga
            $league_id = $leaClassic['LeaClassic']['league_id'];
            $this->request->data['League']['id'] = $league_id;
            $this->request->data['League']['value'] = $this->App->formataValorDouble($this->request->data['League']['value']);
            $league = $this->request->data;
            unset($league['League']['bg_image']);
            //Adicionando campos extras para validação
            $this->addValidateFields();
            if ($this->League->save($league)) {
                $leaClassic['LeaClassic']['type_award_id'] = $league['League']['type_award_id'];
                $leaClassic['LeaClassic']['min_players'] = $league['League']['min_players'];
                $leaClassic['LeaClassic']['max_players'] = $league['League']['max_players'];
                $leaClassic['LeaClassic']['last_round'] = $league['League']['last_round'];
                $this->LeaClassic->save($leaClassic);
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $leaClassic = $this->LeaClassic->read(null, $id);
            $this->set('leaClassic', $leaClassic);

            $league_id = $leaClassic['LeaClassic']['league_id'];
            $this->request->data = $this->League->read(null, $league_id);
        }

    }

    /**
     * @param null $id
     */
    public function delete($id = null) {
        $this->modelClass = 'LeaClassic';
        $leaClassic = $this->LeaClassic->read(null, $id);
        $this->League->id = $leaClassic['LeaClassic']['league_id'];
        $this->League->delete($leaClassic['LeaClassic']['league_id']);
        $this->LeaClassic->id = $leaClassic['LeaClassic']['id'];
        $this->_delete($id, false);
    }

}
