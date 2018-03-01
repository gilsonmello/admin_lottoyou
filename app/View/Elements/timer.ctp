<?php if ($this->Session->check('Auth.User')){ ?>
<div id="dialog_idletimer" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Atenção!</h4>
            </div>
            <div class="modal-body" style="text-align:justify;">
                <p>Detectamos que a alguns minutos você não interage com o sistema e para sua segurança, 
                sua sessão será encerrada automaticamente.</p> 

                <p>Caso deseje continuar utilizando o sistema 
                clique em "PERMANECER CONECTADO".</p>

                <p><b>Obs.:</b> Sua sessão encerrará em <b><span id="dialog-countdown" style="display: inline;"></span></b> segundos.</p>
            </div>
            <div class="modal-footer">
                <button id="dismiss-modal" type="button" class="btn btn-primary" data-dismiss="modal">PERMANECER CONECTADO</button>
            </div>
        </div>
    </div>
</div> 
<?php } ?>
