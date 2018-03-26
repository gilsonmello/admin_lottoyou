<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP RasLoteModel
 * @author 
 */
class RaspadinhaCapaPremiacao extends AppModel {

    public $useTable = 'raspadinha_capa_premiacoes';

    public $virtualFields = array(
        
    );
    
    public $order = 'RasLote.created desc';
    
    //public $displayField = 'nome';
    
    public $belongsTo = array('TemasRaspadinha');
    
    public $validate = array(
        /*'nome' => array(
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
        ),*/
    );

    public function criarRaspadinha($arr = array()) {

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

    public function relRaspadinhas($lote) {

        $sql = "select premio, count(*) as qtd_geradas
                from raspadinhas ras where lote = $lote and ativo = 3
                group by premio";
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
