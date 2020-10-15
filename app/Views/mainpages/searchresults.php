<!-- <?php echo var_dump($debug); ?> -->

<script>

function toggleRatingFilter()
{
  let element = document.getElementById("ratingFilterToggle");
	element.classList.toggle("is-active");
	return false;
}

function toggleRatingValueFilter()
{
  let element = document.getElementById("ratingFilterValueToggle");
	element.classList.toggle("is-active");
	return false;
}

function selectRatingFilter(a)
{
	// First, remove all activate class
	let removeActive = document.getElementById("rating_any");
	removeActive.classList.remove("is-active");
	removeActive = document.getElementById("rating_maiorigual");
	removeActive.classList.remove("is-active");
	removeActive = document.getElementById("rating_menorigual");
	removeActive.classList.remove("is-active");
	removeActive = document.getElementById("rating_igual");
	removeActive.classList.remove("is-active");

	// Then active the link that was clicked and set the hidden value for the filter form
	if(a == 1)
	{
		let element = document.getElementById("rating_any");
		element.classList.toggle("is-active");
		document.getElementById("current_option").innerHTML = "Nenhum";
		document.getElementById("ratingFilterValueButton").disabled = true;
		document.getElementById("hidden_rating_filter").value = "any";
	}
	else if(a == 2)
	{
		let element = document.getElementById("rating_maiorigual");
		element.classList.toggle("is-active");
		document.getElementById("current_option").innerHTML = ">=";
		document.getElementById("ratingFilterValueButton").disabled = false;
		document.getElementById("hidden_rating_filter").value = "maior";
	}
	else if(a == 3)
	{
		let element = document.getElementById("rating_menorigual");
		element.classList.toggle("is-active");
		document.getElementById("current_option").innerHTML = "<=";
		document.getElementById("ratingFilterValueButton").disabled = false;
		document.getElementById("hidden_rating_filter").value = "menor";
	}
	else if(a == 4)
	{
		let element = document.getElementById("rating_igual");
		element.classList.toggle("is-active");
		document.getElementById("current_option").innerHTML = "=";
		document.getElementById("ratingFilterValueButton").disabled = false;
		document.getElementById("hidden_rating_filter").value = "igual";
	}

	toggleRatingFilter();
}

function selectRatingFilterValue(a)
{
	// First, remove all activate class
	for(let i = 1; i <= 10; i++)
	{
		let removeActive = document.getElementById("rating_filter_" + i);
		removeActive.classList.remove("is-active");
	}

	// Then active the link that was clicked and set the hidden value for the filter form
	let element = document.getElementById("rating_filter_" + a);
	element.classList.toggle("is-active");
	document.getElementById("current_rating_value").innerHTML = a.toString();
	document.getElementById("hidden_rating_value").value = a;

	toggleRatingValueFilter();
}


</script>

<!-- 
/* -------------------------------------------------------------------------- */
/*                                 page start                                 */
/* -------------------------------------------------------------------------- */ 
-->

