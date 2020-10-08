<main>

<section class="section">
<div class="columns is-centered">
	<div class="column is-narrow">
		<h1 class="title is-1">CATÁLOGO DE ÁLBUNS MUSICAIS</h1>
	</div>
</div>

<div class="columns is-centered">
	<div class="column is-narrow">
		<h2 class="subtitle is-3">Bem-vindo!</h2>
	</div>
</div>

<div class="columns is-centered">
	<div class="column is-narrow">
		<p style="text-align: center;">
		Aqui você pode pesquisar as informações de diversos álbuns musicais. 
		<br><em>Caso tenha interesse em montar coleções e acessar outras funcionalidades:
		<strong>Acesse ou crie uma conta!</strong></em>
		</p>
	</div>
</div>
</section>
<section class="section">
<div class="columns is-centered">
	<div class="column is-7">
		<div class="box has-background-white-ter">
			<form action="<?php echo base_url('search');?>" method="post">
				<?= csrf_field() ?> <!-- Function that creates a hidden input with a CSRF token that helps protect against some common attacks. -->

				<div class="field">
					<div class="control ">
						<input type="text" name="search_value" class="input is-primary" placeholder="Digite o nome do álbum, artista, estúdio..." />
					</div>
					<p class="help is-danger"><?php if(!empty($searchError)){echo esc($searchError);} ?></p>
				</div>

				<div class="field is-grouped is-grouped-centered">
					<div class="control">
						<button class="button is-primary" type="submit">Pesquisar</button>
					</div>
				</div>
			</form>
		</div>

		<nav class="level is-mobile">
			<div class="level-left">
    		<div class="level-item">
					<form action="<?php echo base_url('search/top100');?>" method="post" style="float:left;">
					<?= csrf_field() ?>
						<div class="field">
							<div class="control">
								<button class="button is-link is-small" type="submit">Listar Top 100</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="level-right">
    		<div class="level-item">
					<form action="<?php echo base_url('search');?>" method="post">
					<?= csrf_field() ?>
						<div class="field has-addons">
							<div class="control">
								<button class="button is-link is-small" type="submit">Listar Gênero:</button>
							</div>
							<div class="control">
								<span class="select is-small">
									<select name="listGenre">
										<option value="rock">Rock</option>
										<option value="pop">Pop</option>
										<option value="electronic">Electronic</option>
										<option value="classical">Classical</option>
										<option value="jazz">Jazz</option>
									</select>
								</span>
							</div>							
						</div>
						<input type="text" name="search_value" hidden/>
					</form>
				</div>
			</div>
		</nav>

	</div>
</div>
</section>

</main>