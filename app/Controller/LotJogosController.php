<?php

class LotJogosController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();

        #Permitindo que os usuários se registrem
        $this->Auth->allow('jogos');
    }

    public function apostas($id = null) {
        $this->loadModel('LotUserJogo');
        $this->loadModel('LotUserNumero');
        $this->loadModel('LotUserNumerosExtras');
        $this->loadModel('LotCategoria');
        $this->LotUserJogo->recursive = 1;
        $this->LotUserNumero->recursive = -1;
        $this->LotUserNumerosExtras->recursive = -1;
        $this->LotCategoria->recursive = -1;
        $sorteio = $this->LotJogo->read(null, $id);
        $apostas = $this->LotUserJogo->find('all', [
            'conditions' => [
                'LotUserJogo.lot_jogo_id' => $id
            ]
        ]);

        $this->set('apostas', $apostas);
    }

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->LotJogo->recursive = 0;
        $this->LotJogo->validate = array();

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'LotJogo.sorteio') {
                $options['conditions'][$field . ' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->LotJogo->find('all', $options);

        fb($dados, '$dados');
        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
    }

    public function jogos() {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $this->layout = 'ajax';

        // PEGA REQUISIÇÕES CADASTRADOS
        $this->LotJogo->recursive = -1;
        $dados = $this->LotJogo->find('all', array(
            'order' => array('LotJogo.id' => 'desc'),
            'group' => array('LotJogo.lot_categoria_id')
        ));
//        fb::info($dados, "\$dados");
        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados'));
    }

    public function add() {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->LotJogo->save($this->request->data['LotJogo'])) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $this->loadModel('LotCategoria');
            $gelCategorias = $this->LotCategoria->find('list', array('fields' => array('id', 'nome')));
            $this->set(compact('gelCategorias'));
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LotJogo->id = $id;
        if (!$this->LotJogo->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['LotJogo']['id'] = $id;
            if ($this->LotJogo->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $this->loadModel('LotCategoria');
            $gelCategorias = $this->LotCategoria->find('list', array('fields' => array('id', 'nome')));
            $this->set(compact('gelCategorias'));
        }

        $this->request->data = $this->LotJogo->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

    public function premiar($jogoId = null) {
        $this->LotJogo->recursive = -1;

        $this->loadModel('LotUserJogo');
        $this->loadModel('LotUserNumero');
        $this->loadModel('LotUserNumerosExtras');
        $this->loadModel('LotCategoria');
        $this->LotUserJogo->recursive = -1;
        $this->LotUserNumero->recursive = -1;
        $this->LotUserNumerosExtras->recursive = -1;
        $this->LotCategoria->recursive = -1;

        $jogo = $this->LotJogo->read(null, $jogoId);
        $categoria = $this->LotCategoria->find('first', [
            'conditions' => [
                'LotCategoria.id' => $jogo['LotJogo']['lot_categoria_id']
            ]
        ]);

        $pontuacoes = $this->LotUserJogo->find('all', [
            'fields' => 'LotUserJogo.num_total, LotUserJogo.lot_jogo_id',
            'conditions' => [
                'LotUserJogo.lot_jogo_id' => $jogoId,
                'LotUserJogo.num_total >=' => $categoria['LotCategoria']['min_assertos']
            ],
            'order' => 'LotUserJogo.num_total DESC',
            'group' => [
                'LotUserJogo.num_total'
            ],
            'limit' => 5
        ]);



        $premiacao = [
            0 => 0.50,
            1 => 1.00,
            2 => 2.00,
            3 => 20.00,
            4 => 20000.00,
        ];

        $this->loadModel('HistoricBalanceLottery');
        $this->loadModel('Balance');
        $this->loadModel('HistoricBalance');
        $this->loadModel('User');
        $this->HistoricBalanceLottery->recursive = -1;
        $this->Balance->recursive = -1;
        $this->HistoricBalance->recursive = -1;
        $this->User->recursive = -1;

        $ok = true;
        $msg = 'Registro salvo com sucesso.';
        $class = 'alert-success';
        $this->StartTransaction();
        foreach ($pontuacoes as $key => $pontuacao) {

            $users_jogos = $this->LotUserJogo->find('all', [
                'conditions' => [
                    'LotUserJogo.num_total' => $pontuacao['LotUserJogo']['num_total'],
                    'LotUserJogo.lot_jogo_id' => $jogoId,
                ]
            ]);

            foreach ($users_jogos as $user_jogo) {

                $user_jogo['LotUserJogo']['vencedor'] = 1;
                $user_jogo['LotUserJogo']['posicao'] = $key + 1;
                $ok = $this->LotUserJogo->save($user_jogo) ? true : false;


                $jogador = $this->User->read(null, $user_jogo['LotUserJogo']['jogador_id']);

                $saldo = $this->Balance->find('first', [
                    'conditions' => [
                        'Balance.owner_id' => $jogador['User']['id']
                    ]
                ]);

                $historico['HistoricBalance']['balance_id'] = $saldo['Balance']['id'];
                $historico['HistoricBalance']['owner_id'] = $jogador['User']['id'];
                $historico['HistoricBalance']['from'] = $saldo['Balance']['value'];
                $historico['HistoricBalance']['type'] = 1;
                $historico['HistoricBalance']['description'] = 'award';
                $historico['HistoricBalance']['lottery_bet_id'] = $user_jogo['LotUserJogo']['id'];
                $historico['HistoricBalance']['amount'] = isset($premiacao[$user_jogo['LotUserJogo']['num_acerto'] - 1])
                    ? $premiacao[$user_jogo['LotUserJogo']['num_acerto'] - 1]
                    : 0.00;

                $saldo['Balance']['value'] += isset($premiacao[$user_jogo['LotUserJogo']['num_acerto'] - 1])
                    ? $premiacao[$user_jogo['LotUserJogo']['num_acerto'] - 1]
                    : 0.00;

                $ok = $this->Balance->save($saldo) ? true : false;

                $historico['HistoricBalance']['to'] = $saldo['Balance']['value'];
                $this->HistoricBalance->create();

                $ok = $this->HistoricBalance->save($historico) ? true : false;

                //$historico_lottery['HistoricBalanceLottery']['historic_balance_id'] = $this->HistoricBalance->id;
                //$historico_lottery['HistoricBalanceLottery']['lot_categoria_id'] = $categoria['LotCategoria']['id'];
                //$historico_lottery['HistoricBalanceLottery']['lot_user_jogo_id'] = $user_jogo['LotUserJogo']['id'];
                //$historico_lottery['HistoricBalanceLottery']['value'] = $premiacao[$key];
                //$this->HistoricBalanceLottery->create();

                //$ok = $this->HistoricBalanceLottery->save($historico_lottery) ? true : false;
            }
        }

        $this->validaTransacao($ok);

        if($ok) {
            $jogo['LotJogo']['active'] = 0;
            $this->LotJogo->validate = [];
            $this->LotJogo->save($jogo);
        }

        if(!$ok) {
            $msg = 'Erro ao salvar registros.';
            $class = 'alert-danger';
        }

        $this->Session->setFlash($msg, 'alert', array('plugin' => 'BoostCake', 'class' => $class));
        $this->render(false);

    }

    public function vencedores($jogoId = null) {

        $this->LotJogo->recursive = 1;
        $dados = $this->LotJogo->find('first', array(
            'conditions' => array('LotJogo.id' => $jogoId)
        ));


        fb($dados, 'all $dados');
        if (!empty($dados['LotCategoria']['min_assertos'])) {
            $options['conditions']['LotUserJogo.num_acerto >='] = $dados['LotCategoria']['min_assertos'];
        } else {
            $options['conditions']['LotUserJogo.num_acerto >='] = 0;
        }
        if (!empty($dados['LotCategoria']['max_assertos'])) {
            $options['conditions']['LotUserJogo.num_acerto <='] = $dados['LotCategoria']['max_assertos'];
        }
        if (!empty($dados['LotCategoria']['zero_assertos'])) {
            $options['conditions']['LotUserJogo.num_acerto'] = 0;
        }
        if (!empty($dados['LotCategoria']['extra_assertos'])) {
            $options['conditions']['LotUserJogo.num_acerto_extra'] = $dados['LotCategoria']['extra_assertos'];
        }

        $options['conditions']['LotUserJogo.lot_jogo_id'] = $jogoId;
        $options['fields'] = array('count(LotUserJogo.id) as contador', 'LotUserJogo.num_acerto', 'LotUserJogo.lot_jogo_id');
        $options['group'] = array('LotUserJogo.num_acerto');
        $this->loadModel('LotUserJogo');
        $lotUserJogos = $this->LotUserJogo->find('all', $options);

        $this->set(compact('dados'));
        $this->set('lotUserJogos', $lotUserJogos);
    }

    public function detalhar($lotJogoId = null, $acerto = null) {
        $this->loadModel('LotUserJogo');

        $usersJogos = $this->LotUserJogo->find('all', [
            'conditions' => [
                'LotUserJogo.lot_jogo_id' => $lotJogoId,
                'LotUserJogo.num_acerto' => $acerto
            ]
        ]);


        $this->set(compact('usersJogos'));

    }

}
