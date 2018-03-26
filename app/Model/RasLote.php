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

    public $belongsTo = array('TemasRaspadinha');

    public $hasMany = array('RasLotesNumero', 
        'Raspadinha' => array(
            'className' => 'Raspadinha',
            'foreignKey' => 'lote',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    //public $hasMany = array(
    //    'RaspadinhaCapaPremiacao'
    //);

    public $validate = array(
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
        'qtd_raspadinhas' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        ),
        'valor_premio' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),
        ),
        'temas_raspadinha_id' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Tema em uso.'
            ),
        ),
    );

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
            return ['status' => false, 'msg' => 'Não há valores para o lote.<br> Faça o cadastrado para continuar.'];

        if(count($numeros_possiveis) < 4)
            return ['status' => false, 'msg' => 'Cadastre pelo menos 4 números para gerar as raspadinhas.'];

        //Variável que irá conter os números aleatórios
        $numeros_aleatorios = [];

        //Pegando 10 números dentre os possíveis
        for($i = 0; $i < 9; $i++) {
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

        //Embaralhando o array
        shuffle($numeros_aleatorios);

        //die(var_dump($numeros_aleatorios));
        $ras_lotes = $this->read(null, $arr['lote_id']);
        
        //Criando os registros
        //De 0 até o total de raspadinhas não premiadas
        for($i = 0; $i < $ras_lotes['RasLote']['qtd_raspadinhas'] - $ras_lotes['RasLote']['valor_premio']; $i++) {
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

            //Embaralha os números novamente
            shuffle($numeros_aleatorios);
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
            return ['status' => false, 'msg' => 'Não há valores para o lote.<br> Faça o cadastrado para continuar.'];

        if(count($numeros_possiveis) < 4)
            return ['status' => false, 'msg' => 'Cadastre pelo menos 4 números para gerar as raspadinhas.'];

        //Variável que irá conter os números aleatórios
        $numeros_aleatorios = [];

        //Reservando 3 posições para o número premiado
        $numeros_aleatorios[0] = $arr['RasLote']['valor_premiado'];
        $numeros_aleatorios[1] = $arr['RasLote']['valor_premiado'];
        $numeros_aleatorios[2] = $arr['RasLote']['valor_premiado'];

        //Variável para a dicionar no array de números premiados
        $j = 3;

        //Pegando 10 números dentre os possíveis
        for($i = 0; $i < 6; $i++) {
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

            //Incrementando que já foi usado
            $numeros_possiveis[$rand_keys]['RasLotesNumero']['used'] += 1;

        }

        //Embaralhando o array
        shuffle($numeros_aleatorios);

        //Criando os registros
        //De 0 até o total de raspadinhas premiadas
        for($i = 0; $i < $arr['RasLote']['qtd_premiadas']; $i++) {
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

            //Embaralha os números novamente
            shuffle($numeros_aleatorios);
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
