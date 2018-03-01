<?php

class RaspadinhasController extends AppController {

    public function index($modal = 0) {

        $lotes = $this->Raspadinha->find('list', array(
            'fields' => array('lote'),
//            'conditions' => array('Raspadinha.user_id' => NULL, 'Raspadinha.ativo' => 0),
            'group' => array('lote'),
        ));

        $this->loadModel('RasLote');
        $temas = $this->RasLote->find('all', array(
            'fields' => array('TemasRaspadinha.*'),
            'conditions' => array(
                'RasLote.active' => 1,
                'RasLote.id' => $lotes,
            ),
        ));
//        fb::info($temas, "\$temas");
        $this->set(compact('modal', 'temas'));
    }

    public function jogar($raspTema = null) {
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!empty($this->request->data['jogar'])) {

                $raspadinha = $this->Raspadinha->find('first', array(
                    'conditions' => array(
                        'Raspadinha.ativo' => 0,
                        'Raspadinha.temas_raspadinha_id' => $raspTema,
                        'Raspadinha.user_id' => $this->Session->read("Auth.User.id")
                    ),
                    'fields' => array('id', 'valor1', 'valor2', 'valor3',
                        'valor4', 'valor5', 'valor6',
                        'valor7', 'valor8', 'valor9'),
                    'order' => 'rand()',
                ));

                $i = 0;
                $dados = array();
                foreach ($raspadinha['Raspadinha'] as $k => $value) {
                    $dados[$i] = $value;
                    $i++;
                }

                //die(var_dump($dados));

                $alteraRaspadinha = array();
                $alteraRaspadinha['Raspadinha']['id'] = $raspadinha['Raspadinha']['id'];
                $alteraRaspadinha['Raspadinha']['ativo'] = 1;
                $dados[10] = $this->verificaValores($dados);

//                if (!$this->Raspadinha->save($alteraRaspadinha)) {
//                    $msg = 'Não foi possível iniciar o jogo, tente novamente!';
//                    $class = "alert-danger";
//                    $ok = false;
//                }
                $this->loadModel('TemasRaspadinha');
                $tema = $this->TemasRaspadinha->find('first', array(
                    'conditions' => array(
                        'id' => $raspTema
                    ),
                ));

                $dados[11] = "../app/webroot/" . $tema['TemasRaspadinha']['img_capa_url'];

                $this->autoRender = false;
                $this->response->type('json');
                $json = json_encode($dados);
                $this->response->body($json);
            } else {
//                fb('else do post');
                $this->loadModel('TemasRaspadinha');
                $tema = $this->TemasRaspadinha->find('first', array(
                    'conditions' => array(
                        'id' => $raspTema
                    ),
                ));

                $capaRaspadinha[0] = "../app/webroot/" . $tema['TemasRaspadinha']['img_capa_url'];


                $this->autoRender = false;
                $this->response->type('json');
                $json = json_encode($capaRaspadinha[0]);
                $this->response->body($json);
            }

            $msg = "Registro salvo com sucesso.";
            $class = "alert-success";
            $ok = true;
        } else {
//            fb('get');
            $this->loadModel('TemasRaspadinha');
            $temaRaspadinha = $this->TemasRaspadinha->find('first', array(
                'conditions' => array(
                    'id' => $raspTema
                ),
                'fields' => array('cor_texto_raspadinha', 'texto_raspadinha', 'img_background_url')
            ));
            $corTextoRasp = $temaRaspadinha['TemasRaspadinha']['cor_texto_raspadinha'];
            $textoRaspadinha = $temaRaspadinha['TemasRaspadinha']['texto_raspadinha'];
            $background = "url('../" . $temaRaspadinha['TemasRaspadinha']['img_background_url'] . "');";
            $quantidadeRaspadinha = $this->Raspadinha->find('count', array(
                'conditions' => array(
                    'Raspadinha.user_id' => $this->Session->read("Auth.User.id"),
                    'Raspadinha.ativo' => 0,
                    'Raspadinha.temas_raspadinha_id' => $raspTema,
                ),
            ));

            $this->set(compact('quantidadeRaspadinha', 'background', 'corTextoRasp', 'textoRaspadinha'));
        }
    }

    public function edit($id = null) {
        
    }

    public function win() {
        
    }

    function verificaValores($valores) {
        $valor002 = 0;
        $valor005 = 0;
        $valor01 = 0;
        $valor025 = 0;
        $valor1 = 0;
        $valor10 = 0;
        $valor25 = 0;
        $valor50 = 0;
        $valor100 = 0;
        $valor500 = 0;
        $valorTotal = 0;
        foreach ($valores as $k => $value) {
            switch ($value) {
                case 0.02:
                    $valor002++;
                    break;

                case 0.05:
                    $valor005++;
                    break;

                case 0.1:
                    $valor01++;
                    break;

                case 0.25:
                    $valor025++;
                    break;

                case 10:
                    $valor10++;
                    break;

                case 25:
                    $valor25++;
                    break;

                case 50:
                    $valor50++;
                    break;

                case 100:
                    $valor100++;
                    break;

                case 500:
                    $valor500++;
                    break;

                default:
                    break;
            }
        }
        if ($valor002 == 3) {
            $valorTotal = 0.02;
        }
        if ($valor005 == 3) {
            $valorTotal = $valorTotal + 0.05;
        }
        if ($valor01 == 3) {
            $valorTotal = $valorTotal + 0.10;
        }
        if ($valor025 == 3) {
            $valorTotal = $valorTotal + 0.25;
        }
        if ($valor1 == 3) {
            $valorTotal = $valorTotal + 1;
        }
        if ($valor10 == 3) {
            $valorTotal = $valorTotal + 10;
        }
        if ($valor25 == 3) {
            $valorTotal = $valorTotal + 25;
        }
        if ($valor50 == 3) {
            $valorTotal = $valorTotal + 50;
        }
        if ($valor100 == 3) {
            $valorTotal = $valorTotal + 100;
        }
        if ($valor500 == 3) {
            $valorTotal = $valorTotal + 500;
        }

        return $valorTotal;
    }

}
