<?php

/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP 5
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
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {

    public function ddmmaa($data = null) {
        $dataAlterada = substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4);
        return $dataAlterada;
    }

    /**
     * Recebe e formata data em 01 de Janeiro de 2015
     * @param type $Cdata
     * @return type
     */
    function dataExtenso($Cdata) {
        $Cdate = explode(" ", $Cdata);
        $Cdate = explode("-", $Cdate[0]);
        $Cdia = $Cdate[2];
        $Cmes = $Cdate[1];
        $Cano = $Cdate[0];
        fb::info($Cdate, "\$Cdate");
        switch ($Cmes) :
            case '01':
                $Cmes = "Janeiro";
                break;
            case '02':
                $Cmes = "Fevereiro";
                break;
            case '03':
                $Cmes = "Março";
                break;
            case '04':
                $Cmes = "Abril";
                break;
            case '05':
                $Cmes = "Maio";
                break;
            case '06':
                $Cmes = "Junho";
                break;
            case '07':
                $Cmes = "Julho";
                break;
            case '08':
                $Cmes = "Agosto";
                break;
            case '09':
                $Cmes = "Setembro";
                break;
            case '10':
                $Cmes = "Outubro";
                break;
            case '11':
                $Cmes = "Novembro";
                break;
            case '12':
                $Cmes = "Dezembro";
                break;
        endswitch;
        return $Cdia . " de " . $Cmes . " de " . $Cano;
    }

    public function ddmmaahora($data = null) {
        $dataAlterada = substr($data, 8, 2) . "/" . substr($data, 5, 2) . "/" . substr($data, 0, 4) . " às " . substr($data, 11, 8);
        return $dataAlterada;
    }

    public function mesclarNomes($nome1, $nome2) {
        return $nome1 . " - " . "$nome2";
    }

    public function converterValorReal($valor) {
        return "<b>" . number_format($valor, 2, ',', '.') . "</b>";
    }

    public function setaValorPadrao($valor, $padrao = "ND") {
        return (!empty($valor) && isset($valor)) ? $valor : $padrao;
    }

    public function geraTimestamp($data) {
        $partes = explode('/', $data);
        return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
    }

    function extenso($valor = 0, $maiusculas = false) {
        // verifica se tem virgula decimal
        if (strpos($valor, ",") > 0) {
            // retira o ponto de milhar, se tiver
            $valor = str_replace(".", "", $valor);

            // troca a virgula decimal por ponto decimal
            $valor = str_replace(",", ".", $valor);
        }
        $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões",
            "quatrilhões");

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
            "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
            "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
            "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis",
            "sete", "oito", "nove");

        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        $cont = count($inteiro);
        for ($i = 0; $i < $cont; $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

        $fim = $cont - ($inteiro[$cont - 1] > 0 ? 1 : 2);
        $rt = '';
        for ($i = 0; $i < $cont; $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                    $ru) ? " e " : "") . $ru;
            $t = $cont - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000"
            )
                $z++; elseif ($z > 0)
                $z--;
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) &&
                        ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        if (!$maiusculas) {
            return($rt ? $rt : "zero");
        } elseif ($maiusculas == "2") {
            return (strtoupper($rt) ? strtoupper($rt) : "Zero");
        } else {
            return (ucwords($rt) ? ucwords($rt) : "Zero");
        }
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
        $value1 = str_replace('-', '', convertDate($value1[0]));

        // PEGA O SEGUNDO VALOR
        $value2 = str_replace('-', '', convertDate($this->data[$this->name][$limit]));

        $valido = false;

        if ($sinal == '<=') {
            $valido = ($value1 <= $value2);
        } elseif ($sinal == '<') {
            $valido = ($value1 < $value2);
        } elseif ($sinal == '>=') {
            $valido = ($value1 >= $value2);
        } elseif ($sinal == '>') {
            $valido = ($value1 > $value2);
        }

        return $valido;
    }
    
     public function resPorcentagem($valor, $calcular) {        
        $percentual = $calcular / 100.0; // 15%
        return $valor + ($percentual * $valor);
    }
 
}
