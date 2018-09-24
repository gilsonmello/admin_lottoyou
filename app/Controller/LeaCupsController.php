<?php

App::uses('CakeEmail', 'Network/Email');

use GuzzleHttp\Client;

/**
 * Class RetiradasController
 *
 */
class LeaCupsController extends AppController {

    public $components = array('App');

    public $helpers = array('Time');

    var $uses = [
        'League',
        'LeaCup'
    ];

    public function index($modal = 0) {

        $this->League->recursive = -1;
        $query = $this->request->query;

        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO

        $options = array(
            'conditions' => [
                'League.context' => 'cup'
            ],
            'limit' => 50,
            'order' => array('League.id' => 'desc'),
            'contain' => [],
            'joins' => [
                [
                    'alias' => 'LeaCup',
                    'table' => 'lea_cups',
                    'type' => 'LEFT',
                    'conditions' => 'LeaCup.league_id = League.id'
                ]
            ],
            'fields' => array('League.*', 'LeaCup.*'),
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

    private function addValidateFields() {
        $this->League->validate['number_team'] = [
            'required' => [
                'rule' => array('checkVazio', 'number_team'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ]
        ];
        $this->League->validate['lottery_date'] = [
            'required' => [
                'rule' => array('checkVazio', 'lottery_date'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ]
        ];
    }

    public function add() {
        $this->League->recursive = -1;
        $this->LeaCup->recursive = -1;
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['League']['value'] = $this->App->formataValorDouble($this->request->data['League']['value']);
            $league = $this->request->data;
            $league['League']['context'] = 'cup';
            unset($league['League']['bg_image']);
            //Adicionando campos extras para validação
            $this->addValidateFields();
            $league['League']['lottery_date'] = $this->League->formatDateToMysql($league['League']['lottery_date']);
            if ($this->League->save($league)) {
                $this->LeaCup->create();
                $leaCup['LeaCup']['league_id'] = $this->League->id;
                $leaCup['LeaCup']['one_x_one'] = $league['League']['one_x_one'];
                $leaCup['LeaCup']['number_team'] = $league['League']['number_team'];
                $leaCup['LeaCup']['lottery_date'] = $this->LeaCup->formatDateToMysql($league['League']['lottery_date']);
                $this->LeaCup->save($leaCup);
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        }
    }

    private function premiarTime($options = [])
    {
        $this->loadModel('HistoricBalance');
        $this->loadModel('Balance');
        $winner = $options['LeaCupTeam'];
        $owner = $options['Owner'];
        $saldo = $options['Balance'];
        $leaCup = $options['LeaCup'];
        $league = $options['League'];
        $leagueAward = $options['LeagueAward'];

        $ok = true;
        $this->StartTransaction();

        $historico['HistoricBalance']['balance_id'] = $saldo['Balance']['id'];
        $historico['HistoricBalance']['owner_id'] = $owner['User']['id'];
        $historico['HistoricBalance']['from'] = $saldo['Balance']['value'];

        switch ($leagueAward['LeagueAward']['type']) {
            //Quantia fixa
            case 1: {
                $options['value'] = $leagueAward['LeagueAward']['value'];
                break;
            }
            //Porcentagem
            case 2: {
                $options['value'] = ($league['League']['collected'] * $leagueAward['LeagueAward']['value']) / 100;
                break;
            }
            //Objetos
            case 3: {
                $options['value'] = null;
                $options['type_description'] = $options['type_description']. ' e você ganhou: '. $leagueAward['LeagueAward']['type_description'];
                break;
            }
        }


        $saldo['Balance']['value'] += $options['value'];

        $ok = $this->Balance->save($saldo) ? true : false;
        $this->HistoricBalance->create();
        //$historico['HistoricBalance']['soccer_expert_bet_id'] = $dado['SocAposta']['id'];
        $historico['HistoricBalance']['amount'] = $options['value'];
        $historico['HistoricBalance']['to'] = $saldo['Balance']['value'];
        $historico['HistoricBalance']['type'] = 1;
        $historico['HistoricBalance']['system'] = 0;
        $historico['HistoricBalance']['description'] = 'award';
        $historico['HistoricBalance']['message'] = $options['type_description'];
        $historico['HistoricBalance']['modality'] = 'award';
        $historico['HistoricBalance']['context'] = 'cup league';

        $ok = $this->HistoricBalance->save($historico) ? true : false;

        $this->validaTransacao($ok);

        return $this->HistoricBalance->id;
    }

    public function premiar($id = null)
    {
        $this->LeaCup->id = $id;
        $this->LeaCup->recursive = -1;
        //Verifica se a liga mata mata existe
        if (!$this->LeaCup->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $leaCup = $this->LeaCup->read(null, $id);
            $league = $this->League->read(null, $leaCup['LeaCup']['league_id']);

            $this->loadModel('HistoricBalance');
            $this->loadModel('Balance');

            if($leaCup['LeaCup']['in_progress'] == 0) {
                $this->response->type('json');
                $this->response->statusCode(200);
                $this->response->body(json_encode([
                    'msg' => 'A liga ainda encontra-se em processo de sorteio.',
                    'status' => 'error'
                ]));
                $this->response->send();
                $this->_stop();
            }

            $this->loadModel('LeagueAward');
            $this->LeagueAward->recursive = -1;

            $this->loadModel('LeaCupTeam');
            $this->LeaCupTeam->recursive = -1;

            $this->loadModel('CartoleandoTeam');
            $this->CartoleandoTeam->recursive = -1;

            $this->loadModel('User');
            $this->User->recursive = -1;

            $winner = $this->LeaCupTeam->find('first', [
                'conditions' => [
                    'LeaCupTeam.lea_cup_id' => $leaCup['LeaCup']['id'],
                    'LeaCupTeam.team_id' => $leaCup['LeaCup']['winner_id']
                ],
                'joins' => [
                    [
                        'alias' => 'CartoleandoTeam',
                        'table' => 'cartoleando_teams',
                        'type' => 'LEFT',
                        'conditions' => 'CartoleandoTeam.id = LeaCupTeam.team_id'
                    ]
                ],
                'fields' => [
                    'LeaCupTeam.*',
                    'CartoleandoTeam.*',
                ],
            ]);

            $awardWinner = $this->LeagueAward->find('first', [
                'conditions' => [
                    'LeagueAward.league_id' => $league['League']['id'],
                    'LeagueAward.position' => 1,
                    'LeagueAward.context' => 'cup'
                ],
            ]);

            //Primeiro
            if(count($awardWinner)) {
                //Pegando o usuário
                $owner = $this->User->read(null, $winner['LeaCupTeam']['owner_id']);

                $saldo = $this->Balance->find('first', [
                    'conditions' => [
                        'Balance.owner_id' => $owner['User']['id']
                    ]
                ]);

                //Parâmetros
                $options = [];
                $options['type_description'] = 'Parabéns pelo 1º lugar na liga '. $league['League']['name'];
                $options['LeaCupTeam'] = $winner;
                $options['Owner'] = $owner;
                $options['LeaCup'] = $leaCup;
                $options['League'] = $league;
                $options['Balance'] = $saldo;
                $options['LeagueAward'] = $awardWinner;

                //Premiar time
                $historic_balance_id = $this->premiarTime($options);
                $winner['LeaCupTeam']['historic_balance_id'] = $historic_balance_id;
                $this->LeaCupTeam->validate = [];
                $this->LeaCupTeam->save($winner['LeaCupTeam']);
            }

            $loser = $this->LeaCupTeam->find('first', [
                'conditions' => [
                    'LeaCupTeam.lea_cup_id' => $leaCup['LeaCup']['id'],
                    'LeaCupTeam.team_id' => $leaCup['LeaCup']['loser_id']
                ],
                'joins' => [
                    [
                        'alias' => 'CartoleandoTeam',
                        'table' => 'cartoleando_teams',
                        'type' => 'LEFT',
                        'conditions' => 'CartoleandoTeam.id = LeaCupTeam.team_id'
                    ]
                ],
                'fields' => [
                    'LeaCupTeam.*',
                    'CartoleandoTeam.*',
                ],
            ]);

            $awardLoser = $this->LeagueAward->find('first', [
                'conditions' => [
                    'LeagueAward.league_id' => $league['League']['id'],
                    'LeagueAward.position' => 2,
                    'LeagueAward.context' => 'cup'
                ]
            ]);

            //Premiando segundo lugar
            if(count($awardLoser)) {
                //Pegando o usuário
                $owner = $this->User->read(null, $loser['LeaCupTeam']['owner_id']);

                $saldo = $this->Balance->find('first', [
                    'conditions' => [
                        'Balance.owner_id' => $owner['User']['id']
                    ]
                ]);

                //Parâmetros
                $options = [];
                $options['type_description'] = 'Parabéns pelo 2º lugar na liga '. $league['League']['name'];
                $options['LeaCupTeam'] = $loser;
                $options['Owner'] = $owner;
                $options['LeaCup'] = $leaCup;
                $options['League'] = $league;
                $options['Balance'] = $saldo;
                $options['LeagueAward'] = $awardLoser;

                //Premiar time
                $historic_balance_id = $this->premiarTime($options);
                $loser['LeaCupTeam']['historic_balance_id'] = $historic_balance_id;
                $this->LeaCupTeam->validate = [];
                $this->LeaCupTeam->save($loser['LeaCupTeam']);
            }

            $third = $this->LeaCupTeam->find('first', [
                'conditions' => [
                    'LeaCupTeam.lea_cup_id' => $leaCup['LeaCup']['id'],
                    'LeaCupTeam.team_id' => $leaCup['LeaCup']['third_id']
                ],
                'joins' => [
                    [
                        'alias' => 'CartoleandoTeam',
                        'table' => 'cartoleando_teams',
                        'type' => 'LEFT',
                        'conditions' => 'CartoleandoTeam.id = LeaCupTeam.team_id'
                    ]
                ],
                'fields' => [
                    'LeaCupTeam.*',
                    'CartoleandoTeam.*',
                ],
            ]);

            $awardThird = $this->LeagueAward->find('first', [
                'conditions' => [
                    'LeagueAward.league_id' => $league['League']['id'],
                    'LeagueAward.position' => 3,
                    'LeagueAward.context' => 'cup'
                ]
            ]);

            //Premiando terceiro lugar
            if(count($awardThird)) {
                //Pegando o usuário
                $owner = $this->User->read(null, $third['LeaCupTeam']['owner_id']);

                $saldo = $this->Balance->find('first', [
                    'conditions' => [
                        'Balance.owner_id' => $owner['User']['id']
                    ]
                ]);

                //Parâmetros
                $options = [];
                $options['type_description'] = 'Parabéns pelo 3º lugar na liga '. $league['League']['name'];
                $options['LeaCupTeam'] = $third;
                $options['Owner'] = $owner;
                $options['LeaCup'] = $leaCup;
                $options['League'] = $league;
                $options['Balance'] = $saldo;
                $options['LeagueAward'] = $awardThird;

                //Premiar time
                $historic_balance_id = $this->premiarTime($options);
                $third['LeaCupTeam']['historic_balance_id'] = $historic_balance_id;
                $this->LeaCupTeam->validate = [];
                $this->LeaCupTeam->save($third['LeaCupTeam']);
            }

            $this->response->type('json');
            $this->response->statusCode(200);
            $this->response->body(json_encode([
                'msg' => 'Sorteio de times concluído',
                'status' => 'success'
            ]));
            $this->response->send();
            $this->_stop();
        }
    }

    public function atualizarPontuacao($id = null)
    {
        $this->LeaCup->id = $id;
        $this->LeaCup->recursive = -1;
        //Verifica se a liga mata mata existe
        if (!$this->LeaCup->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $rodada = $this->getRodada()->rodada_atual;

            $leaCup = $this->LeaCup->read(null, $id);
            $league = $this->League->read(null, $leaCup['LeaCup']['league_id']);

            $this->loadModel('LeaCupKey');
            $this->LeaCupKey->recursive = -1;

            $this->loadModel('LeaCupStep');
            $this->LeaCupStep->recursive = -1;

            $this->loadModel('LeaCupKeyGame');
            $this->LeaCupKeyGame->recursive = -1;

            $this->loadModel('LeaCupTeam');
            $this->LeaCupTeam->recursive = -1;

            $this->loadModel('CartoleandoTeam');
            $this->CartoleandoTeam->recursive = -1;

            $faseAtual = $this->LeaCupStep->find('first', [
                'conditions' => [
                    'LeaCupStep.round' => $rodada,
                    'LeaCupStep.active' => 1,
                    'LeaCupStep.upd' => 0,
                ]
            ]);

            if(count($faseAtual) == 0) {
                $this->response->type('json');
                $this->response->statusCode(200);
                $this->response->body(json_encode([
                    'msg' => 'A rodada já foi atualizada',
                    'status' => 'error'
                ]));
                $this->response->send();
                $this->_stop();
            }

            $proximaFase = $this->LeaCupStep->find('first', [
                'conditions' => [
                    'LeaCupStep.round' => $rodada + 1,
                    'LeaCupStep.active' => 0,
                    'LeaCupStep.upd' => 0,
                ]
            ]);


            $chaves = $this->LeaCupKey->find('all', [
                'conditions' => [
                    'LeaCupKey.lea_cup_step_id' => $faseAtual['LeaCupStep']['id'],
                    //'LeaCupKey.finished' => 0,
                ],
                'order' => [
                    'LeaCupKey.id ASC'
                ]
            ]);

            $primeiro = null;
            $segundo = null;
            $terceiro = null;
            $quarto = null;
            $terceiroChave = null;
            $quartoChave = null;

            foreach ($chaves as $chave) {

                $timeCasa = $this->CartoleandoTeam->find('first', [
                    'conditions' => [
                        'CartoleandoTeam.id' => $chave['LeaCupKey']['home_team_id']
                    ]
                ]);
                $client = new Client(['base_uri' => 'http://api.cartolafc.globo.com/']);
                $response = $client->request('GET', 'time/slug/'.$timeCasa['CartoleandoTeam']['slug'].'/'.$rodada,  [
                    'headers' => [
                        'x-glb-token' => env('X_GLB_TOKEN')
                    ]
                ]);
                $body = json_decode($response->getBody());

                $timeCasaPontos = !isset($body->pontos) ? 0 : $body->pontos;

                $timeFora = $this->CartoleandoTeam->find('first', [
                    'conditions' => [
                        'CartoleandoTeam.id' => $chave['LeaCupKey']['out_team_id']
                    ]
                ]);

                $client = new Client(['base_uri' => 'http://api.cartolafc.globo.com/']);
                $response = $client->request('GET', 'time/slug/'.$timeFora['CartoleandoTeam']['slug'].'/'.$rodada,  [
                    'headers' => [
                        'x-glb-token' => env('X_GLB_TOKEN')
                    ]
                ]);
                $body = json_decode($response->getBody());
                $timeForaPontos = !isset($body->pontos) ? 0 : $body->pontos;
                $winner = null;
                $loser = null;
                if($timeCasaPontos > $timeForaPontos) {
                    $winner = $timeCasa['CartoleandoTeam'];
                    $loser = $timeFora['CartoleandoTeam'];
                } else {
                    $winner = $timeFora['CartoleandoTeam'];
                    $loser = $timeCasa['CartoleandoTeam'];
                }
                $chave['LeaCupKey']['home_team_score'] = $timeCasaPontos;
                $chave['LeaCupKey']['out_team_score'] = $timeForaPontos;
                $chave['LeaCupKey']['finished'] = 1;
                $chave['LeaCupKey']['winner_id'] = $winner['id'];
                $chave['LeaCupKey']['loser_id'] = $loser['id'];
                $this->LeaCupKey->save($chave);

                //Se for a final
                if($chave['LeaCupKey']['final_game'] == 1) {
                    $primeiro = $winner;
                    $segundo = $loser;
                }

                $chaveSubsequente = $this->LeaCupKey->find('first', [
                    'conditions' => [
                        'LeaCupKey.id' => $chave['LeaCupKey']['subsequent_key'],
                        'LeaCupKey.finished' => 0,
                    ]
                ]);

                //Se for a semifinal
                if($chave['LeaCupKey']['type_step'] == 'S') {
                    if($terceiro == null) {
                        $terceiroChave = $chave;
                        $terceiro = $loser;
                    } else {
                        $quarto = $loser;
                        $quartoChave = $chave;
                    }
                }

                //Se não achou chave subsequente é porque é a final
                if(!count($chaveSubsequente))
                    continue;

                //A cada 2 loops, pega o vencedor
                if($chaveSubsequente['LeaCupKey']['home_team_id'] == null) {
                    $chaveSubsequente['LeaCupKey']['home_team_id'] = $winner['id'];
                    $chaveSubsequente['LeaCupKey']['home_item_id'] = $chave['LeaCupKey']['home_item_id'];
                    $chaveSubsequente['LeaCupKey']['lea_cup_team_home_id'] = $chave['LeaCupKey']['lea_cup_team_home_id'];
                } else {
                    $chaveSubsequente['LeaCupKey']['out_team_id'] = $winner['id'];
                    $chaveSubsequente['LeaCupKey']['out_item_id'] = $chave['LeaCupKey']['out_item_id'];
                    $chaveSubsequente['LeaCupKey']['lea_cup_team_out_id'] = $chave['LeaCupKey']['lea_cup_team_out_id'];
                }

                $this->LeaCupKey->save($chaveSubsequente);
            }

            //Ativando a próxima fase
            if(count($proximaFase) > 0) {
                $proximaFase['LeaCupStep']['active'] = 1;
                $proximaFase['LeaCupStep']['current_step'] = 1;
                $this->LeaCupStep->save($proximaFase);
            }

            //Verificando se é a fase final. Salvar o 3 e 4 lugar
            if($terceiro && $quarto && count($proximaFase) > 0) {
                $chaveTerceiro = $this->LeaCupKey->find('first', [
                    'conditions' => [
                        'LeaCupKey.lea_cup_step_id' => $proximaFase['LeaCupStep']['id'],
                        'LeaCupKey.type_step' => 'T',
                    ],
                ]);
                $chaveTerceiro['LeaCupKey']['home_team_id'] = $terceiro['id'];
                $chaveTerceiro['LeaCupKey']['lea_cup_team_home_id'] = $terceiroChave['LeaCupKey']['lea_cup_team_home_id'];
                $chaveTerceiro['LeaCupKey']['home_item_id'] = $terceiroChave['LeaCupKey']['home_item_id'];
                $chaveTerceiro['LeaCupKey']['out_team_id'] = $quarto['id'];
                $chaveTerceiro['LeaCupKey']['lea_cup_team_out_id'] = $quartoChave['LeaCupKey']['lea_cup_team_home_id'];
                $chaveTerceiro['LeaCupKey']['out_item_id'] = $quartoChave['LeaCupKey']['out_item_id'];
                $this->LeaCupKey->save($chaveTerceiro);
            }

            //Desativando a fase atual
            $faseAtual['LeaCupStep']['current_step'] = $faseAtual['LeaCupStep']['type_step'] == 'F' ? 1 : 0;
            $faseAtual['LeaCupStep']['active'] = 0;
            $faseAtual['LeaCupStep']['upd'] = 1;
            $this->LeaCupStep->save($faseAtual);

            //Se for fase final
            if($faseAtual['LeaCupStep']['type_step'] == 'F') {
                //Desativando a liga
                $league['League']['active'] = '0';
                $league['League']['open'] = '0';
                $league['League']['new'] = '0';
                $this->League->validate = null;
                $this->League->save($league);

                //Salvando o primeiro e segundo colocado
                $leaCup['LeaCup']['winner_id'] = $primeiro['id'];
                $leaCup['LeaCup']['loser_id'] = $segundo['id'];

                $chaveTerceiro = $this->LeaCupKey->find('first', [
                    'conditions' => [
                        'LeaCupKey.lea_cup_step_id' => $faseAtual['LeaCupStep']['id'],
                        'LeaCupKey.type_step' => 'T',
                    ],
                ]);

                $terceiro = null;
                $quarto = null;
                if($chaveTerceiro['LeaCupKey']['home_team_score'] > $chaveTerceiro['LeaCupKey']['out_team_score']) {
                    $terceiro = $chaveTerceiro['LeaCupKey']['home_team_id'];
                    $quarto = $chaveTerceiro['LeaCupKey']['out_team_id'];
                } else {
                    $terceiro = $chaveTerceiro['LeaCupKey']['out_team_id'];
                    $quarto = $chaveTerceiro['LeaCupKey']['home_team_id'];
                }

                $leaCup['LeaCup']['third_id'] = $terceiro;
                $leaCup['LeaCup']['fourth_id'] = $quarto;
                $leaCup['LeaCup']['finished'] = 1;
                $leaCup['LeaCup']['show_podium'] = 1;
                $this->LeaCup->save($leaCup);
            }

            $this->response->type('json');
            $this->response->statusCode(200);
            $this->response->body(json_encode([
                'msg' => 'Atualização de pontos concluída',
                'status' => 'success'
            ]));
            $this->response->send();
            $this->_stop();
        }
    }

    private function getFases()
    {
        return [
            '1' => [
                //Terceiro lugar
                'type_step_extra' => 'T',
                //Final
                'type_step' => 'F',
                //Número de times possíveis
                'number_teams' => 4,
                //Número de chaves
                'number_keys' => 2,
                //Chaves salvas
                'keys' => []
            ],
            '2' => [
                'type_step' => 'S',
                'number_teams' => 4,
                'number_keys' => 2,
                'keys' => []
            ],
            '3' => [
                'type_step' => 'Q',
                'number_teams' => 8,
                'number_keys' => 4,
                'keys' => []
            ],
            '4' => [
                'type_step' => 'O',
                'number_teams' => 16,
                'number_keys' => 8,
                'keys' => []
            ],
            '5' => [
                'type_step' => 'I',
                'number_teams' => 32,
                'number_keys' => 16,
                'keys' => []
            ],
        ];
    }

    /**
     * O algorítimo guarda sempre as chaves criadas, para assim conseguir fazer os devidos apontamentos para as chaves
     *
     * @param null $id
     */
    public function sortearTimes($id = null)
    {
        $this->LeaCup->id = $id;
        $this->LeaCup->recursive = -1;
        //Verifica se a liga mata mata existe
        if (!$this->LeaCup->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->loadModel('Setting');
            $this->Setting->recursive = -1;
            $currentRound = $this->getRodada()->rodada_atual;

            $leaCup = $this->LeaCup->read(null, $id);
            $league = $this->League->read(null, $leaCup['LeaCup']['league_id']);

            $this->loadModel('LeaCupKey');
            $this->LeaCupKey->recursive = -1;

            $this->loadModel('LeaCupStep');
            $this->LeaCupStep->recursive = -1;

            $this->loadModel('LeaCupKeyGame');
            $this->LeaCupKeyGame->recursive = -1;

            $this->loadModel('LeaCupTeam');
            $this->LeaCupTeam->recursive = -1;

            $this->loadModel('CartoleandoTeam');
            $this->CartoleandoTeam->recursive = -1;

            $teams = $this->LeaCupTeam->find('all', [
                'conditions' => [
                    'LeaCupTeam.lea_cup_id' => $leaCup['LeaCup']['id']
                ],
                'joins' => [
                    [
                        'alias' => 'CartoleandoTeam',
                        'table' => 'cartoleando_teams',
                        'type' => 'LEFT',
                        'conditions' => 'CartoleandoTeam.id = LeaCupTeam.team_id'
                    ]
                ],
                'fields' => [
                    'LeaCupTeam.*',
                    'CartoleandoTeam.*',
                ],
                'order' => 'rand()',
                'limit' => $league['League']['number_team']
            ]);

            if(count($teams) < $league['League']['number_team']) {
                echo json_encode([
                    'msg' => 'Número de times insuficiente'
                ]);
                die;
            }

            //Número total de fases
            $qtd_fases = 1;
            //Será multiplicada sempre por 2, até chegar ao número total de times
            $p = 1;
            for($i = 1; $i <= 5; $i++) {
                if($league['League']['number_team'] == ($p * 2)) {
                    break;
                }
                $p = $p * 2;
                $qtd_fases++;
            }

            $fases = $this->getFases();

            $indice = 0;
            //Váriavel $j
            //Se $j == 1, a liga só tem a Final
            //$j == 2, a liga inicia nas semifinais
            //$j == 3, a liga inicia nas quartas
            //$j == 4, a liga inicia nas oitavas
            //$j == 5, a liga inicia com 32 times, ou seja, fase inicial
            for($j = 1; $j <= $qtd_fases && ($currentRound <= 38) && ($currentRound + $qtd_fases) <= 38; $j++) {
                //Pegando as propiedadas da fase
                $fase = $fases[(string)$j];

                //Crio uma nova fase
                $step = null;
                $step['LeaCupStep']['type_step'] = $fase['type_step'];
                $step['LeaCupStep']['lea_cup_id'] = $leaCup['LeaCup']['id'];
                $step['LeaCupStep']['upd'] = 0;
                //$step['LeaCupStep']['round'] = $currentRound;
                $this->LeaCupStep->create();
                $this->LeaCupStep->save($step);
                $step['LeaCupStep']['id'] = $this->LeaCupStep->id;

                //Se for a final
                if($j == 1) {
                    //Criando de 1 e 2 colocado
                    $key = null;
                    $key['LeaCupKey']['lea_cup_step_id'] = $this->LeaCupStep->id;
                    $key['LeaCupKey']['subsequent_key'] = null;
                    $key['LeaCupKey']['type_step'] = $fase['type_step'];
                    $key['LeaCupKey']['home_team_id'] = null;
                    $key['LeaCupKey']['out_team_id'] = null;
                    $key['LeaCupKey']['home_position'] = null;
                    $key['LeaCupKey']['out_position'] = null;
                    $key['LeaCupKey']['final_game'] = 1;
                    $key['LeaCupKey']['round'] = $currentRound + $qtd_fases - 1;

                    $this->LeaCupKey->create();
                    $this->LeaCupKey->save($key);
                    $key['LeaCupKey']['id'] = $this->LeaCupKey->id;
                    $fases[(string)$j]['keys'][] = $key;
                    $fases[(string)$j]['round'] = $currentRound + $qtd_fases - 1;

                    //Criando a chave de 3 e 4 colocado
                    $key = null;
                    $key['LeaCupKey']['lea_cup_step_id'] = $this->LeaCupStep->id;
                    $key['LeaCupKey']['subsequent_key'] = null;
                    $key['LeaCupKey']['type_step'] = $fase['type_step_extra'];
                    $key['LeaCupKey']['home_team_id'] = null;
                    $key['LeaCupKey']['out_team_id'] = null;
                    $key['LeaCupKey']['home_position'] = null;
                    $key['LeaCupKey']['out_position'] = null;
                    $key['LeaCupKey']['round'] = $currentRound + $qtd_fases - 1;

                    $this->LeaCupKey->create();
                    $this->LeaCupKey->save($key);

                } else if($j < $qtd_fases) {
                    //Pegando todas os confrontos(chaves) da fase anterior
                    $chave_anterior = $fases[(string)$j - 1];
                    for($k = 1; $k <= $fase['number_keys']; $k++) {
                        $key = null;
                        $key['LeaCupKey']['lea_cup_step_id'] = $this->LeaCupStep->id;
                        //Fazendo a chave apontar para a chave anterior
                        $key['LeaCupKey']['subsequent_key'] = $chave_anterior['keys'][$indice]['LeaCupKey']['id'];
                        $key['LeaCupKey']['type_step'] = $fase['type_step'];
                        $key['LeaCupKey']['home_team_id'] = null;
                        $key['LeaCupKey']['out_team_id'] = null;
                        $key['LeaCupKey']['home_position'] = null;
                        $key['LeaCupKey']['out_position'] = null;
                        $key['LeaCupKey']['round'] = $currentRound - ($j - $qtd_fases);

                        $this->LeaCupKey->create();
                        $this->LeaCupKey->save($key);
                        $key['LeaCupKey']['id'] = $this->LeaCupKey->id;
                        $fases[(string)$j]['keys'][] = $key;
                        $fases[(string)$j]['round'] = $currentRound - ($j - $qtd_fases);

                        //Se o ínidice for == 2, significa que preciso andar com o índice
                        if($k % 2 == 0) {
                            $indice++;
                        }
                    }
                    $indice = 0;
                } else {
                    $chave_anterior = $fases[(string)$j - 1];

                    //Se for a última fase da copa
                    for($k = 1; $k <= $fase['number_keys']; $k++) {
                        //Pego um índice aleatório do array de times
                        $indice_aleatorio_casa = array_rand($teams);
                        $time_casa = $teams[$indice_aleatorio_casa];
                        $time_casa['LeaCupTeam']['selected'] = 1;
                        $this->LeaCupTeam->save($time_casa);
                        //Removo o time do array
                        unset($teams[$indice_aleatorio_casa]);

                        //Pego um índice aleatório do array de times
                        $indice_aleatorio_fora = array_rand($teams);
                        $time_fora = $teams[$indice_aleatorio_fora];
                        $time_fora['LeaCupTeam']['selected'] = 1;
                        $this->LeaCupTeam->save($time_fora);
                        //Removo o time do array
                        unset($teams[$indice_aleatorio_fora]);

                        $key = null;
                        $key['LeaCupKey']['lea_cup_step_id'] = $this->LeaCupStep->id;
                        $key['LeaCupKey']['subsequent_key'] = $chave_anterior['keys'][$indice]['LeaCupKey']['id'];
                        $key['LeaCupKey']['type_step'] = $fase['type_step'];
                        $key['LeaCupKey']['home_team_id'] = $time_casa['CartoleandoTeam']['id'];
                        $key['LeaCupKey']['out_team_id'] = $time_fora['CartoleandoTeam']['id'];
                        $key['LeaCupKey']['lea_cup_team_out_id'] = $time_fora['LeaCupTeam']['id'];
                        $key['LeaCupKey']['lea_cup_team_home_id'] = $time_casa['LeaCupTeam']['id'];
                        $key['LeaCupKey']['home_position'] = null;
                        $key['LeaCupKey']['out_position'] = null;
                        $key['LeaCupKey']['round'] = $currentRound;
                        $key['LeaCupKey']['home_item_id'] = $time_casa['LeaCupTeam']['item_id'];
                        $key['LeaCupKey']['out_item_id'] = $time_fora['LeaCupTeam']['item_id'];

                        $this->LeaCupKey->create();
                        $this->LeaCupKey->save($key);
                        $key['LeaCupKey']['id'] = $this->LeaCupKey->id;
                        //Adiciono a confronto(chave) no array, de acordo com a fase da copa(oitvas, quartas, etc...)

                        //Lembrando que a variável $j serve para saber qual é a fase da copa
                        $fases[(string)$j]['keys'][] = $key;
                        $fases[(string)$j]['round'] = $currentRound;

                        if($k % 2 == 0) {
                            $indice++;
                        }
                    }

                    $indice = 0;
                }

                //Se for a última fase, seto a fase como ativa
                if($j == $qtd_fases) {
                    $step = null;
                    $step['LeaCupStep']['id'] = $this->LeaCupStep->id;
                    $step['LeaCupStep']['round'] = $currentRound;
                    $step['LeaCupStep']['active'] = 1;
                    $step['LeaCupStep']['current_step'] = 1;
                    $this->LeaCupStep->save($step);
                } else {
                    $step = null;
                    $step['LeaCupStep']['id'] = $this->LeaCupStep->id;
                    $step['LeaCupStep']['round'] = $fases[(string)$j]['round'];
                    $this->LeaCupStep->save($step);
                }

            }
        }

        $leaCup['LeaCup']['in_progress'] = 1;
        $this->LeaCup->save($leaCup);
        $this->response->type('json');
        $this->response->statusCode(200);
        $this->response->body(json_encode([
            'msg' => 'ok'
        ]));
        $this->layout = false;
        $this->autoRender = false;
        $this->render(false);
        echo json_encode([
            'msg' => ''
        ]);
        die;
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        /*$this->League->id = $id;
        $this->League->recursive = -1;*/

        $this->LeaCup->id = $id;
        $this->LeaCup->recursive = -1;

        //Verifica se a liga mata mata existe
        if (!$this->LeaCup->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $leaCup = $this->LeaCup->read(null, $id);
            //Pegando os dados da liga
            $league_id = $leaCup['LeaCup']['league_id'];
            $this->request->data['League']['id'] = $league_id;
            $this->request->data['League']['value'] = $this->App->formataValorDouble($this->request->data['League']['value']);
            $league = $this->request->data;
            unset($league['League']['bg_image']);
            //Adicionando campos extras para validação
            $this->addValidateFields();
            if ($this->League->save($league)) {
                $leaCup['LeaCup']['one_x_one'] = $league['League']['one_x_one'];
                $leaCup['LeaCup']['number_team'] = $league['League']['number_team'];
                $leaCup['LeaCup']['lottery_date'] = $this->LeaCup->formatDateToMysql($league['League']['lottery_date']);
                $this->LeaCup->save($leaCup);
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {

            //Pegando dados da liga mata mata
            $leaCup = $this->LeaCup->read(null, $id);
            $leaCup['LeaCup']['lottery_date'] = $this->formatWithMask($leaCup['LeaCup']['lottery_date'], '-');
            $this->set('leaCup', $leaCup);

            //Pegando os dados da liga
            $league_id = $leaCup['LeaCup']['league_id'];
            $this->request->data = $this->League->read(null, $league_id);
        }


    }

    public function delete($id = null) {
        $this->modelClass = 'LeaCup';
        $leaCup = $this->LeaCup->read(null, $id);
        $this->League->id = $leaCup['LeaCup']['league_id'];
        $this->League->delete($leaCup['LeaCup']['league_id']);
        $this->LeaCup->id = $leaCup['LeaCup']['id'];
        $this->_delete($id, false);
    }

}
