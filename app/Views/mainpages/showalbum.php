<script>

window.onload = function(){
	let userStars = document.getElementsByClassName("userRank");
	for(let i = 0; i < userStars.length; i++)
	{
		userStars[i].addEventListener("mouseover", hoverColor);
		userStars[i].addEventListener("mouseout", hoverUncolor);
	}
}

function hoverColor()
{
	if(!this.classList.contains("isSelected"))
	{
		let elements = document.getElementsByClassName("userRank isNotSelected");
		for (let i = 0; i < elements.length; i++) {
			
			elements[i].style.color = "#ffcc00";
			
			if(elements[i].id == this.id){return}
		}
	}
}

function hoverUncolor()
{
	let elements = document.getElementsByClassName("userRank isNotSelected");
	for (let i = 0; i < elements.length; i++) {
		elements[i].style.color = "#d9d9d9";
	}
}


function reviewModal() 
{
  let element = document.getElementById("review-modal");
  element.classList.toggle("is-active");
}


function addCollectionModal() 
{
  let element = document.getElementById("add-collection-modal");
  element.classList.toggle("is-active");
}

</script>


<!-- /* ------------------------------- user painel ------------------------------ */ -->


<?php if(isset($userAccount)) : ?>
	<div class="container mt-3 px-1 py-1 has-background-grey-lighter">
		<div class="box has-background-dark has-text-info-light py-1">
		
			<div class="columns is-vcentered">
				<div class="column is-half">

					<form action="<?php echo base_url('updaterating');?>" method="post" style="display: inline;">
					<?= csrf_field() ?>
					<input type="text" name="albumid" value="<?php echo esc($albumId); ?>" hidden />
					<input type="text" name="userid" value="<?php echo esc($userAccount["id"]); ?>" hidden />
						<?php if(isset($userAlbumRanking) && !empty($userAlbumRanking)){$note = $userAlbumRanking["note"];}else{$note = 0;} ?>
						<span class="mx-3"><em class="mr-1">SUA NOTA</em>
						<button value="1" name="note" type="submit" style="padding: 0; border: none; background: none;" class="is-size-6">
							<i class="fas fa-star userRank <?php if($note != 0 && $note >= 1){echo esc("isSelected");}else{echo esc("isNotSelected");} ?>" id="star-1" style="color: #<?php if($note != 0 && $note >= 1){echo esc("ffcc00");}else{echo esc("d9d9d9");} ?>; cursor: pointer;"></i>
						</button>

						<button value="2" name="note" type="submit" style="padding: 0; border: none; background: none;" class="is-size-6">
							<i class="fas fa-star userRank <?php if($note != 0 && $note >= 2){echo esc("isSelected");}else{echo esc("isNotSelected");} ?>" id="star-2" style="color: #<?php if($note != 0 && $note >= 2){echo esc("ffcc00");}else{echo esc("d9d9d9");} ?>; cursor: pointer;"></i>
						</button>

						<button value="3" name="note" type="submit" style="padding: 0; border: none; background: none;" class="is-size-6">
							<i class="fas fa-star userRank <?php if($note != 0 && $note >= 3){echo esc("isSelected");}else{echo esc("isNotSelected");} ?>" id="star-3" style="color: #<?php if($note != 0 && $note >= 3){echo esc("ffcc00");}else{echo esc("d9d9d9");} ?>; cursor: pointer;"></i>
						</button>

						<button value="4" name="note" type="submit" style="padding: 0; border: none; background: none;" class="is-size-6">
							<i class="fas fa-star userRank <?php if($note != 0 && $note >= 4){echo esc("isSelected");}else{echo esc("isNotSelected");} ?>" id="star-4" style="color: #<?php if($note != 0 && $note >= 4){echo esc("ffcc00");}else{echo esc("d9d9d9");} ?>; cursor: pointer;"></i>
						</button>

						<button value="5" name="note" type="submit" style="padding: 0; border: none; background: none;" class="is-size-6">
							<i class="fas fa-star userRank <?php if($note != 0 && $note >= 5){echo esc("isSelected");}else{echo esc("isNotSelected");} ?>" id="star-5" style="color: #<?php if($note != 0 && $note >= 5){echo esc("ffcc00");}else{echo esc("d9d9d9");} ?>; cursor: pointer;"></i>
						</button>	

						<button value="6" name="note" type="submit" style="padding: 0; border: none; background: none;" class="is-size-6">
							<i class="fas fa-star userRank <?php if($note != 0 && $note >= 6){echo esc("isSelected");}else{echo esc("isNotSelected");} ?>" id="star-6" style="color: #<?php if($note != 0 && $note >= 6){echo esc("ffcc00");}else{echo esc("d9d9d9");} ?>; cursor: pointer;"></i>
						</button>

						<button value="7" name="note" type="submit" style="padding: 0; border: none; background: none;" class="is-size-6">
							<i class="fas fa-star userRank <?php if($note != 0 && $note >= 7){echo esc("isSelected");}else{echo esc("isNotSelected");} ?>" id="star-7" style="color: #<?php if($note != 0 && $note >= 7){echo esc("ffcc00");}else{echo esc("d9d9d9");} ?>; cursor: pointer;"></i>
						</button>	

						<button value="8" name="note" type="submit" style="padding: 0; border: none; background: none;" class="is-size-6">
							<i class="fas fa-star userRank <?php if($note != 0 && $note >= 8){echo esc("isSelected");}else{echo esc("isNotSelected");} ?>" id="star-8" style="color: #<?php if($note != 0 && $note >= 8){echo esc("ffcc00");}else{echo esc("d9d9d9");} ?>; cursor: pointer;"></i>
						</button>

						<button value="9" name="note" type="submit" style="padding: 0; border: none; background: none;" class="is-size-6">
							<i class="fas fa-star userRank <?php if($note != 0 && $note >= 9){echo esc("isSelected");}else{echo esc("isNotSelected");} ?>" id="star-9" style="color: #<?php if($note != 0 && $note >= 9){echo esc("ffcc00");}else{echo esc("d9d9d9");} ?>; cursor: pointer;"></i>
						</button>

						<button value="10" name="note" type="submit" style="padding: 0; border: none; background: none;" class="is-size-6">
							<i class="fas fa-star userRank <?php if($note != 0 && $note >= 10){echo esc("isSelected");}else{echo esc("isNotSelected");} ?>" id="star-10" style="color: #<?php if($note != 0 && $note >= 10){echo esc("ffcc00");}else{echo esc("d9d9d9");} ?>; cursor: pointer;"></i>
						</button>

						<small class="mx-1 has-text-warning has-text-weight-bold"><?php if($note != 0){echo esc($userAlbumRanking["note"]);} ?></small>
						</span> 
					</form>
					
				</div>

				<div class="column is-half">
					<div class="is-flex is-flex-direction-row-reverse">
						<button class="button is-small is-inverted is-primary is-light mx-2" onclick="addCollectionModal();"><strong>Colecionar</strong></button>
						<button class="button is-small is-inverted is-info is-light mx-2" onclick="reviewModal();"><strong>Escrever Crítica</strong></button>
						
						<form action="<?php echo base_url('changestate');?>" method="post">
						<?= csrf_field() ?>
						<input type="text" name="albumid" value="<?php echo esc($albumId); ?>" hidden />
							<div class="field mx-2">
								<div class="control">
									<div class="select is-small is-info">
										<select class="has-text-weight-bold has-text-success" name="statevalue" onchange="this.form.submit()">
											<option class="has-text-info" value="0" <?php if($userAlbumState == "none"){echo esc("selected");} ?>>Nenhum Status</option>
											<option class="has-text-info" value="1" <?php if($userAlbumState == "wanting"){echo esc("selected");} ?>>Pretende Ouvir</option>
											<option class="has-text-info" value="2" <?php if($userAlbumState == "waiting"){echo esc("selected");} ?>>Esperando Lançar</option>
											<option class="has-text-info" value="3" <?php if($userAlbumState == "completed"){echo esc("selected");} ?>>Completo</option>
											<option class="has-text-info" value="4" <?php if($userAlbumState == "dumped"){echo esc("selected");} ?>>Abandonado</option>
										</select>
									</div>
								</div>
							</div>
						</form>

					</div>				
				</div>

			</div>

		</div>
	</div>
