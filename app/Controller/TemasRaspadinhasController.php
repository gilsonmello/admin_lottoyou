<?php

App::uses('AppController', 'Controller');

/**
 * Empresas Controller
 *
 * @property Empresa $Empresa
 * @property PaginatorComponent $Paginator
 */
class TemasRaspadinhasController extends AppController {

    public $components = array('App');

    public function index($modal = null) {
        $temas = $this->TemasRaspadinha->find('all', array(
            'conditions' => array(
                'ativo' => 1
            ),
        ));

        $this->set(compact('temas', 'modal'));
    }

    public function view($id = null) {
        
    }

    public function add() {
        if ($this->request->is('post')) {
            $ok = true;
            $msg = "Salvo com Sucesso";
            $class = "alert alert-success";
            $nomeTema = $this->request->data['TemasRaspadinha']['nome'];
            $idUser = $this->Session->read('Auth.User.id');

            $background['jpg'] = 'files/temp/' . $idUser . '/background.jpg';
            $background['jpeg'] = 'files/temp/' . $idUser . '/background.jpeg';

            if ($this->moveArquivos($idUser, $nomeTema)) {

                if (fileExistsInPath($background['jpg'])) {
                    $this->request->data['TemasRaspadinha']['img_background_url'] = 'files/RaspadinhasTemas/' . $nomeTema . '/background.jpg';
                }else if(fileExistsInPath($background['jpeg'])){
                    $this->request->data['TemasRaspadinha']['img_background_url'] = 'files/RaspadinhasTemas/' . $nomeTema . '/background.jpeg';
                }

                $this->request->data['TemasRaspadinha']['img_capa_url'] = 'files/RaspadinhasTemas/' . $nomeTema . '/capa.png';
                $this->request->data['TemasRaspadinha']['img_card_url'] = 'files/RaspadinhasTemas/' . $nomeTema . '/imagemIndex.png';
                $this->loadModel('TemasRaspadinha');

                
                if (!$this->TemasRaspadinha->save($this->request->data)) {
                    $ok = false;
                    $msg = "Não foi possível salvar o seu registro, tente novamente!";
                    $class = "alert alert-danger";
                }
            } else {
                $validImg = 0;
                $capa = 'files/temp/' . $idUser . '/capa.png';
                $imagemIndex = 'files/temp/' . $idUser . '/imagemIndex.png';
                $class = "alert alert-danger";
                $msg = "Restando a(s) seguinte(s) imagem(ens):<br>";
                if (!fileExistsInPath($background['jpg']) && !fileExistsInPath($background['jpeg'])) {
                    $msg .= "<b>Background!</b><br>";
                }

                if (!fileExistsInPath($capa)) {
                    $msg .= "<b>Capa!</b><br>";
                }

                if (!fileExistsInPath($imagemIndex)) {
                    $msg .= "<b>Imagem do Index!</b>";
                }
                $ok = false;
            }
            $this->Session->setFlash($msg, 'alert', array('plugin' => 'BoostCake', 'class' => $class));
        }
    }

