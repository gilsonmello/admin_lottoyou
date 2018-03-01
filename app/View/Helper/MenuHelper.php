<?php 

App::uses('AppHelper', 'View/Helper'); 

class MenuHelper extends AppHelper { 

    public $helpers = array('Session');

    public function link($titulo, $url, $options) { 
        
        $icon = @$options['icon'];
        $js   = @$options['requestJS'];

        // VERIFICA SE O USUÁRIO TEM PERMISSÃO PARA ACESSAR A FUNCIONALIDADE
        $permissions = $this->Session->read('Auth.User.Permission');

        if (is_string($url)){
            $aux = explode('/', ($url[0] == '/') ? substr($url, 1) : $url);
            $tmp = ($aux[1] == '') ? 'index' : $aux[1];
            $aux = $aux[0].'.'.$tmp;
            
            if (!in_array($aux, $permissions)){
                return false;
            }
        } else {
            foreach ($url as $i => $p) {
                $aux = explode('/', ($p['url'][0] == '/') ? substr($p['url'], 1) : $p['url']);
                $tmp = ($aux[1] == '') ? 'index' : $aux[1];
                $aux = $aux[0].'.'.$tmp;

                if (!in_array($aux, $permissions)){
                    unset($url[$i]);
                }

                if(count($url) == 0){
                    return false;
                }
            }
        }

        return $this->_makeLink( 
            array(
                'title'=>$titulo,
                'url'=>$url,
                'icon'=>$icon,
                'requestJS'=>$js
            )
        );
    }    

    private function _makeLink ($options){

        $html  = "";
        $attr  = "";
        $tipo  = (is_array($options['url'])) ? 'folder' : 'link';

        $attr .= (!empty($options['requestJS'])) ? 'requestJS="'.$options['requestJS'].'" ' : '';

        if ($tipo == 'link'){
            $html .= '
            <li class="'.$this->_getStatus($options['url']).'">
                <a href="'.$this->url($options['url']).'" '.$attr.'>
                    <div class="gui-icon">
                        <i class="'.$options['icon'].'"></i>
                    </div>
                    <span class="title">'.$options['title'].'</span>
                </a>
            </li>
            ';
        } else {
            $html .= '
            <li class="gui-folder">
                <a>
                    <div class="gui-icon"><i class="'.$options['icon'].'"></i></div>
                    <span class="title">'.$options['title'].'</span>
                </a>
                <ul>';
                
                foreach ($options['url'] as $link) {
                    $linkAttr = (!empty($link['requestJS'])) ? 'requestJS="'.$link['requestJS'].'" ' : '';
                    $html .= '<li class="'.$this->_getStatus($link['url']).'">
                                <a href="'.$this->url($link['url']).'" '.$linkAttr.'>
                                  <span class="title">'.$link['title'].'</span>
                                </a>
                              </li>';
                }

            $html .= '
                </ul>
            </li>
            ';
        }


        return $html;
    }

    private function _getStatus($url){
        // INICIA VARIÁVEL
        $status = false;
        
        // CASO A PÁGINA ATUAL SEJA HOME, MUDA CONTEÚDO PARA DASHBOARD
        $aux = ($this->here == $this->base.'/') ? 'dashboard' : '';

        // VERIFICA SE A REQUISIÇÃO FEITA REFERE-SE 
        // AO LINK QUE ESTÁ SENDO MONTADO E RETORNA O RESULTADO
        return ($this->here.$aux == $this->base.$url || $this->here.$aux.'/' == $this->base.$url) ? 'active' : '';
    }
}

?>