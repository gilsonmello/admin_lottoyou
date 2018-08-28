<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    protected $request;

    var $actsAs = array(
        'DateFormatter', 
        //'Containable'
    );

    public function beforeFind($query) {
        // PEGA DADOS DO SCHEMA
        $schema = $this->schema();
    }

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->request = new StdClass;
        $this->request->data = Router::getRequest()->data;
    }

    /**
     * Organiza o upload.
     *
     * @param array $imagem
     * @param string $dir
     * @param boolean $checar_nome
     * @return mixed
     */
    public function upload($imagem = array(), $dir = 'img', $checar_nome = true)
    {
        $dir = WWW_ROOT.$dir.DS;

        if(($imagem['error']!=0) and ($imagem['size']==0)) {
            throw new NotImplementedException('Alguma coisa deu errado, o upload retornou erro '.$imagem['error'].' e tamanho '.$imagem['size']);
        }

        $this->checa_dir($dir);

        if($checar_nome)
            $imagem = $this->checa_nome($imagem, $dir);

        $this->move_arquivos($imagem, $dir);

        return $imagem['name'];
    }

    /**
     * Verifica se o diretório existe, se não ele cria.
     *
     * @param $dir
     */
    public function checa_dir($dir)
    {
        App::uses('Folder', 'Utility');
        $folder = new Folder();
        if (!is_dir($dir)){
            $folder->create($dir);
        }
    }

    /**
     * Verifica se o nome do arquivo já existe, se existir adiciona um numero ao nome e verifica novamente
     *
     * @param $imagem
     * @param $dir
     * @return mixed
     */
    public function checa_nome($imagem, $dir)
    {
        $imagem_info = pathinfo($dir.$imagem['name']);
        $imagem_nome = $this->trata_nome($imagem_info['filename']).'.'.$imagem_info['extension'];
        //debug($imagem_nome);
        $conta = 2;
        while (file_exists($dir.$imagem_nome)) {
            $imagem_nome  = $this->trata_nome($imagem_info['filename']).'-'.$conta;
            $imagem_nome .= '.'.$imagem_info['extension'];
            $conta++;
            //debug($imagem_nome);
        }
        $imagem['name'] = $imagem_nome;
        return $imagem;
    }

    /**
     * Trata o nome removendo espaços, acentos e caracteres em maiúsculo.
     *
     * @param $imagem_nome
     * @return string
     */
    public function trata_nome($imagem_nome)
    {
        $imagem_nome = strtolower(Inflector::slug($imagem_nome,'-'));
        return $imagem_nome;
    }

    /**
     * Move o arquivo para a pasta de destino.
     *
     * @param $imagem
     * @param $dir
     */
    public function move_arquivos($imagem, $dir)
    {
        App::uses('File', 'Utility');
        $arquivo = new File($imagem['tmp_name']);
        $arquivo->copy($dir.$imagem['name']);
        $arquivo->close();
    }

    public function beforeValidate($options = array()) {

        $user_id = CakeSession::read('Auth.User.id');

        // PEGA DADOS DO SCHEMA
        $schema = $this->schema();

        // ON CREATE AND ON UPDATE: TRATA CAMPOS CHECKBOX ANTES DE SALVAR
        foreach($this->data as $model => $data){
            foreach ($data as $field => $value) {
                if (in_array($field, array_keys($schema))){
                    if (is_array($value)){
                        if ($schema[$field]['type'] == 'integer'){
                            $this->data[$model][$field] = $value[0];
                        }
                    } else {
                        if ($schema[$field]['type'] == 'integer' && $schema[$field]['null'] == false && ($value == null || $value == '')){
                            $this->data[$model][$field] = 0;
                        }
                    }
                }
            }
        }

        if(isset($schema['user_id'])){
            $this->data[$this->alias]['user_id'] = $user_id;
        }
        
        return parent::beforeValidate($options);
    }    

    public function formatDateToMysql($date) {
        $newDate = explode($date, '/');
        $newDate = array_reverse($newDate);
        $newDate = implode($newDate, '-');
        return $newDate;
    }
    
    public function _extractFieldsHABTM($data, $id, $chave, $lookup){
        $dados = array();
        
        if (!empty($data)){
            foreach($data as $k => $v){
                $dados[$k][$chave] = $id;
                $dados[$k][$lookup] = $v;
            }
        }
        
        return $dados;
    }

    /**
     * Checks a e-mail .
     *
     * @param string $check The value to check.
     * @return bool Success.
     */    
    public function email($check) {
        $check = array_values($check);
        $emails = explode(';',$check[0]);
        $return = true;

        foreach ($emails as $email) {
            // Remove espaços em branco
            $email = trim($email);

            //verifica se e-mail esta no formato correto de escrita
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $return = false;
            } else {
                //Valida o dominio 
                /*if(!checkdnsrr(explode('@',$email)[1],'A')){
                    $return = false;
                }*/
            }
        }   
        
        return $return; 
    }

    /**
     * Checks a phone number for Brazil.
     *
     * @param string $check The value to check.
     * @return bool Success.
     */
    public function fone($check, $requireAreaCode = true) {
        $check = array_values($check);
        $numbers = explode(';',$check[0]);
        $return = false;

        foreach ($numbers as $number) {
            if (!empty($number)) {
                $number = addcslashes(trim($number), "\n");
                if (strlen($number) > 9) {
                    $exp = "/^(\()?[1-9]{2}(?(1)\))[- ]?(\d{4})[- ]?(\d{4})$/";
                    if (preg_match($exp, $number)) {
                        $return = true;
                    }
                } else {
                    if (preg_match("/^(\d{4})[- ]?(\d{4})$/", $number)) {
                        $return = true;
                    }
                }
            } else {
                $return = true;
            }
        }

        return $return;
    }

    /**
     * Checks a postal code (CEP) for Brazil.
     *
     * @param string $check The value to check.
     * @return bool Success.
     */
    public function cep($check) {
        $check = (is_array($check)) ? implode('', $check) : $check; 
        return (bool) preg_match('/^[0-9]{2}\.[0-9]{3}\-[0-9]{3}$/', $check);
    }

    /**
     * Checks CPF for Brazil.
     *
     * @param string $check The value to check.
     * @return bool Success.
     */
    public function cpf($check) {
        $check = (is_array($check)) ? implode('', $check) : $check;
        $check = trim($check);

        // sometimes the user submits a masked CPF
        if (preg_match('/^\d\d\d.\d\d\d.\d\d\d\-\d\d/', $check)) {
            $check = str_replace(array('-', '.', '/'), '', $check);
        } elseif (!ctype_digit($check)) {
            return false;
        }
        
        if (strlen($check) != 11) {
            return false;
        }
        
        // repeated values are invalid, but algorithms fails to check it
        for ($i = 0; $i < 10; $i++) {
            if (str_repeat($i, 11) === $check) {
                return false;
            }
        }
        
        $dv = substr($check, -2);
        for ($pos = 9; $pos <= 10; $pos++) {
            $sum = 0;
            $position = $pos + 1;
            for ($i = 0; $i <= $pos - 1; $i++, $position--) {
                $sum += $check[$i] * $position;
            }
            $div = $sum % 11;
            if ($div < 2) {
                $check[$pos] = 0;
            } else {
                $check[$pos] = 11 - $div;
            }
        }
        $dvRight = $check[9] * 10 + $check[10];
        
        return ($dvRight == $dv);
    }

    /**
     * Checks CNPJ for Brazil.
     *
     * @param string $check The value to check.
     * @return bool Success.
     */
    public function cnpj($check) {
        $check = (is_array($check)) ? implode('', $check) : $check;
        $check = trim($check);
        // sometimes the user submits a masked CNPJ
        if (preg_match('/^\d\d.\d\d\d.\d\d\d\/\d\d\d\d\-\d\d/', $check)) {
            $check = str_replace(array('-', '.', '/'), '', $check);
        } elseif (!ctype_digit($check)) {
            return false;
        }

        if (strlen($check) != 14) {
            return false;
        }
        $firstSum = ($check[0] * 5) + ($check[1] * 4) + ($check[2] * 3) + ($check[3] * 2) +
            ($check[4] * 9) + ($check[5] * 8) + ($check[6] * 7) + ($check[7] * 6) +
            ($check[8] * 5) + ($check[9] * 4) + ($check[10] * 3) + ($check[11] * 2);

        $firstVerificationDigit = ($firstSum % 11) < 2 ? 0 : 11 - ($firstSum % 11);

        $secondSum = ($check[0] * 6) + ($check[1] * 5) + ($check[2] * 4) + ($check[3] * 3) +
            ($check[4] * 2) + ($check[5] * 9) + ($check[6] * 8) + ($check[7] * 7) +
            ($check[8] * 6) + ($check[9] * 5) + ($check[10] * 4) + ($check[11] * 3) +
            ($check[12] * 2);

        $secondVerificationDigit = ($secondSum % 11) < 2 ? 0 : 11 - ($secondSum % 11);

        return ($check[12] == $firstVerificationDigit) && ($check[13] == $secondVerificationDigit);
    }

    /**
     * Checks Valores do Brasil.
     *
     * @param string $check The value to check.
     * @return bool Success.
     */
    public function money($check, $config, $scale = 2) {
        // INICIALIZA VARIÁVEIS
        ini_set('precision', 16);
        $key = array_keys($check);
        $value = $check[$key[0]];

        // VERIFICA FORMATO E CONVERTE PARA O FORMATO DO BANCO SE NECESSÁRIO
        if (!is_numeric($value)){
            // VERIFICA SINAL
            $sinal = (isset($value[0]) && $value[0] == '-') ? -1 : 1; 

            // VERIFICA SCALA E CORRIGE DISTORÇÃO DE TAMANHO
            $aux = explode(',', $value);
            $check_scale_length = strlen(end($aux));
            $scale = ($check_scale_length < $scale) ? $check_scale_length : $scale;

            // FORMATA NÚMERO
            $value = (float) ereg_replace('[^0-9]', '', $value)/pow(10, $scale);
            $this->data[$this->name][$key[0]] = $value*$sinal;
        } else {
            $this->data[$this->name][$key[0]] = $value;
        }
        
        return Validation::decimal($value);
    }

    /**
     * Checks se a data informada ultrapassa o limete estabelecido
     *
     * @param string $check The value to check.
     * @return bool Success.
     */
    public function limiteData($check, $limit, $sinal = '<=') {
        // PEGA O PRIMEIRO VALOR
        $value1 = array_values($check);
        $value1 = (strpos($value1[0], '/') !== false) ? str_replace('-','',convertDate($value1[0])) : str_replace('-','',$value1[0]);

        // INICIA VARIÁVEL
        $valido = true;

        // SE LIMITE IGUAL TODAY COMPARA COM A DATA ATUAL
        if ($limit === 'today'){
            $limit = date('d/m/Y');
        } else {
            $limit = $this->data[$this->name][$limit];
        }

        // CASO O LIMITE TENHA SIDO INFORMADO
        if ($limit != ''){
            // POR DEFAULT FALSE
            $valido = false;

            // PEGA O SEGUNDO VALOR
            $value2 = str_replace('-','',convertDate($limit));
            
            // VERIFICA SE VÁLIDO
            if ($sinal == '<='){
                $valido = ($value1 <= $value2);
            } elseif($sinal == '<') {
                $valido = ($value1 < $value2);
            } elseif($sinal == '>=') {
                $valido = ($value1 >= $value2);
            } elseif($sinal == '>') {
                $valido = ($value1 > $value2);
            }
        }
        
        return $valido;
    }

    /**
     * Checks se o valor numérico informado ultrapssa o limite estabelecido
     *
     * @param string $check The value to check.
     * @return bool Success.
     */
    public function limiteNumero($check, $operator, $limit) {
        // PEGA O PRIMEIRO VALOR
        $value1 = array_values($check);
        $value1 = $value1[0];

        // INICIA VARIÁVEL
        $valido = true;
        
        // CASO O LIMITE TENHA SIDO INFORMADO
        if ($this->data[$this->name][$limit] != ''){
            // PEGA O SEGUNDO VALOR
            $value2 = $this->data[$this->name][$limit];
            
            // VERIFICA SE VÁLIDO
            if ($operator == '<='){
                $valido = ($value1 <= $value2);
            } elseif($operator == '<') {
                $valido = ($value1 < $value2);
            } elseif($operator == '>=') {
                $valido = ($value1 >= $value2);
            } elseif($operator == '>') {
                $valido = ($value1 > $value2);
            } else {
                $valido = false;
            }
        }

        return $valido;
    }
    
    /** 
     * checks is the field value is unqiue in the table 
     * note: we are overriding the default cakephp isUnique test as the original appears to be broken 
     * 
     * @param string $data Unused ($this->data is used instead) 
     * @param mnixed $fields field name (or array of field names) to validate 
     * @return boolean true if combination of fields is unique 
     */ 
    public function checkUnique($data, $fields) {
        if (!is_array($fields)) {
            $fields = array($fields);
        }
        foreach ($fields as $key) {
            $tmp[$key] = $this->data[$this->name][$key];
        }
        if (isset($this->data[$this->name][$this->primaryKey])) {
            $tmp[$this->primaryKey] = "<>" . $this->data[$this->name][$this->primaryKey];
        }
        return $this->isUnique($tmp, false);
    }
    
    /** 
     * checks is the field value is unqiue in company 
     * 
     * @param string $data Unused ($this->data is used instead) 
     * @param mnixed $fields field name (or array of field names) to validate 
     * @return boolean true if combination of fields is unique 
     */ 
    public function checkUniqueInCompany($data, $fields, $company_id) {
        if (!is_array($fields)) {
            $fields = array($fields);
        }
        
        foreach ($fields as $key) {
            $tmp[$key] = $this->data[$this->name][$key];
        }
        
        if (isset($this->data[$this->name][$this->primaryKey])) {
            $tmp[$this->primaryKey] = "<> " . $this->data[$this->name][$this->primaryKey];
        }
        fb($tmp);
        return $this->isUnique($tmp, false);
    }
    
    /** 
     * Checa se o valor de campo é identico ao de um outro campo
     * 
     * @param string $data  
     * @param mnixed $compareField field name to validate 
     * @return boolean true se os campos são identicos
     */ 
    public function notIdentical($data, $compareField) {
        $value = array_values($data);
        $comparewithvalue = $value[0];
        return ($this->data[$this->name][$compareField] !== $comparewithvalue);
    }
    
    public function limpaDouble($v) {
        if ($Cdata != "") {
            $Cdata = str_replace('.', '', $Cdata);
            $Cdata = str_replace(',', '.', $Cdata);
            $Cdata = str_replace('R$ ', '', $Cdata);
        }
        return $Cdata;
    }

    public function biggerThen($check, $field, $param) {
        if($this->data[$this->name][$field] > $param) {
            return true;
        } else {
            return false;
        }
    }

    public function lessThenOrEqual($check, $field, $field2) {
        if($this->data[$this->name][$field] <= $this->data[$this->name][$field2]) {
            return true;
        } else {
            return false;
        }
    }
    
    function checkVazio($check, $field){
        if(empty($this->data[$this->name][$field]) || $this->data[$this->name][$field] == '') {
            return false;
        } else{
            return true;
        }
    }	
    
     public function formataValorDouble($Cdata) {
        if ($Cdata != "") {
            $Cdata = str_replace(array('.', 'R$', ' ', ':', ';'), '', $Cdata);
            $Cdata = str_replace(',', '.', $Cdata);                     
        }
        return $Cdata;
    }
}
