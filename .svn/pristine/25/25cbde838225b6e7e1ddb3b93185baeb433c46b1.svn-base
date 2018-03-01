<h3><?php echo 'A EMPRESA SGE (SISTEMA DE GESTÃO EMPRESARIAL)'; ?></h3>
<p><?php echo 'Seguindo o link abaixo você poderá alterar sua senha:'; ?></p>
<span>Motivo</span>
<span><?php echo $observacao ?></span>
<p>
<?php if (!empty($produtos)) { ?>
    <table class="table table-striped table-condensed">
        <caption>Relação de Produtos</caption>
        <tr>
            <th style="width: 20%">Codigo</th>
            <th>Nome</th>
        </tr>
        <tbody>
            <?php foreach ($produtos as $k => $v) { ?>
                <tr>
                    <td><?php echo $v['GelProduto']['codigo'] ?></td>
                    <td><?php echo $v['GelProduto']['nome'] ?></td>
                </tr>    
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
</p>
<p>
    <?php if (!empty($servicos)) { ?>
    <table class="table table-striped table-condensed">
        <caption>Relação de Serviços</caption>
        <tr>
            <td><b>Nome</b></td>
        </tr>
        <tbody>
            <?php foreach ($servicos as $k => $v) { ?>
                <tr>
                    <td><?php echo $v['Servico']['nome'] ?></td>
                </tr>    
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
</p><p><?php echo $this->Html->link(__('Clique aqui para responder'), $this->Html->url(array('controller' => 'comIntencoesCompras', 'action' => 'efetuarCotacao', $secret), true)); ?></p>
<p><?php echo sprintf(__('O código de verificação: %s'), $secret); ?></p>
<p><?php echo __('Respeitosamente,', true); ?></p>
<p>Equipe <a href="http://sge.consultoriatrend.com.br">SGE</a></p>