<?php endif; ?>


<?php if(isset($userAccount)) : ?>
	<!-- Write review modal -->

	<div class="modal" id="review-modal">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title has-text-weight-bold is-size-5">CRÍTICA <small>(<?php echo esc($albumData["album"]["name"]);?> - <?php echo esc($albumData["album"]["rating"]);?><i class="fas fa-star mx-1" style="color: #ffcc00;"></i>)</small></p>
				<button class="delete" aria-label="close" onclick="reviewModal();"></button>
			</header>
			
			<section class="modal-card-body">
				<form id="reviewForm" action="<?php echo base_url('updatereview');?>" method="post" style="display: inline;">
				<?= csrf_field() ?>
				<input type="text" name="albumid" value="<?php echo esc($albumId); ?>" hidden />
				<input type="text" name="userid" value="<?php echo esc($userAccount["id"]); ?>" hidden />
					<input class="input is-rounded is-fullwidth my-2" type="text" name="reviewtitle" placeholder="Título da crítica..." value="<?php if(isset($userAlbumReview["title"])){echo esc($userAlbumReview["title"]);} ?>"/>
					<textarea class="textarea px-2 py-2" placeholder="Sua crítica..." rows="10" cols="75" maxlength="5000" name="wording"><?php if(isset($userAlbumReview["wording"])){echo esc($userAlbumReview["wording"]);} ?></textarea>
				</form>
			</section>

			<footer class="modal-card-foot">
				<button class="button is-success" form="reviewForm" name="action" value="<?php if(!isset($userAlbumReview["wording"])){echo esc("insert");}else{echo esc("update");} ?>" type="submit"><?php if(!isset($userAlbumReview["wording"])){echo esc("Confirmar");}else{echo esc("Atualizar");} ?></button>
				<button class="button" onclick="reviewModal();">Cancelar</button>
				<button class="button is-danger" form="reviewForm" name="action" value="delete" <?php if(!isset($userAlbumReview["wording"])){echo esc("disabled");} ?> type="submit">Excluir</button>
			</footer>
			
		</div>
	</div>



	<!-- Add to collection modal -->

	<div class="modal" id="add-collection-modal">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title has-text-weight-bold is-size-5">ADICIONAR À COLEÇÃO</p>
				<button class="delete" aria-label="close" onclick="addCollectionModal();"></button>
			</header>
			
			<section class="modal-card-body">
			<form action="<?php echo base_url('addtocollection');?>" method="post" id="add_collection_form">
			<?= csrf_field() ?>
				<input type="text" name="albumId" value="<?php echo esc($albumId); ?>" hidden />
				<div class="field px-3">
					<label class="label mb-4">Selecione as coleções: </label>
					<div class="control" style="max-height: 10em; overflow: scroll-y;">
						<?php foreach($userCollections as $collection) : $hasCollection = false; ?>
							<?php if($collection["locked"] == 0) : $hasCollection = true; ?>
								<label class="checkbox is-size-5 mx-1 mb-2">
									<input type="checkbox" name="collectionIds[]" value="<?php echo esc($collection["id"]); ?>" <?php if($collection["checked"] == true){echo esc("checked");} ?>>
									<?php echo esc($collection["title"]); ?>
								</label>
								<hr class="my-1">
							<?php endif; ?>
						<?php endforeach; ?>

						<?php if($hasCollection == false) : ?>
							<p>Você não tem nenhuma coleção criada!</p>
						<?php endif; ?>

					</div>
				</div>
			</form>
			</section>

			<footer class="modal-card-foot">
				<button class="button is-success" type="submit" form="add_collection_form"><strong>Confirmar</strong></button>
				<button class="button" type="submit" onclick="addCollectionModal();"><strong>Cancelar</strong></button>
			</footer>
			
		</div>
	</div>
