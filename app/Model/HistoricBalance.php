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

    public $hasOne = [
        'LotUserJogo' => [
            'className' => 'LotUserJogo',
            'foreignKey' => 'historic_balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'SocAposta' => [
            'className' => 'SocAposta',
            'foreignKey' => 'historic_balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Raspadinha' => [
            'className' => 'Raspadinha',
            'foreignKey' => 'historic_balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'PedidoPaypal' => [
            'className' => 'PedidoPaypal',
            'foreignKey' => 'historic_balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'PedidoPagseguro' => [
            'className' => 'PedidoPagseguro',
            'foreignKey' => 'historic_balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Item' => [
            'className' => 'OrderItem',
            'foreignKey' => 'historic_balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'BalanceInsert' => [
            'className' => 'BalanceInsert',
            'foreignKey' => 'historic_balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'RetiradaAgente' => [
            'className' => 'RetiradaAgente',
            'foreignKey' => 'historic_balance_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'BalanceWithdraw' => [
            'className' => 'BalanceWithdraw',
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
    /*public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {

        $sql = "SELECT HistoricBalance.id FROM historic_balances AS HistoricBalance";

        $this->recursive = $recursive;
        $results = $this->query($sql);

        return count($results);
    }*/

	public $hasMany = [
    	
	];

    public function getSocAposta($id) {
        $this->SocAposta->recursive = -1;
        $aposta = $this->SocAposta->find('first', [
            'conditions' => [
                'SocAposta.historic_balance_id' => $id
            ],
            'fields' => [
                'SocAposta.id'
            ]
        ]);

        return $aposta;
    }

    public function getLotUserJogo($id) {
        $this->LotUserJogo->recursive = -1;
        return $this->LotUserJogo->find('first', [
            'conditions' => [
                'LotUserJogo.historic_balance_id' => $id
            ],
            'fields' => [
                'LotUserJogo.id'
            ]
        ]);
    }

    public function getRaspadinha($id) {
        $this->Raspadinha->recursive = -1;
        return $this->Raspadinha->find('first', [
            'conditions' => [
                'Raspadinha.historic_balance_id' => $id
            ],
            'fields' => [
                'Raspadinha.id'
            ]
        ]);
    }

    public function getPedidoPaypal($id) {
        $this->PedidoPaypal->recursive = -1;
        return $this->PedidoPaypal->find('first', [
            'conditions' => [
                'PedidoPaypal.historic_balance_id' => $id
            ],
            'fields' => [
                'PedidoPaypal.id'
            ]
        ]);
    }

    public function getPedidoPagseguro($id) {
        $this->PedidoPagseguro->recursive = -1;
        return $this->PedidoPagseguro->find('first', [
            'conditions' => [
                'PedidoPagseguro.historic_balance_id' => $id
            ],
            'fields' => [
                'PedidoPagseguro.id'
            ]
        ]);
    }

    public function getItem($id) {
        $this->Item->recursive = -1;
        return $this->Item->find('first', [
            'conditions' => [
                'Item.historic_balance_id' => $id
            ],
            'fields' => [
                'Item.id'
            ]
        ]);
    }

    public function getBalanceInsert($id) {
        $this->BalanceInsert->recursive = -1;
        return $this->BalanceInsert->find('first', [
            'conditions' => [
                'BalanceInsert.historic_balance_id' => $id
            ],
            'fields' => [
                'BalanceInsert.id'
            ]
        ]);
    }

    public function getRetiradaAgente($id) {
        $this->RetiradaAgente->recursive = -1;
        return $this->RetiradaAgente->find('first', [
            'conditions' => [
                'RetiradaAgente.historic_balance_id' => $id
            ],
            'fields' => [
                'RetiradaAgente.id'
            ]
        ]);
    }

    public function getBalanceWithdraw($id) {
        $this->BalanceWithdraw->recursive = -1;
        return $this->BalanceWithdraw->find('first', [
            'conditions' => [
                'BalanceWithdraw.historic_balance_id' => $id
            ],
            'fields' => [
                'BalanceWithdraw.id'
            ]
        ]);
    }


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
