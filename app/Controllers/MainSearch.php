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
			
			$data["results"] = $search->findWithFilters($searchValue);
			$data["currentSearch"] = $searchValue; # Use that for repeating the same search with different order or filters.
			
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