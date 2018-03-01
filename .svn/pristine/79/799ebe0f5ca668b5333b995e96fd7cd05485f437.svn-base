<p class="centralizada">
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Página {:page} de {:pages}, mostrando {:current} registros de {:count}, começando pelo registro  {:start}')
    ));
    ?>	</p>
<div class="pager">
    <?php
    echo $this->Paginator->prev('< Anteriores', array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next('Próximos >', array(), null, array('class' => 'next disabled'));
    ?>
</div>