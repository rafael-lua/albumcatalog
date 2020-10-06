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
			"search_value" 	=> 		"required",
			"az_sort" 	=> 		"permit_empty|in_list[azAsc, azDesc]",
			"rating_sort" 	=> 		"permit_empty|in_list[ratingAsc, ratingDesc]",
			"year_sort" 	=> 		"permit_empty|in_list[yearAsc, yearDesc]",
		]))
		{
			$this->session->set("homeErrorId", 1);
			return redirect()->to(base_url());
		}
		else
		{

			# show the album that was searched!
			$search = new Search();
			
			$searchValue = $this->request->getVar("search_value");

			$currentPage = 0;
			$currentFilters = false;

			$searchOrder = "az";
			$searchDesc = false;
			$currentIconPosition = "az";
			if(!empty($this->request->getVar("rating_sort")) || is_numeric($this->request->getVar("rating_sort"))){
				$searchOrder = "rating";
				if($this->request->getVar("rating_sort") == "ratingDesc"){$searchDesc = true;}
				$currentIconPosition = "rating";
			}
			else if(!empty($this->request->getVar("year_sort")) || is_numeric($this->request->getVar("year_sort"))){
				$searchOrder = "year";
				if($this->request->getVar("year_sort") == "yearDesc"){$searchDesc = true;}
				$currentIconPosition = "year";
			}
			else
			{
				if($this->request->getVar("az_sort") == "azDesc"){$searchDesc = true;}
			}

			# The type will tell which sort function should it call
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


			$data["results"] = $search->findWithFilters($searchValue, $currentFilters, $searchOrder, $searchDesc, $currentPage);
			$data["currentSearch"] = $searchValue; # Use that for repeating the same search with different order or filters.
			$data["orderValues"] = $orderValues;
			
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
	
	




	# Show the full album and its songs, genre, artists, studio, etc!
	# Also, brings the reviews and rank of it.
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
	



	
	# Returns all albums of that genre
	public function findGenre($genreName = false)
	{		
		if(!$this->validate([
			"genre" => 	"required",
		]))
		{
			return redirect()->to(base_url());
		}
		else
		{
			$search = new Search();
			$genreName = $this->request->getVar("genre");
			
			$data["albuns"] = $search->findByGenre($genreName);
			
			if($this->session->has("userAccount"))
			{
				$data["userAccount"] = $this->session->get("userAccount");
			}
			
			echo view('templates/header');
			echo view('templates/loginsection', $data);
			echo view('mainpages/searchresults', $data);
			echo view('templates/footer');
		}
	}
}