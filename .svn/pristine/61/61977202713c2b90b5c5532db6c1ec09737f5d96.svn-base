<?php

class AppComponent extends Component {

    /**
     * Recebe e formata data em yyyy-mm-dd
     * @param type $Cdata
     * @return type
     */
    function aammdd($Cdata) {  //recebe e formata data em yyyy-mm-dd
        if ($Cdata != "") {
            $Cdate = explode("/", $Cdata);
            $Cdia = $Cdate[0];
            $Cmes = $Cdate[1];
            $Cano = $Cdate[2];
            $Cdata = $Cano . "-" . $Cmes . "-" . $Cdia;
        }
        return $Cdata;
    }

    /**
     * Recebe e formata valor em 9999999.99 
     * @param type $Cdata
     * @return type
     */
    public function formataValorDouble($Cdata) {
        if ($Cdata != "") {
            $Cdata = str_replace(array('.', '$', ' ', ':', ';'), '', $Cdata);
            $Cdata = str_replace(',', '.', $Cdata);
        }
        return $Cdata;
    }

    public function converterValorReal($valor) {
        return number_format($valor, 2, ',', '.');
    }

    /**
     * Recebe e formata data em dd/mm/yyyy
     * @param type $Cdata
     * @return type
     */
    function ddmmaa($Cdata) {
        $Cdate = explode(" ", $Cdata);
        $Cdate = explode("-", $Cdate[0]);
        $Cdia = $Cdate[2];
        $Cmes = $Cdate[1];
        $Cano = $Cdate[0];
        return $Cdia . "/" . $Cmes . "/" . $Cano;
    }

    public function moverArquivo($arquivo = null, $nome_pasta_controle = null) {
        $dadosArquivo = explode("/", $arquivo);
        $caminhoAtual = "../webroot/server/php/files/$dadosArquivo[0]/$dadosArquivo[1]";
        $caminhoDestino = "../webroot/files/$nome_pasta_controle";
        $ok = true;
        if (!empty($arquivo)) {
            if (file_exists($caminhoAtual)) {
                #verifica se o diretorio existe
                if (is_dir($caminhoDestino)) {
                    # Checa se o diretorio esta vazio
                    if (count(scandir($caminhoDestino)) <= 2) {
                        #Criar pasta para colocar o anexo
                        if (mkdir($caminhoDestino)) {
                            #copiar o arquivo para a pasta
                            //fb::info($caminhoAtual, "\$caminhoAtual");                            
                            $temp = $this->removeAcentuacao($dadosArquivo[1]);
                            $tempAux = explode(" ", $temp);
                            $aux = implode("_", $tempAux);
                            if (copy($caminhoAtual, $caminhoDestino . "/$aux")) {
                                # exclui o arquivo que foi feito upload
                                if (!unlink($caminhoAtual) && !rmdir("../webroot/server/php/files/" . $dadosArquivo[0])) {
                                    $ok = false;
                                }
                            } else {
                                $ok = false;
                            }
                        } else {
                            $ok = false;
                        }
                    } else {
                        #copiar o arquivo para a pasta
                        $temp = $this->removeAcentuacao($dadosArquivo[1]);
                        $tempAux = explode(" ", $temp);
                        $aux = implode("_", $tempAux);
                        if (copy($caminhoAtual, $caminhoDestino . "/$aux")) {
                            # exclui o arquivo que foi feito upload
                            if (!unlink($caminhoAtual) && !rmdir("../webroot/server/php/files/" . $dadosArquivo[0])) {
                                $ok = false;
                            }
                        } else {
                            $ok = false;
                        }
                    }
                } else {
                    #Criar pasta para colocar o anexo
                    if (mkdir($caminhoDestino)) {
                        #copiar o arquivo para a pasta                        
                        $temp = $this->removeAcentuacao($dadosArquivo[1]);
                        $tempAux = explode(" ", $temp);
                        $aux = implode("_", $tempAux);
                        if (copy($caminhoAtual, $caminhoDestino . "/$aux")) {
                            # exclui o arquivo que foi feito upload
                            if (!unlink($caminhoAtual) && !rmdir("../webroot/server/php/files/" . $dadosArquivo[0])) {
                                $ok = false;
                            }
                        } else {
                            $ok = false;
                        }
                    } else {
                        $ok = false;
                    }
                }
            } else {
                $ok = false;
            }
        } else {
            $ok = false;
        }
        return $ok;
    }

    // Cria uma função que retorna o timestamp de uma data no formato DD/MM/AAAA
    public function geraTimestamp($data) {
        $partes = explode('/', $data);
        return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
    }

