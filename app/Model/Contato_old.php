<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP ModuloModel
 * @author 
 */
class Contato extends AppModel {

    public $belongsTo = array('User');

    public $order = 'Contato.name ASC';

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Campo obrigatório'
            ),           
        ),
        'active' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo obrigatório'
            )
        )
    );
    
    public function qtdPorCategoria($idUsuario = null, $idCategoria = "") {

        if (!empty($idUsuario)) {
            if ($idCategoria != "") {
                $sql = "select COUNT(c.id) as qtd
                        from contatos c 
                        where c.categoria_id = '$idCategoria' and c.user_id = $idUsuario ";
            } else {
                $sql = "select COUNT(c.id) as qtd 
                        from contatos c 
                        where c.user_id = $idUsuario";
            }

            $run = $this->query($sql);
            return $run;
        }
    }

}
