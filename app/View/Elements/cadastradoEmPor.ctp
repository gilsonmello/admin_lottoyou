<div class="cadastradoEmPor" style="color:#666;font-size:10px;padding:10px 0 7px 0;margin:0 0 10px 0;border-bottom: 1px solid #CCCCCC;">
    CADASTRADO EM: <b><?php echo $em ?></b>&nbsp;&nbsp;&nbsp;
    POR: <b style="text-transform:uppercase;"><?php echo $por ?></b>
    <?php if (isset($updated)) { ?><span style="float:right;">ATUALIZADO EM: <b><?php echo ($em != $updated) ? $updated : 'NUNCA ATUALIZADO'; ?></b></span><?php } ?>
</div>