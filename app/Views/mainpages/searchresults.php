<div class="columns">
  <div class="column px-6 py-6">

    <!-- Top column -->
		<form action="<?php echo base_url('search');?>" method="post">
			<?= csrf_field() ?> <!-- Function that creates a hidden input with a CSRF token that helps protect against some common attacks. -->

			<div class="field has-addons">
				<div class="control is-expanded">
					<input type="text" name="search_value" class="input is-primary" placeholder="Digite o nome do álbum, artista, estúdio..." required />
				</div>
				<div class="control">
					<button class="button is-primary" type="submit">Pesquisar</button>
				</div>
			</div>
			<p class="help is-danger"><?php if(!empty($searchError)){echo esc($searchError);} ?></p>
		</form>

    <div class="columns my-5">

      <div class="column">
				<!-- Left column -->
        <nav class="panel is-info">

					<p class="panel-heading">Filters</p>

					<form>

						<div class="panel-block">
							<div class="field is-grouped" style="margin: auto;">
								<div class="control">
									<button class="button is-link is-outlined is-rounded">Apply</button>
								</div>
								<div class="control">
									<button class="button is-danger is-outlined is-rounded">Reset</button>
								</div>
							</div>						
						</div>

						<p class="panel-block"><strong>Rating</strong></p>
						<div class="panel-block">
							<div class="dropdown mx-1"> <!-- "is-active" toggle -->
								<div class="dropdown-trigger">
									<button class="button is-small">
										<span id="current_option">Nenhum</span>
										<span class="icon is-small">
											<i class="fas fa-angle-down" aria-hidden="true"></i>
										</span>
									</button>
									<div class="dropdown-menu" id="dropdown-menu" role="menu">
										<div class="dropdown-content">
											<a href="#" class="dropdown-item is-active" id="rating_any">
												Nenhum
											</a>
											<a href="#" class="dropdown-item" id="rating_maiorigual">
												Maior ou Igual
											</a>
											<a href="#" class="dropdown-item" id="rating_menorigual">
												Menor ou Igual
											</a>
											<a href="#" class="dropdown-item" id="rating_igual">
												Igual
											</a>
										</div>
									</div>
								</div>
								<!-- JavaScript is reponsible for changing the hidden value -->
								<input type="hidden" id="hidden_rating_filter" name="rating_filter" value="any">
							</div>

							<div class="dropdown mx-1"> <!-- "is-active" toggle -->
								<div class="dropdown-trigger">
									<button class="button" disabled> <!-- Enable or disable based on the choices -->
										<span id="rating_value">10</span>
										<span class="icon is-small">
											<i class="fas fa-angle-down" aria-hidden="true"></i>
										</span>
									</button>
									<div class="dropdown-menu" id="dropdown-menu" role="menu">
										<div class="dropdown-content">
											<a href="#" class="dropdown-item" id="rating_filter_10"> 10 </a>
											<a href="#" class="dropdown-item" id="rating_filter_9"> 9 </a>
											<a href="#" class="dropdown-item" id="rating_filter_8"> 8 </a>
											<a href="#" class="dropdown-item" id="rating_filter_7"> 7 </a>
											<a href="#" class="dropdown-item" id="rating_filter_6"> 6 </a>
											<a href="#" class="dropdown-item" id="rating_filter_5"> 5 </a>
											<a href="#" class="dropdown-item" id="rating_filter_4"> 4 </a>
											<a href="#" class="dropdown-item" id="rating_filter_3"> 3 </a>
											<a href="#" class="dropdown-item" id="rating_filter_2"> 2 </a>
											<a href="#" class="dropdown-item" id="rating_filter_1"> 1 </a>
										</div>
									</div>
								</div>
								<!-- JavaScript is reponsible for changing the hidden value -->
								<input type="hidden" id="hidden_rating_value" name="rating_value" value="0">
							</div>
						</div>

						<p class="panel-block"><strong>Mostrar Apenas</strong></p>
						<label class="panel-block">
							<input type="radio" name="show_only" class="mx-2">
							Albums
						</label>
						<label class="panel-block">
							<input type="radio" name="show_only" class="mx-2">
							Artistas
						</label>
						<label class="panel-block">
							<input type="radio" name="show_only" class="mx-2">
							Estúdios
						</label>

						<p class="panel-block"><strong>Genre</strong></p>
						<label class="panel-block">
							<input type="checkbox">
							Rock
						</label>
						<label class="panel-block">
							<input type="checkbox">
							Pop
						</label>
						<label class="panel-block">
							<input type="checkbox">
							Jazz
						</label>
						<label class="panel-block">
							<input type="checkbox">
							Electronic
						</label>
						<label class="panel-block">
							<input type="checkbox">
							Classical
						</label>

					</form>

				</nav>
      </div>

      <div class="column is-four-fifths px-6" style="border-left: 1px solid #e6e6e6;">
        <!-- Right column -->

				<div class="searchresults">

					<div class="tags">
						<span class="tag is-rounded is-info is-light">filter</span>
						<span class="tag is-rounded is-info is-light">another filter</span>
					</div>

					<div class="level">
						<div class="level-left">
							<h3 class="subtitle is-3 has-text-weight-bold">
							Resultados (<?php 
								if(isset($results["albums"]) && !empty($results["albums"]))
								{
									echo count($results["albums"]);
								}
								else
								{
									echo 0;
								}
							?>): 
							</h3>
						</div>
						<div class="level-right">
								<nav class="breadcrumb has-bullet-separator is-small" aria-label="breadcrumbs">
									<ul>
										<li id="order-az">
											<i class="fas fa-sort-down fa-lg mr-1" style="color: hsl(141, 71%, 48%);"></i> <!-- fa-sort-up and down. toggle(up) with toggle (down) on JS to change -->
											<a href="#"><small><strong>A-Z</strong></small></a>
										</li>
										<li id="order-rating"><a href="#"><small><strong>Rating</strong></small></a></li>
										<li id="order-year"><a href="#"><small><strong>Year</strong></small></a></li>
									</ul>
								</nav>
						</div>					
					</div>

					<hr class="my-1 has-background-grey-lighter" style=" margin: auto;">
				
					<?php if(is_array($results) && !empty($results)) : 
						
						$albums = $results["albums"];
					
					?>

						<?php foreach($albums as $album) : ?>
							
							<?php 
								# Compound names
								$artistCompound = "";
								$firstArtist = false;
								foreach($album["artist"] as $artist)
								{
									if($firstArtist == false)
									{
										$artistCompound = $artist["name"];
										$firstArtist = true;
									}
									else
									{
										$artistCompound = $artistCompound.", ".$artist["name"];
									}
								}
								$studioCompound = "";
								$firstStudio = false;
								foreach($album["studio"] as $studio)
								{
									if($firstStudio == false)
									{
										$studioCompound = $studio["name"];
										$firstStudio = true;
									}
									else
									{
										$studioCompound = $studioCompound.", ".$studio["name"];
									}
								}
							
							?>
							
							<div class="level my-3">
								<div class="level-left">
									<a href="<?php echo base_url(); ?>/search/showalbum/<?php echo esc($album["id"]); ?>">
										<span id="album_title" class="mx-3 is-size-5">
											<strong>
												<?php echo esc($album["name"]) ?>
												<span class="is-size-7 has-text-grey-light"><em><?php echo "(id: ".esc($album["id"]).")"; ?></em></span>
											</strong>
										</span>
									</a>
								</div>
								<div class="level-right">
									<div>
										<span id="album_artist" class="mx-3"><em><strong><?php echo esc($artistCompound); ?></strong></em></span>
										<span id="album_year" class="mx-3"><em><small><?php echo esc($studioCompound); ?></small></em></span>
										<span id="album_year" class="mx-3"><em><small><?php echo esc($album["year"]); ?></small></em></span>
									</div>
								</div>
							</div>
							<span id="album_rate" class="mx-3"><strong>
								<i class="fas fa-star fa-lg is-size-7" style="vertical-align: middle; color: #ffcc00;"></i>
								<?php echo esc($album["rating"]); ?>
							</strong></span>
							<div class="tags" style="float: right;">
								<?php foreach($album["genre"] as $genre) : ?>
									<span class="tag"><?php echo esc($genre["name"]); ?></span>
								<?php endforeach; ?>
							</div>

							<hr class="my-1 has-background-grey-lighter" style="margin: auto; clear: both;">
							
						<?php endforeach; ?>
						
					<?php endif; ?>

				</div>

      </div>
    </div>
  </div>
</div>







