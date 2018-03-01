<h3><?php echo 'Olá,';?></h3>
<p><?php echo 'Para confirmar o cadastro da sua Senha de Acesso, favor seguir as instruções abaixo:';?></p>
<p><?php echo $this->Html->link(__('Clique aqui para confirmar seu cadastro'), $this->Html->url(array('action'=>'confirm_password', $user_id, $md5_code), true)); ?></p>
<p><?php echo sprintf( __('O código de verificação: %s'), $md5_code);?></p>
<p><?php echo __("Se você não efetuou o cadastro de Senha de Acesso, nenhuma ação é necessária. Basta ignorar este e-mail.", true);?></p>
<p><?php echo __('Respeitosamente,', true);?></p>
<p>Equipe <a href="http://nucleos.consultoriatrend.com.br">NucleOS</a></p>