    public function edit($id = null) {
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Empresa->save($this->request->data)) {
                
            }
        }
    }

    public function delete($id = null) {

        $this->loadModel('Raspadinha');
        $this->Raspadinha->recursive = -1;
        $verificaRaspadinhas = $this->Raspadinha->find('first', array(
            'conditions' => array(
                'temas_raspadinha_id' => $id
            ),
        ));

        if (empty($verificaRaspadinhas)) {
            parent::_delete($id);
        } else {
            $msg = 'Não foi possível excluir o registro selecionado, pois o mesmo tem raspadinhas vinculadas.';
            $error = 1;
            echo json_encode(compact('error', 'msg', 'exception', 'code'));
            exit;
        }
    }

    public function up($tipoArquivo = null) {
        $error = 0;
        if (!empty($_FILES)) {
            $id = $this->Session->read('Auth.User.id');
            $tempFile = $_FILES['files']['tmp_name'][0];
            $targetPath = 'files/temp/' . $id . '/';
            $extensionFile = pathinfo($_FILES['files']['name'][0], PATHINFO_EXTENSION);
            $sizeFile = $_FILES['files']['size'][0];
            $newFileName = '';

            switch ($tipoArquivo):
                case 1:
                    $newFileName = 'background' . '.' . $extensionFile;
                    break;

                case 2:
                    $newFileName = 'capa' . '.' . $extensionFile;
                    break;

                case 3:
                    $newFileName = 'imagemIndex' . '.' . $extensionFile;
                    break;
            endswitch;

            if (!fileExistsInPath($targetPath)) {
                mkdir($targetPath, 0775, true);

                $targetFile = $targetPath . $newFileName;
                if (move_uploaded_file($tempFile, $targetFile)) {
                    $this->Session->write('Imagem.targetPath', $targetPath);
                    $this->Session->write('Imagem.newFileName', $newFileName);
                    $this->Session->write('Imagem.targetFile', $targetFile);
                    $this->Session->write('Imagem.sizeFile', $sizeFile);
                } else {
                    $error = 1;
                }
            } else {

                $targetFile = $targetPath . $newFileName;
                if (move_uploaded_file($tempFile, $targetFile)) {
                    $this->Session->write('Imagem.targetPath', $targetPath);
                    $this->Session->write('Imagem.newFileName', $newFileName);
                    $this->Session->write('Imagem.targetFile', $targetFile);
                    $this->Session->write('Imagem.sizeFile', $sizeFile);
                } else {
                    $error = 1;
                }
            }
        }
        $_FILES = "";
        echo json_encode(compact('error'));
        exit;
    }

    public function moveArquivos($idUser, $nomeTema) {

//        $arquivo = $this->Session->read('Imagem.targetPath') . $this->Session->read('Imagem.newFileName');
        $ok = true;
        $validImg = 0;
        $background['jpg'] = 'files/temp/' . $idUser . '/background.jpg';
        $background['jpeg'] ='files/temp/' . $idUser . '/background.jpeg';
        $capa = 'files/temp/' . $idUser . '/capa.png';
        $imagemIndex = 'files/temp/' . $idUser . '/imagemIndex.png';
        $targetPathBg = 'files/RaspadinhasTemas/' . $nomeTema . '/background.jpg';
        $targetPathCapa = 'files/RaspadinhasTemas/' . $nomeTema . '/capa.png';
        $targetPathImgIndex = 'files/RaspadinhasTemas/' . $nomeTema . '/imagemIndex.png';
        $diretorioPasta = 'files/RaspadinhasTemas/' . $nomeTema . '/';


        if (!fileExistsInPath($background['jpg']) && !fileExistsInPath($background['jpeg'])) {
            $ok = false;
            $validImg++;
        }

        if (!fileExistsInPath($capa)) {
            $ok = false;
            $validImg++;
        }

        if (!fileExistsInPath($imagemIndex)) {
            $ok = false;
            $validImg++;
        }

        if ($validImg == 0 && $ok == true) {
            mkdir($diretorioPasta, 0775, true);

            copy($background['jpg'], $targetPathBg);
            copy($background['jpeg'], $targetPathBg);
            copy($capa, $targetPathCapa);
            copy($imagemIndex, $targetPathImgIndex);

            unlink($background);
            unlink($capa);
            unlink($imagemIndex);
        }
        $this->Session->setFlash($msg, 'alert', array('plugin' => 'BoostCake', 'class' => $class));
        $this->Session->delete('Imagem');
        return $ok;
    }

    public function demo($id = null) {

        if ($this->request->is('post') || $this->request->is('put')) {
            $tema = $this->TemasRaspadinha->find('first', array(
                'conditions' => array(
                    'id' => $id
                ),
            ));

            $capaRaspadinha[0] = "./app/webroot/" . $tema['TemasRaspadinha']['img_capa_url'];

            $this->autoRender = false;
            $this->response->type('json');
            $json = json_encode($capaRaspadinha[0]);
            $this->response->body($json);
        } else {
            $tema = $this->TemasRaspadinha->find('first', array(
                'conditions' => array(
                    'id' => $id
                ),
            ));



            $corTextoRasp = $tema['TemasRaspadinha']['cor_texto_raspadinha'];
            $textoRaspadinha = $tema['TemasRaspadinha']['texto_raspadinha'];
            $background = "url('./" . $tema['TemasRaspadinha']['img_background_url'] . "');";

            $this->set(compact('corTextoRasp', 'textoRaspadinha', 'background'));
        }
    }

}
