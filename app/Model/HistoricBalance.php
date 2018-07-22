<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class HistoricBalance extends AppModel {

    public $belongsTo = [
    	'Balance' => [
            'className' => 'Balance',
            'foreignKey' => 'balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'HistoricBalanceSoccer' => [
            'className' => 'HistoricBalanceSoccer',
            'foreignKey' => 'historic_balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
	];

    /*public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
        //die(var_dump($this->query));

        $recursive = -1;
        $sql = "SELECT * FROM historic_balances AS HistoricBalance INNER JOIN users Owner ON (HistoricBalance.owner_id = Owner.id)";

        if(isset($this->query['modality'])) {

            if(in_array(1, $this->query['modality'])) {
                $sql .= "UNION SELECT * FROM soc_apostas SocAposta";

                $options['joins'][] = [
                    'alias' => 'SocAposta',
                    'table' => 'soc_apostas',
                    'type' => 'LEFT',
                    'conditions' => 'SocAposta.historic_balance_id = HistoricBalance.id'
                ];
                $options['fields'][] = 'SocAposta.*';
                $options['conditions']['OR']['NOT']['LotUserJogo.id'] = null;
            }

            if(in_array(2, $this->query['modality'])) {
                $options['joins'][] = [
                    'alias' => 'LotUserJogo',
                    'table' => 'lot_users_jogos',
                    'type' => 'LEFT',
                    'conditions' => 'LotUserJogo.historic_balance_id = HistoricBalance.id'
                ];
                $options['fields'][] = 'LotUserJogo.*';
                $options['conditions']['OR']['NOT']['LotUserJogo.id'] = null;
            }

            if(in_array(3, $this->query['modality'])) {
                $options['joins'][] = [
                    'alias' => 'Raspadinha',
                    'table' => 'raspadinhas',
                    'type' => 'LEFT',
                    'conditions' => 'Raspadinha.historic_balance_id = HistoricBalance.id'
                ];
                $options['fields'][] = 'Raspadinha.*';
                $options['conditions']['OR']['NOT'][] = ['Raspadinha.id' => null];
            }

            if(in_array(4, $this->query['modality'])) {
                $options['joins'][] = [
                    'alias' => 'PedidoPaypal',
                    'table' => 'paypal_orders',
                    'type' => 'LEFT',
                    'conditions' => 'PedidoPaypal.historic_balance_id = HistoricBalance.id'
                ];
                $options['fields'][] = 'PedidoPaypal.*';
            }

            if(in_array(5, $this->query['modality'])) {
                $options['joins'][] = [
                    'alias' => 'PedidoPagseguro',
                    'table' => 'pagseguro_orders',
                    'type' => 'LEFT',
                    'conditions' => 'PedidoPagseguro.historic_balance_id = HistoricBalance.id'
                ];
                $options['fields'][] = 'PedidoPagseguro.*';
            }

            if(in_array(6, $this->query['modality'])) {
                $options['joins'][] = [
                    'alias' => 'Item',
                    'table' => 'order_items',
                    'type' => 'LEFT',
                    'conditions' => 'Item.historic_balance_id = HistoricBalance.id'
                ];
                $options['fields'][] = 'Item.*';
            }

            if(in_array(7, $this->query['modality'])) {
                $options['joins'][] = [
                    'alias' => 'BalanceInsert',
                    'table' => 'balance_inserts',
                    'type' => 'LEFT',
                    'conditions' => 'BalanceInsert.historic_balance_id = HistoricBalance.id'
                ];
                $options['fields'][] = 'BalanceInsert.*';
            }

            if(in_array(8, $this->query['modality'])) {
                $options['joins'][] = [
                    'alias' => 'RetiradaAgente',
                    'table' => 'agent_withdraw',
                    'type' => 'LEFT',
                    'conditions' => 'RetiradaAgente.historic_balance_id = HistoricBalance.id'
                ];
                $options['fields'][] = 'RetiradaAgente.*';
            }
        } else {
            $sql = "SELECT * FROM historic_balances AS HistoricBalance INNER JOIN users Owner ON (HistoricBalance.owner_id = Owner.id)";
        }

        $sql .= "LIMIT" . (($page - 1) * $limit) . ', ' . $limit;

        $results = $this->query($sql);

        return $results;
    }*/

    /**
     * Overridden paginateCount method
     */
    public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {

        $sql = "SELECT HistoricBalance.id FROM historic_balances AS HistoricBalance";

        $this->recursive = $recursive;
        $results = $this->query($sql);

        return count($results);
    }

	public $hasMany = [
    	
	];


//    public $order = 'SocBolao.nome ASC';
//    
//    public $displayField = 'nome';
//    
//    public $virtualFields = array(
//        'ativo' => "CASE WHEN SocBolao.active = 1 THEN 'Sim' ELSE 'Não' END",
//        'ativo_label' => "CASE WHEN SocBolao.active = 1 THEN 'success' ELSE 'danger' END",
//    );
//    public $validate = array(
//        'nome' => array(
//            'required' => array(
//                'rule' => array('notEmpty'),
//                'required' => true,
//                'message' => 'Campo obrigatório'
//            ),
//            'unique' => array(
//                'rule' => 'isUnique',
//                'message' => 'Nome em uso. Favor informar outro.'
//            )
//        ),
//        'active' => array(
//            'required' => array(
//                'rule' => array('notEmpty'),
//                'message' => 'Campo obrigatório'
//            )
//        )
//    );

}
