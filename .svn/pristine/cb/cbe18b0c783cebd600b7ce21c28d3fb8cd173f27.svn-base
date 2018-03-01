<?php

class LotJogosController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();

        #Permitindo que os usuários se registrem
        $this->Auth->allow('jogos');
    }

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->LotJogo->recursive = 2;
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

    public function vencedores($jogoId = null) {
        $this->loadModel('LotJogo');
        $this->LotJogo->recursive = 2;
        $dados = $this->LotJogo->find('first', array(
            'conditions' => array('LotJogo.id' => $jogoId)
        ));
        fb($dados, 'all $dados');
        if (!empty($dados['LotCategoria']['min_assertos'])) {
            $options['conditions']['LotUsersJogo.num_acerto >='] = $dados['LotCategoria']['min_assertos'];
        } else {
            $options['conditions']['LotUsersJogo.num_acerto >='] = 0;
        }
        if (!empty($dados['LotCategoria']['max_assertos'])) {
            $options['conditions']['LotUsersJogo.num_acerto <='] = $dados['LotCategoria']['max_assertos'];
        }
        if (!empty($dados['LotCategoria']['zero_assertos'])) {
            $options['conditions']['LotUsersJogo.num_acerto'] = 0;
        }
        if (!empty($dados['LotCategoria']['extra_assertos'])) {
            $options['conditions']['LotUsersJogo.num_acerto_extra'] = $dados['LotCategoria']['extra_assertos'];
        }

        $options['conditions']['LotUsersJogo.lot_jogo_id'] = $jogoId;
        $options['fields'] = array('count(LotUsersJogo.id) as contador', 'LotUsersJogo.num_acerto', 'LotUsersJogo.lot_jogo_id');
        $options['group'] = array('LotUsersJogo.num_acerto');
        $this->loadModel('LotUsersJogo');
        $lotUserJogos = $this->LotUsersJogo->find('all', $options);
        $this->set(compact('dados', 'lotUserJogos'));
    }

    public function detalhar($lotJogoId = null, $acerto = null) {
        $this->loadModel('LotUserJogo');

        $usersJogos = $this->LotUserJogo->query(
            'SELECT
                LotUserJogo.*, users.username, users.name
            FROM
                lot_users_jogos AS LotUserJogo
            LEFT JOIN
                users ON LotUserJogo.jogador_id = users.id
            WHERE
                LotUserJogo.lot_jogo_id = ' . $lotJogoId .
            ' AND LotUserJogo.num_acerto = ' . $acerto
        );
        
        $this->set(compact('usersJogos'));
        fb($usersJogos, 'users');
    }

}
