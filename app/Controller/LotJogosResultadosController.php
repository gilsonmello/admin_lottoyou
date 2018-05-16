<?php

class LotJogosResultadosController extends AppController {

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->LotJogosResultado->recursive = 0;
        $this->LotJogosResultado->validate = array();

        // TRATA CONDIÇÕES
        foreach ($options['conditions'] as $field => $value) {
            if ($field == 'LotJogosResultado.sorteio') {
                $options['conditions'][$field . ' LIKE'] = "%$value%";
                unset($options['conditions'][$field]);
            }
        }

        // PEGA REQUISIÇÕES CADASTRADOS
        $dados = $this->LotJogosResultado->find('all', $options);
        // ENVIA DADOS PARA A SESSÃO
        $this->set(compact('dados', 'modal'));
    }

    public function add($lotJogoId = null) {
        $this->layout = 'ajax';

        $this->loadModel('LotJogosNumero');
        $this->LotJogosNumero->recursive = -1;
        $this->loadModel('LotJogosNumerosExtras');
        $this->LotJogosNumerosExtras->recursive = -1;

        if ($this->request->is('post') || $this->request->is('put')) {
            if (!empty($this->request->data['LotJogosResultado']['concurso_data']) && !empty($this->request->data['LotJogosResultado']['lot_jogo_id'])) {

                $data['LotJogosResultado'] = $this->request->data['LotJogosResultado'];
                $data['LotJogosResultado']['user_id'] = $this->Session->read('Auth.User.id');


                if ($this->LotJogosResultado->save($data)) {
                    //$lotJogo['LotJogo']['lot_jogos_resultado_id'] = $this->LotJogosResultado->getLastInsertId();
                    //$this->LotJogo->save($lotJogo['LotJogo']);
                    //$this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                } else {
                    $this->Session->setFlash('Não foi possível salvar o registro.<br/>Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                }
                
                
                //$data['LotJogosResultado']['numeros_sorteados'] = '';
                //$data['LotJogosResultado']['contador'] = 0;
                foreach ($this->request->data['D'] as $v) {
                    if (!is_array($v) && !empty($v)) {
                        $this->LotJogosNumero->create();
                        $numero['LotJogosNumero']['numero'] = $v;
                        $numero['LotJogosNumero']['lot_jogos_resultado_id'] = $this->LotJogosResultado->getLastInsertId();
                        $this->LotJogosNumero->save($numero);
                    }
                }
                //$data['LotJogosResultado']['numeros_sorteados_extra'] = '';

                if(isset($this->request->data['d'])) { 
                    foreach ($this->request->data['d'] as $v) {
                        if (!is_array($v) && !empty($v)) {
                            $this->LotJogosNumerosExtras->create();
                            $numero['LotJogosNumerosExtras']['numero'] = $v;
                            $numero['LotJogosNumerosExtras']['lot_jogos_resultado_id'] = $this->LotJogosResultado->getLastInsertId();
                            $this->LotJogosNumerosExtras->save($numero);
                        }
                    }
                }

                $this->loadModel('LotUserJogo');
                $this->loadModel('LotUserNumero');
                $this->loadModel('LotUserNumerosExtras');
                $this->LotUserJogo->recursive = -1;
                $this->LotUserNumero->recursive = -1;
                $this->LotUserNumerosExtras->recursive = -1;

                $users_jogos = $this->LotUserJogo->find('all', [
                    'conditions' => [
                        'LotUserJogo.lot_jogo_id' => $lotJogoId
                    ]
                ]);

                
                foreach ($users_jogos as $key => $value) {
                    $user_numeros = $this->LotUserNumero->find('all', [
                        'conditions' => [
                            'LotUserNumero.lot_users_jogo_id' => $value['LotUserJogo']['id']
                        ]
                    ]);

                    $contador1 = 0;
                    //Número sorteados
                    if(isset($this->request->data['D'])) { 
                        foreach ($this->request->data['D'] as $v) {
                            foreach ($user_numeros as $key => $numero) {  
                                if($v == $numero['LotUserNumero']['numero']) { 
                                    $contador1++;
                                }
                            }
                        }
                        
                    }

                    
                    $user_numeros_extras = $this->LotUserNumerosExtras->find('all', [
                        'conditions' => [
                            'LotUserNumerosExtras.lot_users_jogo_id' => $value['LotUserJogo']['id']
                        ]
                    ]);

                    $contador2 = 0;
                    if(isset($this->request->data['d'])) { 
                        foreach ($this->request->data['d'] as $v) {
                            foreach ($user_numeros_extras as $key => $numero_extra) {                            
                                if($v == $numero_extra['LotUserNumerosExtras']['numero']) { 
                                    $contador2++;
                                }
                            }
                        }
                    }

                    $value['LotUserJogo']['num_acerto'] = $contador1;
                    $value['LotUserJogo']['num_acerto_extra'] = $contador2;
                    $this->LotUserJogo->save($value);
                    
                }


            
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));                
                
                
            } else {
                $this->Session->setFlash('Por favor, informe o Campo:<br/> <u>Data do resultado</u>.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            
            $this->loadModel('LotJogo');

            $dados = $this->LotJogo->find('first', [
                'conditions' => [
                    'LotJogo.id' => $lotJogoId
                ]
            ]);

            $exits = $this->LotJogosResultado->find('first', [
                'conditions' => [
                    'LotJogosResultado.lot_jogo_id' => $lotJogoId
                ]
            ]);
            
            if (count($exits) > 0) {

                $this->request->data['LotJogosResultado'] = $exits['LotJogosResultado'];
                //$numb = explode(' + ', $exits['LotJogosResultado']['numeros_sorteados']);
                $numeros = $this->LotJogosNumero->find('all', [
                    'LotJogosNumero.lot_jogos_resultado_id' => $exits['LotJogosResultado']['id']
                ]);

                $numeros_extras = $this->LotJogosNumerosExtras->find('all', [
                    'LotJogosNumerosExtras.lot_jogos_resultado_id' => $exits['LotJogosResultado']['id']
                ]);

                $dezenas = array();
                for ($index = 0; $index < $dados['LotCategoria']['dezena']; $index++) {
                    foreach ($numeros as $k => $v) {
                        if ($index == $v['LotJogosNumero']['numero']) {
                            $dezenas[$index] = 1;
                        }
                    }
                }
                $dezenas2 = array();
                for ($index = 0; $index < $dados['LotCategoria']['dezena_extra']; $index++) {
                    foreach ($numeros_extras as $k => $v) {
                        if ($index == $v['LotJogosNumeroExtra']['numero']) {
                            $dezenas2[$index] = 1;
                        }
                    }
                }
                $this->set(compact('tiposJogos', 'dados', 'lotJogoId', 'dezenas2', 'dezenas'));

                $this->Session->setFlash('Resultado, já informado previamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            } else {
                $this->set(compact('tiposJogos', 'dados', 'lotJogoId'));
            }
        }
    }

    public function edit($id = null) {
        // CONFIGURA LAYOUT
        $this->layout = 'ajax';

        $this->LotJogosResultado->id = $id;
        if (!$this->LotJogosResultado->exists()) {
            throw new NotFoundException('Registro inexistente', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['LotJogosResultado']['id'] = $id;
            if ($this->LotJogosResultado->save($this->request->data)) {
                $this->Session->setFlash('Registro salvo com sucesso.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Favor tentar novamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $this->loadModel('LotCategoria');
            $gelCategorias = $this->LotCategoria->find('list', array('fields' => array('id', 'nome')));
            $this->set(compact('gelCategorias'));
        }

        $this->request->data = $this->LotJogosResultado->read(null, $id);
    }

    public function delete($id = null) {
        parent::_delete($id);
    }

    public function tabela($tipo) {
        $this->loadModel('LotJogo');
        $dados = $this->LotJogo->find('first', array('conditions' => array('LotJogo.id' => $tipo)));

        fb($dados, '$dados');
        $this->set(compact('dados'));
    }

}
