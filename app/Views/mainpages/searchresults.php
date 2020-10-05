<!-- <?php echo var_dump($debug); ?> -->

<div class="columns">
  <div class="column px-6 py-6">

    <!-- Top column -->
		<form action="<?php echo base_url('search');?>" method="post" id="clean_search">
			<?= csrf_field() ?> <!-- Function that creates a hidden input with a CSRF token that helps protect against some common attacks. -->

			<div class="field has-addons">
				<div class="control is-expanded">
					<input type="text" id="search_value" name="search_value" class="input is-primary" 
					placeholder="Digite o nome do álbum, artista, estúdio..." required/>
				</div>
				<div class="control">
					<button class="button is-primary" type="submit">Pesquisar</button>
				</div>
			</div>
			<p class="help is-danger"><?php if(!empty($searchError)){echo esc($searchError);} ?></p>
		</form>

		<form action="<?php echo base_url('search');?>" method="post" id="main_search_form">
		<!-- This form has the "search_value" as well, but hidden, not required and with the last search value! -->
		<input type="text" id="last_search" name="search_value" value="<?php if(isset($currentSearch)){echo esc($currentSearch);} ?>" hidden />
		
    <div class="columns my-5">

      <div class="column">
				<!-- Left column -->
        <nav class="panel is-info">

					<p class="panel-heading">Filters</p>

					<!-- <form id="main_search_form"> -->

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

					<!-- </form> -->

				</nav>
      </div>
		</form>
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
								if(isset($results) && !empty($results))
								{
									echo count($results);
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
											<button type="submit" form="main_search_form" class="button is-success is-light is-small mx-1">
												<i class="fas fa-sort-down fa-lg mr-1" style="color: hsl(141, 71%, 48%); display: inline;"></i> <!-- fa-sort-up and down. toggle(up) with toggle (down) on JS to change -->
												<small><strong>A-Z</strong></small>
											</button>
										</li>
										<li id="order-rating">
											<button type="submit" form="main_search_form" class="button is-info is-light is-small mx-1">
												<i class="fas fa-sort-down fa-lg mr-1" style="color: hsl(141, 71%, 48%); display: none;"></i>
												<a href="#"><small><strong>Rating</strong></small></a>
											</button>
										</li>
										<li id="order-year">
											<button type="submit" form="main_search_form" class="button is-info is-light is-small mx-1">
												<i class="fas fa-sort-down fa-lg mr-1" style="color: hsl(141, 71%, 48%); display: none;"></i>
												<a href="#"><small><strong>Year</strong></small></a>
											</button>
										</li>
									</ul>
								</nav>
						</div>					
					</div>

					<hr class="my-1 has-background-grey-lighter" style=" margin: auto;">
				
					<?php if (is_array($results) && !empty($results)) : ?>

						<?php # Order the current results by name.
							
							# The direction asc and desc needs a function for each case. 
							# Since functions will not access values outside of their scope without passing, $order is not accessible.
							if (empty($order["type"])) { $order["type"] = "orderResultsByNameAsc";}

							function orderResultsByNameAsc($resultA, $resultB)
							{
								return strcmp($resultA["name"], $resultB["name"]);
							}

							function orderResultsByNameDesc($resultA, $resultB)
							{
								return strcmp($resultB["name"], $resultA["name"]);
							}
							
							usort($results, $order["type"]);
							
						?>

						<?php foreach($results as $result) : ?>

							<?php if($result["type"] == "album") : ?>				<!-- Albums -->
							
								<?php 
									# Compound names
									$artistCompound = "";
									$firstArtist = false;
									foreach($result["artist"] as $artist)
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
									foreach($result["studio"] as $studio)
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
										<a href="<?php echo base_url(); ?>/search/showalbum/<?php echo esc($result["id"]); ?>">
											<span id="album_name" class="mx-3 is-size-5">
												<strong>
													<?php echo esc($result["name"]); ?>
													<span class="is-size-7 has-text-grey-light"><em><?php echo "(id: ".esc($result["id"]).")"; ?></em></span>
												</strong>
											</span>
										</a>
									</div>
									<div class="level-right">
										<div>
											<span id="album_artist" class="mx-3"><em><strong><?php echo esc($artistCompound); ?></strong></em></span>
											<span id="album_year" class="mx-3"><em><small><?php echo esc($studioCompound); ?></small></em></span>
											<span id="album_year" class="mx-3"><em><small><?php echo esc($result["year"]); ?></small></em></span>
										</div>
									</div>
								</div>
								<span id="album_rate" class="mx-3 is-size-5"><strong>
									<i class="fas fa-star fa-lg is-size-7" style="vertical-align: middle; color: #ffcc00;"></i>
									<?php echo esc($result["rating"]); ?>
								</strong></span>
								<div class="tags" style="float: right;">
									<?php foreach($result["genre"] as $genre) : ?>
										<span class="tag"><?php echo esc($genre["name"]); ?></span>
									<?php endforeach; ?>
								</div>
							
							<?php elseif($result["type"] == "artist") : ?> 			<!-- Artists -->
								
								<div class="level mt-3 mb-1">
									<div class="level-left">
										<a href="#">
											<span id="artist_name" class="mx-3 is-size-6">
												<strong style="opacity: 0.85;">
													<?php echo esc($result["name"]); ?>
												</strong>
											</span>
										</a>
									</div>
									<div class="level-right">
										<span id="artist_top_album" class="mx-3 is-size-6 has-text-weight-bold">
											<em class="mx-3"><?php echo esc($result["album"]["name"]); ?></em>
											<i class="fas fa-star fa-lg is-size-7" style="vertical-align: middle; color: #ffcc00;"></i>
											<?php echo esc($result["album"]["rating"]); ?>
										</span>
									</div>
								</div>
								<span id="album_rate" class="mx-3 is-size-7"><strong class="has-text-grey">ARTIST</strong></span>
								<span id="album_rate" class="mx-3 is-size-7" style="float: right;"><strong class="has-text-grey"><em>BEST RATED ALBUM</em></strong></span>
							

							<?php elseif($result["type"] == "studio") : ?>			<!-- Studios -->
								
								<div class="level mt-3 mb-1">
									<div class="level-left">
										<a href="#">
											<span id="studio_name" class="mx-3 is-size-6">
												<strong style="opacity: 0.85;">
													<?php echo esc($result["name"]); ?>
												</strong>
											</span>
										</a>
									</div>
									<div class="level-right">
										<span id="studio_top_album" class="mx-3 is-size-6 has-text-weight-bold">
											<em class="mx-3"><?php echo esc($result["album"]["name"]); ?></em>
											<i class="fas fa-star fa-lg is-size-7" style="vertical-align: middle; color: #ffcc00;"></i>
											<?php echo esc($result["album"]["rating"]); ?>
										</span>
									</div>
								</div>
								<span id="album_rate" class="mx-3 is-size-7"><strong class="has-text-grey">STUDIO</strong></span>
								<span id="album_rate" class="mx-3 is-size-7" style="float: right;"><strong class="has-text-grey"><em>BEST RATED ALBUM</em></strong></span>
							
							<?php endif; ?>

							<hr class="my-1 has-background-grey-lighter" style="margin: auto; clear: both;">
							
						<?php endforeach; ?>
						
					<?php endif; ?>

				</div>

      </div>
    </div>
  </div>
</div>







