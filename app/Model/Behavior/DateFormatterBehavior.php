<?php 

class DateFormatterBehavior extends ModelBehavior {
    //Our  format
    var $dateFormat = 'd/m/Y';
    //datebase Format
    var $databaseFormat = 'Y-m-d';


    function _changeDateFormat($date = null, $dateFormat, $tipo){
        if($date != '0000-00-00' && $date != null){
            if ($tipo == 'S'){
                if ($date[4] != '-'){
                    $aux = explode(' ', $date);
                    $return = (count($aux) > 1) ? substr($date, 6, 4).'-'.substr($date, 3, 2) .'-'.substr($date, 0, 2).' '.$aux[1] : substr($date, 6, 4).'-'.substr($date, 3, 2) .'-'.substr($date, 0, 2);
                } else {
                    $return = $date;
                }
            } else {
                if ($dateFormat == 'Y-m-d'){
                    $return = implode("-",array_reverse(explode("/",$date)));
                } else {
                    $return  = date($dateFormat, strtotime($date));
                }
            }
        } else {
            $return = '';
        }
        
        return $return;
    }

    //This function search an array to get a date or datetime field. 
    function _changeDate($queryDataConditions , $dateFormat, $model, $tipo){
        $this->model = $model;
        if ($queryDataConditions != null){
            foreach($queryDataConditions as $key => $value){
                if(is_array($value)){
                    $queryDataConditions[$key] = $this->_changeDate($value,$dateFormat, $model, $tipo);
                } else {
                    $columns = $this->model->getColumnTypes();

                    //sacamos las columnas que no queremos
                    foreach($columns as $column => $type){
                        if(($type != 'date') && ($type != 'datetime')) unset($columns[$column]);
                    }
                    
                    //we look for date or datetime fields on database model  
                    foreach($columns as $column => $type){
                        if(strstr($key,$column)){
                            if($type == 'datetime') {
                                if (substr($key, -1) == '<' || substr($key, -2) == '<='){
                                    $queryDataConditions[$key] = $this->_changeDateFormat($value, $dateFormat.' 23:59:59', $tipo);
                                } else {
                                    $queryDataConditions[$key] = $this->_changeDateFormat($value, $dateFormat.' H:i:s', $tipo);
                                }
                            } elseif($type == 'date') {
                                $queryDataConditions[$key] = $this->_changeDateFormat($value, $dateFormat, $tipo);
                            }
                        }
                    }
                }
            }
        }
        return $queryDataConditions;
    }

    function beforeFind(Model $model, $query){
        $query['conditions'] = $this->_changeDate($query['conditions'] , $this->databaseFormat, $model, 'F');
        return $query;
    }

    function afterFind(Model $model, $results, $primary = false){
        $results = $this->_changeDate($results, $this->dateFormat, $model, 'F');
        return $results;
    }

    function beforeSave(Model $model, $options = array()) {
        $model->data = $this->_changeDate($model->data, $this->dateFormat, $model, 'S');
        return true;
    }
}