<?php endif; ?>


<?php
/* -------------------------------------------------------------------------- */
/*                               Show album page                              */
/* -------------------------------------------------------------------------- */

// echo var_dump($debug);

?>


<section class="section" id="albumSection">
	<div class="columns is-centered is-vcentered mx-5">

		<div class="column is-half">
			
			<p class="is-italic is-size-1 has-text-weight-bold has-text-black-ter" style="line-height: 0.5em;">
				<i class="fas fa-star is-size-1" style="color: #ffcc00;"></i>
				<?php echo esc($albumData["album"]["rating"]); ?>
			</p>				
			
			<hr style="width: 75%;" class="has-background-grey-lighter">
		
			<h1 class="title is-1 has-text-weight-bold">
				<?php echo esc($albumData["album"]["name"]);?>
				<span class="has-text-grey-light is-italic is-size-6"><?php echo "(id: ".esc($albumId).")"; ?></span>
			</h1>

			<p class="is-size-5 has-text-weight-bold mt-1 is-italic">Artista(s)</p>
			<p class="is-size-6">
				<?php 
					$artistsName = "";
					$firstArtist = false;
					foreach($albumData["artist"] as $artist)
					{
						if($firstArtist == false)
						{
							$artistsName = $artist["name"];
							$firstArtist = true;
						}
						else
						{
							$artistsName = $artistsName." | ".$artist["name"];
						}
					}
					
					echo esc($artistsName);	
				?>
			</p>	
								
			<p class="is-size-5 has-text-weight-bold mt-2 is-italic">Ano</p>
			<p class="is-size-6">
				<?php					
					echo esc($albumData["album"]["year"]);	
				?>
			</p>
		
			<p class="is-size-5 has-text-weight-bold mt-2 is-italic">Estúdio(s)</p>
			<p class="is-size-6">
			<?php 					
					$studiosName = "";
					$firstStudio = false;
					foreach($albumData["studio"] as $studio)
					{
						if($firstStudio == false)
						{
							$studiosName = $studio["name"];
							$firstStudio = true;
						}
						else
						{
							$studiosName = $studiosName.", ".$studio["name"];
						}
					}
					
					echo esc($studiosName);	
				?>
			</p>

			<p class="is-size-5 has-text-weight-bold mt-2 is-italic">Gênero(s)</p>
			<p class="is-size-6">
				<nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
					<ul>
						<?php foreach($albumData["genre"] as $genre) : ?>
							<li><a href="#"><?php echo esc($genre["name"]);?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			</p>

		</div>

		<div class="column is-half">
			<div class="box">
				<table class="table is-striped is-hoverable is-fullwidth">

					<thead>
						<tr>
							<th>Faixa</th>
							<th style="width:15%">Duração</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($albumData["music"] as $music) : ?>
							<tr>
								<th><?php echo esc($music["name"]); ?></th>
								<td><?php echo esc($music["duration"]); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		
	</div>
</section>




<hr>





<section class="section" id="reviewSection">

	<h1 class="title is-3 has-text-weight-bold">CRÍTICAS AO ÁLBUM:</h1>

	<?php if(isset($albumReviews)) : ?>

		<?php foreach($albumReviews as $review) : ?>

			<article class="media mx-1 my-1">
				<div class="media-content">
					<div class="content">
						<p>
							<span class="is-size-6"><?php echo esc($review["note"]); ?></span><i class="fas fa-star is-size-6 my-1 mx-1" style="color: #ffcc00;"></i><br>
							<strong><?php echo esc($review["title"]); ?></strong> <small><a>@<?php echo esc($review["username"]); ?></a></small> <small><em><?php echo esc($review["creationDate"]); ?></em></small>
							<p style="margin: 0; padding: 0;">
								<?php echo esc($review["wording"]); ?>
							</p>
						</p>
					</div>
				</div>
			</article>

			<hr class="my-5 has-background-grey-lighter" style=" margin: auto;">

		<?php endforeach; ?>

	<?php else : ?>

		<h4>Ainda não há nenhuma crítica para este álbum.</h4>

	<?php endif; ?>

</section>
