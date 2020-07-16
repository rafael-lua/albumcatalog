
<div class="modal" id="login-modal">
	<div class="modal-background"></div>
	<div class="modal-content">
				
				<div class="box">					
						<form action="<?php echo base_url('login'); ?>" method="post">
							<p class="title" style="text-align: center;"><strong> LOGIN </strong></p>
							<i class="fas fa-users fa-3x" style="text-align: center; width: 100%;"></i>
							<hr>
							<div class="field">
								<label class="label">Username</label>
								<div class="control">
									<input name="username" class="input" type="text" placeholder="user123">
								</div>
								<p class="help is-hidden"></p>
							</div>

							<div class="field">
								<label class="label">Password</label>
								<div class="control">
									<input name="password" class="input" type="password" placeholder="*****">
								</div>
								<p class="help is-hidden"></p>
							</div>

							<div class="field is-grouped is-grouped-centered mt-5">
								<div class="control">
									<button class="button is-link" type="submit">Sign In</button>
								</div>
								<div class="control">
									<button class="button is-link is-light" onclick="loginModal()">Cancel</button>
								</div>
							</div>
						</form>
				</div>		

	</div>	
	<button class="modal-close is-large" aria-label="close" onclick="loginModal()"></button>
</div>


<!-- <?php if(!isset($userAccount)) : ?>
			
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

		<?php endif; ?>  -->