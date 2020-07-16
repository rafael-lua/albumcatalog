<div class="columns is-centered">
	<div class="column is-narrow">
		<h1 class="title is-1 my-6">CATÁLOGO DE ÁLBUNS MUSICAIS</h1>
	</div>
</div>

<div class="columns is-centered">
	<div class="column is-narrow">
		<h3 class="subtitle is-3">Bem-vindo!</h3>
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

<br><br><br>

<strong style="font-size:35px">DIGITE O NOME DO ALBUM</strong>
<br><br>
<form action="<?php echo base_url('albums');?>" method="post">
	<?= csrf_field() ?> <!-- Function that creates a hidden input with a CSRF token that helps protect against some common attacks. -->

    <input type="text" name="album" required /><br><br>
	<input type="submit" name="submit" value="Pesquisar" style="width:10%"/>

</form>

<?php if(!empty($searchError)): echo '<br><div style="color: red">'.esc($searchError).'</div>'; endif; ?>

<br>
<hr style="width:50%">

<div class="extras" style="width:50%; margin: auto">
	<form action="<?php echo base_url('albums/showall');?>" method="post" style="float:left;">
		<input type="submit" name="submit" value="Listar Todos"/>
	</form>
	<div style="float:left; margin-right: 10px; margin-left: 10px; font-weight: 900;">|</div>
	<form action="<?php echo base_url('albums/showgenre');?>" method="post" style="float:left;">
		<input type="submit" name="submit" value="Listar Gênero:"/>
		<select name="genre">
		  <option value="rock">Rock</option>
		  <option value="pop">Pop</option>
		  <option value="electronic">Electronic</option>
		  <option value="classical">Classical</option>
		  <option value="jazz">Jazz</option>
		</select>
	</form>	
</div>

<br><br>