<div class="columns">
  <div class="column px-6 py-6">

    <!-- Top column -->

		<!-- Main form -->
		<form action="<?php echo base_url('search');?>" method="post" id="clean_search">
			<?= csrf_field() ?> <!-- Function that creates a hidden input with a CSRF token that helps protect against some common attacks. -->

			<div class="field has-addons">
				<div class="control is-expanded">
					<input type="text" id="search_value" name="search_value" class="input is-primary" 
					placeholder="Digite o nome do álbum, artista, estúdio..." />
				</div>
				<div class="control">
					<button class="button is-primary" type="submit">Pesquisar</button>
				</div>
			</div>
			<p class="help is-danger"><?php if(!empty($searchError)){echo esc($searchError);} ?></p>
		</form>

		<form action="<?php echo base_url('search');?>" method="post" class="is-pulled-left mx-1">
		<?= csrf_field() ?>
		<input type="text" name="listTop" value="100" hidden />
			<div class="field">
				<div class="control">
					<button class="button is-link is-small" type="submit">Listar Top 100</button>
				</div>
			</div>
		</form>

		<form action="<?php echo base_url('search');?>" method="post" class="is-pulled-right mx-1">
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
		</form>

		<!-- Reset form -->
		<form method="post" id="clean_search_reset" action="<?php echo base_url('search');?>" hidden >
		<?= csrf_field() ?>
		<input type="text" name="search_value" value="<?php if(isset($currentSearch)){echo esc($currentSearch);} ?>" hidden />
		</form>

		<!-- filters form -->
		<form action="<?php echo base_url('search');?>" method="post" id="main_search_form" method="post">
		<?= csrf_field() ?>
		<!-- This form has the "search_value" as well, but hidden, not required and with the last search value! -->
		<input type="text" name="search_value" value="<?php if(isset($currentSearch)){echo esc($currentSearch);} ?>" hidden />
		<input type="text" name="lastOrderType" value="<?php if(isset($orderValues["lastType"])){echo esc($orderValues["lastType"]);}else{echo esc("none");} ?>" hidden />
		<input type="text" name="lastOrderDesc" value="<?php if(isset($orderValues["lastDesc"])){echo esc($orderValues["lastDesc"]);}else{echo esc("no");} ?>" hidden />
		<input type="text" name="lastCurrentIconPos" value="<?php if(isset($orderValues["lastIconPos"])){echo esc($orderValues["lastIconPos"]);}else{echo esc("none");} ?>" hidden />

    <div class="columns my-5" style="clear: both;">

      <div class="column">
				<!-- Left column -->
        <nav class="panel is-info">

					<p class="panel-heading">Filters</p>

					<!-- <form id="main_search_form"> -->

						<div class="panel-block">
							<div class="field is-grouped" style="margin: auto;">
								<div class="control">
									<button type="submit" class="button is-link is-outlined is-rounded">Apply</button>
								</div>
								<div class="control">
									<button type="submit" form="clean_search_reset" class="button is-danger is-outlined is-rounded" <?php if(!isset($currentSearch)){echo esc("disabled");} ?>>Reset</button>
								</div>
							</div>						
						</div>

						<p class="panel-block"><strong>Rating</strong></p>
						<div class="panel-block">
							<div class="dropdown mx-1" id="ratingFilterToggle"> <!-- "is-active" toggle -->
								<div class="dropdown-trigger">
									<button class="button is-small" id="ratingFilterButton" onclick="return toggleRatingFilter()">
										<span id="current_option">
											<?php 
												if(isset($filterValues["ratingType"]) && $filterValues["ratingType"] == "maior"){echo esc(">=");}
												elseif(isset($filterValues["ratingType"]) && $filterValues["ratingType"] == "menor"){echo esc("<=");}
												elseif(isset($filterValues["ratingType"]) && $filterValues["ratingType"] == "igual"){echo esc("=");}
												else{echo esc("Nenhum");} 
											?>
										</span>
										<span class="icon is-small">
											<i class="fas fa-angle-down" aria-hidden="true"></i>
										</span>
									</button>
									<div class="dropdown-menu" id="dropdown-menu" role="menu">
										<div class="dropdown-content">
											<a class="dropdown-item <?php if(!isset($filterValues["ratingType"])){echo esc("is-active");}elseif($filterValues["ratingType"] == "any"){echo esc("is-active");}?>" id="rating_any" onclick="selectRatingFilter(1)">
												Nenhum
											</a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingType"]) && $filterValues["ratingType"] == "maior"){echo esc("is-active");}?>" id="rating_maiorigual" onclick="selectRatingFilter(2)">
												Maior ou Igual
											</a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingType"]) && $filterValues["ratingType"] == "menor"){echo esc("is-active");}?>" id="rating_menorigual" onclick="selectRatingFilter(3)">
												Menor ou Igual
											</a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingType"]) && $filterValues["ratingType"] == "igual"){echo esc("is-active");}?>" id="rating_igual" onclick="selectRatingFilter(4)">
												Igual
											</a>
										</div>
									</div>
								</div>
								<!-- JavaScript is reponsible for changing the hidden value -->
								<input type="hidden" id="hidden_rating_filter" name="rating_filter" value="<?php if(isset($filterValues["ratingType"])){echo esc($filterValues["ratingType"]);}else{echo esc("any");} ?>">
							</div>

							<div class="dropdown mx-1" id="ratingFilterValueToggle"> <!-- "is-active" toggle -->
								<div class="dropdown-trigger">
									<button class="button is-small" id="ratingFilterValueButton" onclick="return toggleRatingValueFilter()" <?php if(!isset($filterValues["ratingType"]) || $filterValues["ratingType"] == "any"){echo esc("disabled");} ?>> <!-- Enable or disable based on the choices -->
										<span id="current_rating_value"><?php if(isset($filterValues["ratingValue"])){echo esc($filterValues["ratingValue"]);}else{echo esc("10");} ?></span>
										<span class="icon is-small">
											<i class="fas fa-angle-down" aria-hidden="true"></i>
										</span>
									</button>
									<div class="dropdown-menu" id="dropdown-menu" role="menu">
										<div class="dropdown-content">
											<a class="dropdown-item <?php if(!isset($filterValues["ratingValue"])){echo esc("is-active");}elseif($filterValues["ratingValue"] == 10){echo esc("is-active");}?>" id="rating_filter_10" onclick="selectRatingFilterValue(10)"> 10 </a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingValue"]) && $filterValues["ratingValue"] == 9){echo esc("is-active");}?>" id="rating_filter_9" onclick="selectRatingFilterValue(9)"> 9 </a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingValue"]) && $filterValues["ratingValue"] == 8){echo esc("is-active");}?>" id="rating_filter_8" onclick="selectRatingFilterValue(8)"> 8 </a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingValue"]) && $filterValues["ratingValue"] == 7){echo esc("is-active");}?>" id="rating_filter_7" onclick="selectRatingFilterValue(7)"> 7 </a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingValue"]) && $filterValues["ratingValue"] == 6){echo esc("is-active");}?>" id="rating_filter_6" onclick="selectRatingFilterValue(6)"> 6 </a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingValue"]) && $filterValues["ratingValue"] == 5){echo esc("is-active");}?>" id="rating_filter_5" onclick="selectRatingFilterValue(5)"> 5 </a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingValue"]) && $filterValues["ratingValue"] == 4){echo esc("is-active");}?>" id="rating_filter_4" onclick="selectRatingFilterValue(4)"> 4 </a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingValue"]) && $filterValues["ratingValue"] == 3){echo esc("is-active");}?>" id="rating_filter_3" onclick="selectRatingFilterValue(3)"> 3 </a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingValue"]) && $filterValues["ratingValue"] == 2){echo esc("is-active");}?>" id="rating_filter_2" onclick="selectRatingFilterValue(2)"> 2 </a>
											<a class="dropdown-item <?php if(isset($filterValues["ratingValue"]) && $filterValues["ratingValue"] == 1){echo esc("is-active");}?>" id="rating_filter_1" onclick="selectRatingFilterValue(1)"> 1 </a>
										</div>
									</div>
								</div>
								<!-- JavaScript is reponsible for changing the hidden value -->
								<input type="hidden" id="hidden_rating_value" name="rating_value" value="<?php if(isset($filterValues["ratingValue"])){echo esc($filterValues["ratingValue"]);}else{echo esc(10);} ?>">
							</div>
						</div>

						<p class="panel-block"><strong>Mostrar Apenas</strong></p>
						<label class="panel-block">
							<input type="radio" name="show_only" class="mx-2" value="all" <?php if(!isset($filterValues["showOnly"])){echo esc("checked");}elseif($filterValues["showOnly"] == "all"){echo esc("checked");} ?>>
							Todos
						</label>
						<label class="panel-block">
							<input type="radio" name="show_only" class="mx-2" value="onlyAlbum" <?php if($filterValues["showOnly"] == "album"){echo esc("checked");} ?>>
							Albums
						</label>
						<label class="panel-block">
							<input type="radio" name="show_only" class="mx-2" value="onlyArtist" <?php if($filterValues["showOnly"] == "artist"){echo esc("checked");} ?>>
							Artistas
						</label>
						<label class="panel-block">
							<input type="radio" name="show_only" class="mx-2" value="onlyStudio" <?php if($filterValues["showOnly"] == "studio"){echo esc("checked");} ?>>
							Estúdios
						</label>

						<p class="panel-block"><strong>Genre</strong></p>
						<label class="panel-block">
							<input type="checkbox" name="genreFilter[]" value="rock" <?php if(isset($filterValues["checkedGenre"]) && in_array("rock", $filterValues["checkedGenre"])){echo esc("checked");} ?>>
							Rock
						</label>
						<label class="panel-block">
							<input type="checkbox" name="genreFilter[]" value="pop" <?php if(isset($filterValues["checkedGenre"]) && in_array("pop", $filterValues["checkedGenre"])){echo esc("checked");} ?>>
							Pop
						</label>
						<label class="panel-block">
							<input type="checkbox" name="genreFilter[]" value="jazz" <?php if(isset($filterValues["checkedGenre"]) && in_array("jazz", $filterValues["checkedGenre"])){echo esc("checked");} ?>>
							Jazz
						</label>
						<label class="panel-block">
							<input type="checkbox" name="genreFilter[]" value="electronic" <?php if(isset($filterValues["checkedGenre"]) && in_array("electronic", $filterValues["checkedGenre"])){echo esc("checked");} ?>>
							Electronic
						</label>
						<label class="panel-block">
							<input type="checkbox" name="genreFilter[]" value="classical" <?php if(isset($filterValues["checkedGenre"]) && in_array("classical", $filterValues["checkedGenre"])){echo esc("checked");} ?>>
							Classical
						</label>

					<!-- </form> -->

				</nav>
      </div>
		</form>
      <div class="column is-four-fifths px-6" style="border-left: 1px solid #e6e6e6;">
        <!-- Right column -->

				<div class="searchresults">

					<?php 			
						if (is_array($results) && !empty($results))
						{

							/* ----------------------------- View filtering ----------------------------- */

							# Deals with rating filter.
							if(isset($filterValues["ratingType"]) && $filterValues["ratingType"] != "any")
							{	
								foreach ($results as $key => &$value) 
								{
									if($filterValues["ratingType"] == "igual")
									{
										if($value["type"] == "album")
										{
											if($value["rating"] < $filterValues["ratingValue"] || $value["rating"] > ($filterValues["ratingValue"] + 0.9)) {
													unset($results[$key]);
											}
										}
										else
										{
											if($value["album"]["rating"] < $filterValues["ratingValue"] || $value["album"]["rating"] > ($filterValues["ratingValue"] + 0.9)) {
												unset($results[$key]);
											}
										}
									}
									else if($filterValues["ratingType"] == "maior")
									{
										if($value["type"] == "album")
										{
											if($value["rating"] < $filterValues["ratingValue"]) {
												unset($results[$key]);
											}
										}
										else
										{
											if($value["album"]["rating"] < $filterValues["ratingValue"]) {
												unset($results[$key]);
											}
										}
									}
									else if($filterValues["ratingType"] == "menor")
									{
										if($value["type"] == "album")
										{
											if($value["rating"] > $filterValues["ratingValue"]) {
												unset($results[$key]);
											}
										}
										else
										{
											if($value["album"]["rating"] > $filterValues["ratingValue"]) {
												unset($results[$key]);
											}
										}
									}
								}
								unset($value);
							}
						}
					?>

					<div class="tags">
						<?php if(isset($filterValues["tags"])) : ?>
							<?php foreach($filterValues["tags"] as $tag) : ?>
								<span class="tag is-rounded is-info is-light"><?php echo esc($tag); ?></span>
							<?php endforeach; ?>
						<?php endif; ?>
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
										<!-- The value of buttons should match what will happen after cliking it, asc or desc -->
										<li id="order-az">
											<button name="az_sort" value="<?php if(isset($orderValues["azNext"])){echo esc($orderValues["azNext"]);}else{echo esc("azDesc");} ?>" type="submit" form="main_search_form" class="button is-<?php if(isset($orderValues["azColor"])){echo esc($orderValues["azColor"]);}else{echo esc("info");} ?> is-light is-small mx-1">
												<i class="fas <?php if(isset($orderValues["azSortIcon"])){echo esc($orderValues["azSortIcon"]);}else{echo esc("fa-sort-down");} ?> fa-lg mr-1" style="color: hsl(141, 71%, 48%); display: <?php if(isset($orderValues["azDisplayIcon"])){echo esc($orderValues["azDisplayIcon"]);}else{echo esc("inline");} ?>;"></i>
												<small><strong>A-Z</strong></small>
											</button>
										</li>
										<li id="order-rating">
											<button name="rating_sort" value="<?php if(isset($orderValues["ratingNext"])){echo esc($orderValues["ratingNext"]);}else{echo esc("ratingDesc");} ?>" type="submit" form="main_search_form" class="button is-<?php if(isset($orderValues["ratingColor"])){echo esc($orderValues["ratingColor"]);}else{echo esc("info");} ?> is-light is-small mx-1">
												<i class="fas <?php if(isset($orderValues["ratingSortIcon"])){echo esc($orderValues["ratingSortIcon"]);}else{echo esc("fa-sort-down");} ?> fa-lg mr-1" style="color: hsl(141, 71%, 48%); display: <?php if(isset($orderValues["ratingDisplayIcon"])){echo esc($orderValues["ratingDisplayIcon"]);}else{echo esc("none");} ?>;"></i>
												<small><strong>Rating</strong></small>
											</button>
										</li>
										<li id="order-year">
											<button name="year_sort" value="<?php if(isset($orderValues["yearNext"])){echo esc($orderValues["yearNext"]);}else{echo esc("yearDesc");} ?>" type="submit" form="main_search_form" class="button is-<?php if(isset($orderValues["yearColor"])){echo esc($orderValues["yearColor"]);}else{echo esc("info");} ?> is-light is-small mx-1">
												<i class="fas <?php if(isset($orderValues["yearSortIcon"])){echo esc($orderValues["yearSortIcon"]);}else{echo esc("fa-sort-down");} ?> fa-lg mr-1" style="color: hsl(141, 71%, 48%); display: <?php if(isset($orderValues["yearDisplayIcon"])){echo esc($orderValues["yearDisplayIcon"]);}else{echo esc("none");} ?>;"></i>
												<small><strong>Year</strong></small>
											</button>
										</li>
									</ul>
								</nav>
						</div>					
					</div>

					<hr class="my-1 has-background-grey-lighter" style=" margin: auto;">
				
					<?php if (is_array($results) && !empty($results)) : ?>

						<?php 

							/* ------------------- Order the current results by name. ------------------- */
							
							# The direction asc and desc needs a function for each case. 
							# Since functions will not access values outside of their scope without passing, $order is not accessible.
							if (empty($orderValues["type"])) { $orderValues["type"] = "orderResultsByNameAsc";}

							function orderResultsByNameAsc($resultA, $resultB)
							{
								return strcmp($resultA["name"], $resultB["name"]);
							}

							function orderResultsByNameDesc($resultA, $resultB)
							{
								return strcmp($resultB["name"], $resultA["name"]);
							}

							function orderResultsByRatingDesc($resultA, $resultB)
							{
									if ($resultB["type"] != "album") { return -1;}
									if ($resultA["type"] != "album") { return 1;}
									if ($resultA["rating"] == $resultB["rating"]) { return 0; }
									return ($resultA["rating"] < $resultB["rating"]) ? 1 : -1;
							}

							function orderResultsByRatingAsc($resultA, $resultB)
							{
									if ($resultB["type"] != "album") { return -1;}
									if ($resultA["type"] != "album") { return 1;}
									if ($resultA["rating"] == $resultB["rating"]) { return 0; }
									return ($resultB["rating"] < $resultA["rating"]) ? 1 : -1;
							}

							function orderResultsByYearDesc($resultA, $resultB)
							{
									if ($resultB["type"] != "album") { return -1;}
									if ($resultA["type"] != "album") { return 1;}
									if ($resultA["year"] == $resultB["year"]) { return 0; }
									return ($resultA["year"] < $resultB["year"]) ? 1 : -1;
							}

							function orderResultsByYearAsc($resultA, $resultB)
							{
									if ($resultB["type"] != "album") { return -1;}
									if ($resultA["type"] != "album") { return 1;}
									if ($resultA["year"] == $resultB["year"]) { return 0; }
									return ($resultB["year"] < $resultA["year"]) ? 1 : -1;
							}
							
							usort($results, $orderValues["type"]);
							
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