    public function montarDadosGrafico($graficoProducao = array(), $dadosMensal = array()) {

        switch ($dadosMensal['EtapasLog']['data_inicio']) {
            case '2014-01-01':
                $graficoProducao[0]['y'] = "Jan";
                if (!isset($graficoProducao[0]['a'])) {
                    $graficoProducao[0]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[0]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-02-01':
                $graficoProducao[1]['y'] = "Fev";
                if (!isset($graficoProducao[1]['a'])) {
                    $graficoProducao[1]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[1]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-03-01':
                $graficoProducao[2]['y'] = "Mar";
                if (!isset($graficoProducao[2]['a'])) {
                    $graficoProducao[2]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[2]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-04-01':
                $graficoProducao[3]['y'] = "Abr";
                if (!isset($graficoProducao[3]['a'])) {
                    $graficoProducao[3]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[3]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-05-01':
                $graficoProducao[4]['y'] = "Mai";
                if (!isset($graficoProducao[4]['a'])) {
                    $graficoProducao[4]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[4]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-06-01':
                $graficoProducao[5]['y'] = "Jun";
                if (!isset($graficoProducao[5]['a'])) {
                    $graficoProducao[5]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[5]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-07-01':
                $graficoProducao[6]['y'] = "Jul";
                if (!isset($graficoProducao[6]['a'])) {
                    $graficoProducao[6]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[6]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-08-01':
                $graficoProducao[7]['y'] = "Ago";
                if (!isset($graficoProducao[7]['a'])) {
                    $graficoProducao[7]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[7]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-09-01':
                $graficoProducao[8]['y'] = "Set";
                if (!isset($graficoProducao[8]['a'])) {
                    $graficoProducao[8]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[8]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-10-01':
                $graficoProducao[9]['y'] = "Out";
                if (!isset($graficoProducao[9]['a'])) {
                    $graficoProducao[9]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[9]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-11-01':
                $graficoProducao[10]['y'] = "Nov";
                if (!isset($graficoProducao[10]['a'])) {
                    $graficoProducao[10]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[10]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
            case '2014-12-01':
                $graficoProducao[11]['y'] = "Dez";
                if (!isset($graficoProducao[11]['a'])) {
                    $graficoProducao[11]['a'] = $dadosMensal['EtapasLog']['quantidade'];
                } else {
                    $graficoProducao[11]['a'] += $dadosMensal['EtapasLog']['quantidade'];
                }
                break;
        }
        return $graficoProducao;
    }

    public function setaValorPadrao($valor, $padrao = "ND") {
        return (!empty($valor) && isset($valor)) ? $valor : $padrao;
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

    public function moverAnexo($nomePasta, $nomeControlePasta) {
        $ok = true;
        $arquivos = array();
        if (is_dir("../webroot/server/php/files/$nomePasta")) {

            # Verifica se existe algum arquivo no diretorio
            $arquivosDiretorio = scandir("../webroot/server/php/files/$nomePasta");
            # Busca todos os arquivos feito upload e coloca no array chamado ARQUIVO
            if (count($arquivosDiretorio) <= 3) {
                $arquivos[] = $arquivosDiretorio[2];
            } else {
                for ($i = 2; $i < count($arquivosDiretorio); $i++) {
                    $arquivos[] = $arquivosDiretorio[$i];
                }
            }
            # Mover os arquivos para pasta destino
            for ($j = 0; $j < count($arquivos); $j++) {
                $arquivo = $nomePasta . "/" . $arquivos[$j];
                if (!$this->moverArquivo($arquivo, $nomeControlePasta)) {
                    $ok = false;
                }
            }
        }
        return $arquivos;
    }

    public function removeAcentuacao($param) {
        $temp = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $param));
        return $temp;
    }

    public function ultimos5Anos() {
        $anoAtual = date('Y');
        $anoLimiteInferior = $anoAtual - 5;
        $anoLimiteSuperior = $anoAtual + 2;
        $anos = array();
        $i = $anoLimiteInferior;
        for ($i = $anoLimiteInferior; $i <= $anoLimiteSuperior; $i++) {
            $anos[$i] = $i;
        }

        return $anos;
    }

    /*
     * @param $intervalo pode ser: y, m, d, h, i, s, invert, days
     */

    public function intervaloDatas($dataInicio, $dadtaFim, $intervalo = null) {
        if (empty($intervalo)) {
            $data1 = new DateTime($dataInicio);
            $data2 = new DateTime($dadtaFim);
            $diff = $data1->diff($data2);
            $retorno = $diff->days;
        } else {
            $data1 = new DateTime($dataInicio);
            $data2 = new DateTime($dadtaFim);
            $intervalo = $data1->diff($data2);

            $retorno = $intervalo;
        }
        return $retorno;
    }

    /*
      iniciar com P e seguido de um número por último a unidade:
      Y | Ano; M | Mês; D | Dias; W | Semanas; H | Horas; M | Minutos; S | Segundos
     */

    public function addFatorNaData($date, $dias, $format = 'Y-m-d', $fator = 'D') {
        //formatos devem ser ==
        $data = new DateTime($date);
        $dias = 'P' . $dias . $fator;
        $data->add(new DateInterval($dias));
        $data2 = $data->format($format);
        return $data2;
    }

    /**
     * 
     * @param real $valor Valor Original
     * @param type $calcular Valor a ser Calculado
     * @return type $double Resultado em Porcetagem
     */
    public function resPorcentagem($valor, $calcular) {        
        $percentual = $calcular / 100.0; // 15%
        return $valor + ($percentual * $valor);
    }

}

?>
