
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
			<i class="fas fa-star fa-lg is-size-3" style="vertical-align: middle; color: #ffcc00;"></i>
			<?php echo esc($albumData["album"]["rating"]); ?>
			</p>
			
			<hr style="width: 50%;" class="has-background-grey-lighter">
		
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



