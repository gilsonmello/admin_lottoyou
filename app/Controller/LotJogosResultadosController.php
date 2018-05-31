<?php

class LotJogosResultadosController extends AppController {

    public function index($modal = 0) {
        // CARREGA FUNÇÕES BÁSICAS DE PESQUISA E ORDENAÇÃO
        $options = parent::_index();

        // PREPARA MODEL
        $this->LotJogosResultado->recursive = 1;
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

                //Pegando os dados do sorteio
                $this->loadModel('LotJogo');
                $this->LotJogo->recursive = -1;
                $jogo = $this->LotJogo->find('first', [
                    'conditions' => [
                        'LotJogo.id' => $lotJogoId
                    ]
                ]);

                //Pegando os dados da categoria
                $this->loadModel('LotCategoria');
                $this->LotCategoria->recursive = -1;
                $categoria = $this->LotCategoria->find('first', [
                    'conditions' => [
                        'LotCategoria.id' => $jogo['LotJogo']['lot_categoria_id']
                    ]
                ]);

                //Atualizando o resultado do jogo
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
                /*
                 * Serve para percorrer os números, verifica se não é vazio
                 * Insere o número na tabela de números do jogo
                 *
                 */
                foreach ($this->request->data['D'] as $v) {
                    if (!is_array($v) && !empty($v)) {
                        $this->LotJogosNumero->create();
                        $numero['LotJogosNumero']['numero'] = $v;
                        $numero['LotJogosNumero']['lot_jogos_resultado_id'] = $this->LotJogosResultado->getLastInsertId();
                        $this->LotJogosNumero->save($numero);
                    }
                }
                //$data['LotJogosResultado']['numeros_sorteados_extra'] = '';

                /*
                 * Serve para percorrer os números extras, verifica se não é vazio
                 * Insere o número extra na tabela de números extras do jogo
                 *
                 */
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

                //
                $this->loadModel('LotUserJogo');
                $this->loadModel('LotUserNumero');
                $this->loadModel('LotUserNumeroExtra');
                $this->LotUserJogo->recursive = -1;
                $this->LotUserNumero->recursive = -1;
                $this->LotUserNumeroExtra->recursive = -1;

                /*
                 * Pegando as apostas feitas pelos os usuários
                 */
                $users_jogos = $this->LotUserJogo->find('all', [
                    'conditions' => [
                        'LotUserJogo.lot_jogo_id' => $lotJogoId
                    ]
                ]);

                /*
                 * Percorrendo as apostas
                 */
                foreach ($users_jogos as $key => $value) {
                    /*
                     * Pegando os números da aposta do usuário
                     */
                    $user_numeros = $this->LotUserNumero->find('all', [
                        'conditions' => [
                            'LotUserNumero.lot_users_jogo_id' => $value['LotUserJogo']['id']
                        ]
                    ]);

                    /*
                     * Loop para comparar se os números do jogo sorteado são iguais a do usuário
                     * Se acertou, incrementa a variável
                     * Variável para contar quantos números o usuário acertou
                     */
                    $contador1 = 0;
                    //Número sorteados
                    if(isset($this->request->data['D'])) { 
                        foreach ($this->request->data['D'] as $v) {
                            foreach ($user_numeros as $key => $numero) {  
                                if($v == $numero['LotUserNumero']['numero']) {
                                    $numero_extra['LotUserNumero']['acerto'] = 1;
                                    $this->LotUserNumero->save($numero_extra);
                                    $contador1++;
                                }
                            }
                        }
                        
                    }

                    /*
                     * Pegando os números extras da aposta do usuário
                     */
                    $user_numeros_extras = $this->LotUserNumeroExtra->find('all', [
                        'conditions' => [
                            'LotUserNumeroExtra.lot_users_jogo_id' => $value['LotUserJogo']['id']
                        ]
                    ]);

                    /*
                     * Loop para comparar se os números extra do jogo sorteado são iguais a do usuário
                     * Se acertou, incrementa a variável
                     * Variável para contar quantos números extras o usuário acertou
                     */
                    $contador2 = 0;
                    if(isset($this->request->data['d'])) { 
                        foreach ($this->request->data['d'] as $v) {
                            foreach ($user_numeros_extras as $key => $numero_extra) {                            
                                if($v == $numero_extra['LotUserNumeroExtra']['numero']) {
                                    $numero_extra['LotUserNumeroExtra']['acerto'] = 1;
                                    $this->LotUserNumeroExtra->save($numero_extra);
                                    $contador2++;
                                }
                            }
                        }
                    }

                    //Quantos números o usuário acertou
                    $value['LotUserJogo']['num_acerto'] = $contador1;
                    //Quantos números extras o usuário acertou
                    $value['LotUserJogo']['num_acerto_extra'] = $contador2;
                    //Número total de acerto
                    $value['LotUserJogo']['num_total'] = $contador1;

                    $value['LotUserJogo']['vencedor'] = 0;
                    /*
                     * Caso o usuário acertou todos os números possíveis, fazer a soma dos números normais e extras
                     */
                    if($contador1 == $categoria['LotCategoria']['max_assertos']) {
                        $value['LotUserJogo']['num_total'] = $contador1 + $contador2;
                    }

                    //Salvando as informações da aposta
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
                    'conditions' => [
                        'LotJogosNumero.lot_jogos_resultado_id' => $exits['LotJogosResultado']['id']
                    ]
                ]);

                $numeros_extras = $this->LotJogosNumerosExtras->find('all', [
                    'conditions' => [
                        'LotJogosNumerosExtras.lot_jogos_resultado_id' => $exits['LotJogosResultado']['id']
                    ]
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

                $informado = 1;
                $this->set(compact('tiposJogos', 'dados', 'lotJogoId', 'dezenas2', 'dezenas', 'informado'));

                $this->Session->setFlash('Resultado, já informado previamente.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            } else {
                $informado = 0;
                $this->set(compact('tiposJogos', 'dados', 'lotJogoId', 'informado'));
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
