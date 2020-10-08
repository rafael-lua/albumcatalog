<?php namespace App\Controllers;



use App\Models\Search;
use App\Models\User;
use App\Models\Review;

class MainSearch extends BaseController
{
	
	public function index()
	{
		# Show the search page clean.
		$data = [];
		if($this->session->has("userAccount"))
		{
			$data["userAccount"] = $this->session->get("userAccount");
		}
		
		echo view('templates/header');
		echo view('templates/loginsection', $data);
		echo view('mainpages/searchresults');
		echo view('templates/footer');
		
	}





	public function top100()
	{
		# Show the best 100 albums ordered by rating
		
		
	}




	public function showAll()
	{
		# The main result query, with albums, artists, etc... All together!
		
		
	}




	
	# main search method
	public function findAll($searchValue = NULL)
	{
		if(!$this->validate([
			"search_value" 				=> 		"permit_empty",
			"az_sort" 						=> 		"permit_empty|in_list[azAsc, azDesc]",
			"rating_sort" 				=> 		"permit_empty|in_list[ratingAsc, ratingDesc]",
			"year_sort" 					=> 		"permit_empty|in_list[yearAsc, yearDesc]",
			"rating_filter" 			=> 		"permit_empty|in_list[any, maior, menor, igual]",
			"rating_value" 				=> 		"permit_empty|in_list[1, 2, 3, 4, 5, 6, 7, 8, 9, 10]",
			"show_only" 					=> 		"permit_empty|in_list[onlyAlbum, onlyArtist, onlyStudio, all]",
			"lastOrderType" 			=> 		"permit_empty|in_list[none, az, rating, year]",
			"lastOrderDesc" 			=> 		"permit_empty|in_list[no, yes]",
			"lastCurrentIconPos" 	=> 		"permit_empty|in_list[none, az, rating, year]",
			"genreFilter[]" 			=> 		"permit_empty|in_list[rock, pop, electronic, classical, jazz]",
			"listGenre" 					=>		"permit_empty|in_list[rock, pop, electronic, classical, jazz]",
		]))
		{
			return redirect()->to(base_url());
		}
		else
		{
			
			/* -------------------- show the album that was searched! ------------------- */

			$search = new Search();
			
			$searchValue = $this->request->getVar("search_value");

			$currentPage = 0;



			/* -------------------------------------------------------------------------- */
			/*                               SEARCH FILTERS                               */
			/* -------------------------------------------------------------------------- */

			$filterValues = []; # This is filters options sent to the view deal it
			$currentFilters = []; # This is filters sent to the model apply on the query
			
			$ratingFilterType = $this->request->getVar("rating_filter");
			$ratingFilterValue = $this->request->getVar("rating_value");
			$filterValues["ratingType"] = $ratingFilterType != NULL ? $ratingFilterType : "any";
			$filterValues["ratingValue"] = $ratingFilterValue != NULL ? $ratingFilterValue : "10";

			$show_only = $this->request->getVar("show_only");
			if($show_only == "onlyAlbum")
			{
				$currentFilters["showOnly"] = "album";
			}
			else if($show_only == "onlyArtist")
			{
				$currentFilters["showOnly"] = "artist";
			}
			else if($show_only == "onlyStudio")
			{
				$currentFilters["showOnly"] = "studio";
			}

			if(!empty($this->request->getVar("genreFilter[]")))
			{
				$currentFilters["genre"] = $this->request->getVar("genreFilter[]");
				$filterValues["checkedGenre"] = $currentFilters["genre"];
			}
			elseif(!empty($this->request->getVar("listGenre")))
			{
				$currentFilters["genre"][] = $this->request->getVar("listGenre");
				$filterValues["checkedGenre"] = $currentFilters["genre"];
				$currentFilters["showOnly"] = "album";
			}

			$filterValues["showOnly"] = $currentFilters["showOnly"];

			/* ----------------------------- Filters tags ----------------------------- */

			$filterValues["tags"] = [];

			if($filterValues["ratingType"] != "any"){
				$tag = "";
				if($filterValues["ratingType"] == "maior"){$tag = "Rating >= " . $filterValues["ratingValue"];}
				elseif($filterValues["ratingType"] == "menor"){$tag = "Rating <= " . $filterValues["ratingValue"];}
				elseif($filterValues["ratingType"] == "igual"){$tag = "Rating = " . $filterValues["ratingValue"];}
				$filterValues["tags"][] = $tag;
			}

			if(!empty($show_only) && $show_only != "all")
			{
				$tag = "";
				if($show_only == "onlyAlbum"){$tag = "Apenas albums";}
				elseif($show_only == "onlyArtist"){$tag = "Apenas artistas";}
				elseif($show_only == "onlyStudio"){$tag = "Apenas estúdios";}
				$filterValues["tags"][] = $tag;
			}

			if(!empty($currentFilters["genre"]))
			{
				foreach($currentFilters["genre"] as $genre)
				{
					$filterValues["tags"][] = ucfirst($genre);
				}
			}

			/* -------------------------------------------------------------------------- */
			/*                                SEARCH ORDER                                */
			/* -------------------------------------------------------------------------- */

			$orderValues = [];

			$searchOrder = "az";
			$searchDesc = false;
			$currentIconPosition = "az";

			if(!empty($this->request->getVar("lastOrderType") && $this->request->getVar("lastOrderType") != "none"))
			{
				$searchOrder = $this->request->getVar("lastOrderType");
			}

			if(!empty($this->request->getVar("lastOrderDesc") && $this->request->getVar("lastOrderDesc") == "yes"))
			{
				$searchDesc = true;
			}

			if(!empty($this->request->getVar("lastCurrentIconPos") && $this->request->getVar("lastCurrentIconPos") != "none"))
			{
				$currentIconPosition = $this->request->getVar("lastCurrentIconPos");
			}


			if(!empty($this->request->getVar("rating_sort"))){
				$searchOrder = "rating";
				if($this->request->getVar("rating_sort") == "ratingDesc"){$searchDesc = true;}else{$searchDesc = false;}
				$currentIconPosition = "rating";
			}
			else if(!empty($this->request->getVar("year_sort"))){
				$searchOrder = "year";
				if($this->request->getVar("year_sort") == "yearDesc"){$searchDesc = true;}else{$searchDesc = false;}
				$currentIconPosition = "year";
			}
			else if(!empty($this->request->getVar("az_sort")))
			{
				$searchOrder = "az";
				if($this->request->getVar("az_sort") == "azDesc"){$searchDesc = true;}else{$searchDesc = false;}
				$currentIconPosition = "az";
			}

			/* ---------- The type will tell which sort function should it call --------- */

			if ($searchOrder == "az") {
				$orderValues["type"] = $searchDesc == false ? "orderResultsByNameAsc" : "orderResultsByNameDesc";
				$orderValues["azColor"] = "primary";
			}
			elseif ($searchOrder == "rating")
			{
				$orderValues["type"] = $searchDesc == false ? "orderResultsByRatingAsc" : "orderResultsByRatingDesc";
				$orderValues["ratingColor"] = "primary";
			}
			elseif ($searchOrder == "year")
			{
				$orderValues["type"] = $searchDesc == false ? "orderResultsByYearAsc" : "orderResultsByYearDesc";
				$orderValues["yearColor"] = "primary";
			}

			$orderValues["azNext"] = $searchDesc == true ? "azAsc" : "azDesc"; # Opposite of current state.
			$orderValues["azSortIcon"] = $searchDesc == true ? "fa-sort-up" : "fa-sort-down";
			$orderValues["azDisplayIcon"] = $currentIconPosition == "az" ? "inline" : "none";

			$orderValues["ratingNext"] = $searchDesc == true ? "ratingAsc" : "ratingDesc"; # Opposite of current state.
			$orderValues["ratingSortIcon"] = $searchDesc == true ? "fa-sort-up" : "fa-sort-down";
			$orderValues["ratingDisplayIcon"] = $currentIconPosition == "rating" ? "inline" : "none";

			$orderValues["yearNext"] = $searchDesc == true ? "yearAsc" : "yearDesc"; # Opposite of current state.
			$orderValues["yearSortIcon"] = $searchDesc == true ? "fa-sort-up" : "fa-sort-down";
			$orderValues["yearDisplayIcon"] = $currentIconPosition == "year" ? "inline" : "none";

			$orderValues["lastType"] = $searchOrder;
			$orderValues["lastDesc"] = $searchDesc == true ? "yes" : "no";
			$orderValues["lastIconPos"] = $currentIconPosition;


			/* -------------------------------- Mont data ------------------------------- */

			$data["results"] = $search->findWithFilters($searchValue, $currentFilters, $searchOrder, $searchDesc, $currentPage);
			$data["currentSearch"] = $searchValue; # Use that for repeating the same search with different order or filters.
			$data["orderValues"] = $orderValues;
			$data["filterValues"] = $filterValues;
			
			/*
				The data["results"] HAS to have the following values for ordering:
						type
						name (string)
						rating (float/double)
						year (int)
			*/

			if($this->session->has("userAccount"))
			{
				$data["userAccount"] = $this->session->get("userAccount");
			}			
			
			if(empty($data["results"] == true)) # No results
			{		
				$data["searchError"] = "Nenhum resultado encontrado! Tente algo diferente...";

				echo view('templates/header');
				echo view('templates/loginsection', $data);
				echo view('mainpages/searchresults', $data);
				echo view('templates/footer');
			}
			else # Results found
			{
				echo view('templates/header');
				echo view('templates/loginsection', $data);
				echo view('mainpages/searchresults', $data);
				echo view('templates/footer');
			}
		}
	}
	
	




	/* ----- Show the full album and its songs, genre, artists, studio, etc! ---- */
	/* ---------------- Also, brings the reviews and rank of it. ---------------- */

	public function showAlbum($albumId = NULL)
	{
		$search = new Search();
		$reviews = new Review();
		$data["albumId"] = $albumId;
		$data["albumData"] = $search->getFullAlbum($albumId);
		$data["albumReviews"] = $reviews->getReviewsByAlbum($albumId);
		
		if($this->session->has("userAccount"))
		{
			$data["userAccount"] = $this->session->get("userAccount");
		}
		
		echo view('templates/header');
		echo view('templates/loginsection', $data);
		echo view('mainpages/showalbum', $data);
		echo view('templates/footer');
	}
	
}