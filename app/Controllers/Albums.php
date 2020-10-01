<?php namespace App\Controllers;



use App\Models\Search;
use App\Models\User;
use App\Models\Review;

class Albums extends BaseController
{
	
	public function index()
	{
		# Show the search page clean.
		$search = new Search();
		$data["albuns"] = $search->findAlbum();
		
		if($this->session->has("userAccount"))
		{
			$data["userAccount"] = $this->session->get("userAccount");
		}
		
		echo view('templates/header');
		echo view('templates/loginsection', $data);
		echo view('mainpages/searchresults', $data);
		echo view('templates/footer');
		
	}
	
	# search album method, find by its name
	public function results($albumName = NULL)
	{
		if(!$this->validate([
			"album" => 	"required",
		]))
		{
			$this->session->set("homeErrorId", 1);
			return redirect()->to(base_url());
		}
		else
		{

			# show the album that was searched!
			$search = new Search();
			

			$albumName = $this->request->getVar("album");
			
			# search->findAlbumWithFilters(albumid, filters) ... work with  that

			$data["albuns"] = $search->findAlbum($albumName);
			foreach($data["albuns"] as $album)
			{
				$album["artist"] = $search->getArtistByAlbum($album["id"]);
				$album["genre"] = $search->getGenreByAlbum($album["id"]);
				$album["studio"] = $search->getStudioByAlbum($album["id"]);
			}



			
			if($this->session->has("userAccount"))
			{
				$data["userAccount"] = $this->session->get("userAccount");
			}			
			
			if(empty($data["albuns"] == true)) # No results
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
	public function showalbum($albumId = NULL)
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
	public function findgenre($genreName = false)
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