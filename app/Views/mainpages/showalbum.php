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


</script>


<?php if(isset($userAccount)) : ?>
	<div class="container mt-3 px-1 py-1 has-background-grey-lighter">
		<div class="box has-background-dark has-text-info-light py-1">
			
		<form action="<?php echo base_url('updateRating');?>" method="post">
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
	</div>
<?php endif; ?>


<?php
/* -------------------------------------------------------------------------- */
/*                               Show album page                              */
/* -------------------------------------------------------------------------- */

// echo var_dump($debug);

?>


<section class="section" id="albumSection">
	<div class="columns is-centered is-vcentered">

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
							<i class="fas fa-star fa-lg is-size-6 my-2" style="color: #ffcc00;"></i><br>
							<strong>Titulo da review</strong> <small>@<?php echo esc($review["username"]); ?></small> <small>00/00/0000</small>
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
