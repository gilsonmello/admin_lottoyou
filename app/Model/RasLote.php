<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP RasLoteModel
 * @author 
 */
class RasLote extends AppModel {

    public $virtualFields = array(
        'ativo' => "CASE WHEN RasLote.active = 1 THEN 'Sim' ELSE 'Não' END",
        'ativo_label' => "CASE WHEN RasLote.active = 1 THEN 'success' ELSE 'danger' END",
        'total_premiadas' => 'select count(*) from raspadinhas rasp where lote = RasLote.id and premio > 0',
        'total_geradas' => 'select count(*) from raspadinhas rasp where lote = RasLote.id',
    );
    
    public $order = 'RasLote.created desc';
    
    public $displayField = 'nome';

    public $belongsTo = ['TemasRaspadinha'];

    public $hasMany = [
        'RasLotesNumero' => [
            'className' => 'RasLotesNumero',
            'foreignKey' => 'ras_lote_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ], 
        'Raspadinha' => [
            'className' => 'Raspadinha',
            'foreignKey' => 'lote',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'RasDemo' => [
            'className' => 'RasDemo',
            'foreignKey' => 'lote_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
    ];

    //public $hasMany = array(
    //    'RaspadinhaCapaPremiacao'
    //);

    public $validate = [
        'nome' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Nome obrigatório',
                'required' => true
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Nome em uso. Favor informar outro nome'
            ),
        ),
        'qtd_raspadinhas' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],
        ],
        'valor_premio' => [
            'required' => [
                'rule' => ['notEmpty'],
                'required' => true,
                'message' => 'Campo obrigatório'
            ],            
            'lessThenOrEqual' => [
                'rule' => ['lessThenOrEqual', 'valor_premio', 'qtd_raspadinhas'],
                'message' => 'Qtd. de premiados deve ser menor ou igual a Qtd. total'
            ]
        ],        
        'value' => [
            'required' => [
                'on' => 'create',
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório',
                'required' => true
            ]
        ],
        'temas_raspadinha_id' => [
            'unique' => [
                'rule' => 'isUnique',
                'message' => 'Tema em uso.'
            ],
        ],
    ];

    private function numerosPossiveis($premiada = false, $valor_premio = 0.00, $numeros_possiveis = [], $begin = 0, $end = 0) {

        $numeros_aleatorios = [];
        if($premiada == true) {
            $numeros_aleatorios[0] = $valor_premio;
            $numeros_aleatorios[1] = $valor_premio;
            $numeros_aleatorios[2] = $valor_premio;
            $j = 3;
            //Pegando 6 números dentre os possíveis
            for($i = $begin; count($numeros_possiveis) > 0 && $i < $end; $i++) {
                $input = $numeros_possiveis;
                $rand_keys = array_rand($input, 1);

                //Se o números já foi sorteado 2 vezes, não posso repiti-lo novamente,
                //Pois somente o número sorteado se repete 3 vezes
                if($numeros_possiveis[$rand_keys]['RasLotesNumero']['used'] == 2) {
                    //Removo o número do array
                    unset($numeros_possiveis[$rand_keys]);
                    //Volto com a variável i para o valor que se encontrava ao entrar no loop
                    $i--;
                    //Saíndo do for
                    continue;
                }

                //Adiciono o número aleatório no array de números possíveis
                $numeros_aleatorios[$j] = $numeros_possiveis[$rand_keys]['RasLotesNumero']['number'];
                $j++;

                //Incrementando para informar que já foi usado
                $numeros_possiveis[$rand_keys]['RasLotesNumero']['used'] += 1;
            }
            
        } else {

            //Pegando 10 números dentre os possíveis
            for($i = $begin; count($numeros_possiveis) > 0 && $i < $end ; $i++) {

                $input = $numeros_possiveis;

                $rand_keys = array_rand($input, 1);                

                //Se o números já foi sorteado 2 vezes, não posso repiti-lo novamente,
                //Pois somente o número sorteado se repete 3 vezes
                if($numeros_possiveis[$rand_keys]['RasLotesNumero']['used'] == 2) {
                    //Removo o número do array
                    unset($numeros_possiveis[$rand_keys]);
                    //Volto com a variável i para o valor que se encontrava ao entrar no loop
                    $i--;
                    //Saíndo do for
                    continue;
                }

                //Adiciono o número aleatório no array de números possíveis
                $numeros_aleatorios[] = $numeros_possiveis[$rand_keys]['RasLotesNumero']['number'];

                //Incrementando para informar que já foi usado
                $numeros_possiveis[$rand_keys]['RasLotesNumero']['used'] += 1;
            }
        }



        return $numeros_aleatorios;
    }

    public function criarRaspadinhaDemo($arr = array()) {

        if(isset($arr['RasDemo']['valor_premiado']) && $arr['RasDemo']['valor_premiado'] > 0) {
            //Buscando números possíveis
            $numeros_possiveis = $this->RasLotesNumero->find('all', [
                'fields' => ['RasLotesNumero.number', 'RasLotesNumero.used'],
                'conditions' => [
                    'RasLotesNumero.ras_lote_id' => $arr['RasDemo']['lote_id'],
                    'RasLotesNumero.active' => 1,
                    'RasLotesNumero.number <>' => $arr['RasDemo']['valor_premiado']
                ]
            ]);
        }else {
            //Buscando números possíveis
            $numeros_possiveis = $this->RasLotesNumero->find('all', [
                'fields' => ['RasLotesNumero.number', 'RasLotesNumero.used'],
                'conditions' => [
                    'RasLotesNumero.ras_lote_id' => $arr['RasDemo']['lote_id'],
                    'RasLotesNumero.active' => 1
                ]
            ]);
        }


        if(count($numeros_possiveis) == 0)
            return ['status' => false, 'msg' => 'Não há valores para o lote.<br> Faça o cadastro para continuar.'];

        if(count($numeros_possiveis) < 4 && $arr['RasDemo']['valor_premiado'] > 0)
            return ['status' => false, 'msg' => 'Cadastre pelo menos 4 números para gerar as raspadinhas.'];
        else if(count($numeros_possiveis) < 5 && $arr['RasDemo']['valor_premiado'] < 0)
            return ['status' => false, 'msg' => 'Cadastre pelo menos 5 números para gerar as raspadinhas.'];



        $numeros_aleatorios = [];
        if($arr['RasDemo']['valor_premiado'] > 0) {
            $numeros_aleatorios = $this->numerosPossiveis(true, $arr['RasDemo']['valor_premiado'], $numeros_possiveis, 0, 6);
        } else {
            $numeros_aleatorios = $this->numerosPossiveis(false, 0.00, $numeros_possiveis, 0, 9);
        }
                               
        //Criando os registros
        //De 0 até o total de raspadinhas não premiadas
        for($i = 0; $i < $arr['RasDemo']['qtd_raspadinhas']; $i++) {

            //Embaralhando o array
            shuffle($numeros_aleatorios);
            
            $raspadinha['RasDemo']['lote_id'] = $arr['RasDemo']['lote_id'];
            $raspadinha['RasDemo']['temas_raspadinha_id'] = $arr['RasDemo']['temas_raspadinha_id'];
            $raspadinha['RasDemo']['premio'] = $arr['RasDemo']['valor_premiado'] > 0 ? $arr['RasDemo']['valor_premiado'] : 0.00;
            $raspadinha['RasDemo']['ativo'] = 0;
            //Pegando os números aleatórios
            for($j = 0; $j < count($numeros_aleatorios); $j++) {
                $raspadinha['RasDemo']['valor'.($j+1)] = $numeros_aleatorios[$j];
            }
            $raspadinha['RasDemo']['valor10'] = 0.00;
            $this->RasDemo->create(true);
            $this->RasDemo->save($raspadinha);
        }
        
        return ['status' => true, 'msg' => 'Salvo com Sucesso'];

    }

    public function criarRaspadinhaNaoPremiada($arr = array()) {

        //Buscando números possíveis
        $numeros_possiveis = $this->RasLotesNumero->find('all', [
            'fields' => ['RasLotesNumero.number', 'RasLotesNumero.used'],
            'conditions' => [
                'RasLotesNumero.ras_lote_id' => $arr['lote_id'],
                'RasLotesNumero.active' => 1
            ]
        ]);

        if(count($numeros_possiveis) == 0)
            return ['status' => false, 'msg' => 'Não há valores para o lote.<br> Faça o cadastro para continuar.'];

        if(count($numeros_possiveis) < 5)
            return ['status' => false, 'msg' => 'Cadastre pelo menos 5 números para gerar as raspadinhas.'];

        //Variável que irá conter os números aleatórios
        $numeros_aleatorios = $this->numerosPossiveis(false, 0.00, $numeros_possiveis, 0, 9);        

        //die(var_dump($numeros_aleatorios));
        $ras_lotes = $this->read(null, $arr['lote_id']);
        
        //Criando os registros
        //De 0 até o total de raspadinhas não premiadas
        for($i = 0; $i < $ras_lotes['RasLote']['qtd_raspadinhas'] - $ras_lotes['RasLote']['valor_premio']; $i++) {
            //Embaralhando o array
            shuffle($numeros_aleatorios);
            $raspadinha['Raspadinha']['lote'] = $arr['lote_id'];
            $raspadinha['Raspadinha']['temas_raspadinha_id'] = $arr['tema_id'];
            $raspadinha['Raspadinha']['premio'] = 0;
            $raspadinha['Raspadinha']['ativo'] = 0;
            //Pegando os números aleatórios
            for($j = 0; $j < count($numeros_aleatorios); $j++) {
                $raspadinha['Raspadinha']['valor'.($j+1)] = $numeros_aleatorios[$j];
            }
            $raspadinha['Raspadinha']['valor10'] = 0.00;
            $this->Raspadinha->create(true);
            $this->Raspadinha->save($raspadinha);
        }
        
        return true;

    }

    public function criarRaspadinhaPremiada($arr = array()) {
        $numeros_possiveis = [];

        if(isset($arr['RasLote']['valor_premiado'])) {
            //Buscando números possíveis
            $numeros_possiveis = $this->RasLotesNumero->find('all', [
                'fields' => ['RasLotesNumero.number', 'RasLotesNumero.used'],
                'conditions' => [
                    'RasLotesNumero.ras_lote_id' => $arr['RasLote']['lote_id'],
                    'RasLotesNumero.active' => 1,
                    'RasLotesNumero.number <>' => $arr['RasLote']['valor_premiado']
                ]
            ]);
        }
        

        if(count($numeros_possiveis) == 0)
            return ['status' => false, 'msg' => 'Não há valores para o lote.<br> Faça o cadastro para continuar.'];

        if(count($numeros_possiveis) < 4)
            return ['status' => false, 'msg' => 'Cadastre pelo menos 4 números para gerar as raspadinhas.'];

        $numeros_aleatorios = $this->numerosPossiveis(true, $arr['RasLote']['valor_premiado'], $numeros_possiveis, 0, 6);


        //Criando os registros
        //De 0 até o total de raspadinhas premiadas
        for($i = 0; $i < $arr['RasLote']['qtd_premiadas']; $i++) {
            //Embaralhando o array
            shuffle($numeros_aleatorios);
            $raspadinha['Raspadinha']['lote'] = $arr['RasLote']['lote_id'];
            $raspadinha['Raspadinha']['temas_raspadinha_id'] = $arr['RasLote']['tema_id'];
            $raspadinha['Raspadinha']['premio'] = $arr['RasLote']['valor_premiado'];
            $raspadinha['Raspadinha']['ativo'] = 0;
            //Pegando os números aleatórios
            for($j = 0; $j < count($numeros_aleatorios); $j++) {
                $raspadinha['Raspadinha']['valor'.($j+1)] = $numeros_aleatorios[$j];
            }
            $raspadinha['Raspadinha']['valor10'] = 0.00;
            $this->Raspadinha->create(true);
            $this->Raspadinha->save($raspadinha);

        }
        
        return true;
    }

    /*public function criarRaspadinha($arr = array()) {

        $lote_id = $arr['RasLote']['lote_id'];
        $qtd_premiadas = $arr['RasLote']['qtd_premiadas'];
        $qtd_geradas = $arr['RasLote']['qtd_geradas'];
        $user_id = $arr['RasLote']['user_id'];
        $valor_premiado = $arr['RasLote']['valor_premiado'];
        $tema_id = $arr['RasLote']['tema_id'];

        $sql = "call sp_criar_raspadinha($lote_id, $qtd_premiadas, $qtd_geradas, $user_id, $valor_premiado, $tema_id);";
        $run = $this->query($sql);
        return $run;
    }
*/
    public function relRaspadinhas($lote) {

        $sql = "select premio, count(*) as qtd_geradas
                from raspadinhas ras where lote = $lote
                group by premio
                having premio > 0";
        $run = $this->query($sql);
        return $run;
    }

    public function relRaspadinhasSemPremio($lote) {

        $sql = "select premio, count(*) as qtd_geradas
                from raspadinhas ras where lote = $lote
                group by premio
                having premio = 0";
        $run = $this->query($sql);
        return $run;
    }

}
