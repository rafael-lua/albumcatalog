
<div class="homeuser">

<?php if(!isset($userAccount)) : ?>
	
	<form action="<?php echo base_url('login'); ?>" method="post">
		<input type="text" name="username" placeholder="Usuário" style="margin: 3px;"/>
		<br>
		<input type="password" name="password" placeholder="Senha" style="margin: 3px;"/>
		<br>
		<input type="submit" name="submit" value="Login" style="margin: 3px;"/>
	</form>
	
	<?php if(!empty($loginError)): echo '<br><div style="color: red">'.esc($loginError).'</div>'; endif; ?>

<?php else : ?>

	<p><i>BEM-VINDO, <?php echo esc($userAccount["username"]);?>.</i>
	<br>
	<a href="<?php echo base_url('logoff'); ?>">Sair</a>
	</p>

<?php endif; ?>

</div>