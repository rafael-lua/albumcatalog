<?php namespace App\Models;

use CodeIgniter\Model;

use App\Models\Artist;
use App\Models\Studio;
use App\Models\Genre;
/*

Sometimes SELECT needs a second value of false and WHERE a third value of false, so codeigntier don't protect the fields automatically.
When using compound names or alias (tablename.colunm), it can break the query.

BUT, using WHERE with false will not quote strings coming from variables, so for these ones a second where with protection can be called.

*/


#######################
#
# The search model has all the functions related to finding albums in the database!
#
#######################

class Search extends Model
{	
	protected $table = "album";	
	protected $primaryKey = "id";
  protected $returnType = "array";
	



	# return all informations about one specific album.
	public function getFullAlbum($albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		$modelArtist = new Artist();
		$modelStudio = new Studio();
		$modelGenre = new Genre();
		
		$albumData["album"] = $this->asArray()->select('name, year, rating')->where(['id' => $albumId])->first();
		$albumData["music"] = $this->asArray()->select('music.name, music.duration', FALSE)->from('music')
											->where(['music.albumId' => 'album.id', 'album.id' => $albumId], NULL, FALSE)->findAll();
		$albumData["artist"] = $modelArtist->getNameByAlbum($albumId);
		$albumData["studio"] = $modelStudio->getNameByAlbum($albumId);
		$albumData["genre"] = $modelGenre->getNameByAlbum($albumId);
		
		return $albumData;
		
	}








	##################################################################
	#
	# Returns all results that match the passed search with filters and order (asc, desc)
	#
	##################################################################
	
	public function findWithFilters($s = false, $filters = [], $order = "az", $desc = false, $page = 0) 
	{
			# If this function is called without values for s, throws a error page back.
			if(($s === false) || ($s === NULL))
			{
				throw new \CodeIgniter\Exceptions\PageNotFoundException();
			}

			# Arrays to be merged in the end
			$albumsResults = [];
			$artistsResults = [];
			$studiosResults = [];

			$modelArtist = new Artist();
			$modelStudio = new Studio();
			$modelGenre = new Genre();

			/* --------------------------------- filters -------------------------------- */
			if(is_array($filters) && !empty($filters)){
				$showOnly = $filters["showOnly"];
			}

			$direction = "ASC";
			if($desc == true){$direction = "DESC";}

			$offset = $page * 10;

			# This model works with album table. 
			# It will call functions on the respective tables for artist, studio, etc...

			$sortBy = "name";
			if($order == "az"){$sortBy = "name";}
			elseif($order == "rating"){$sortBy = "rating";} # Order by name
			elseif($order == "year"){$sortBy = "year";} # Order by name

			/* ------------------------------- Get albums ------------------------------- */

			if($showOnly != "artist" && $showOnly != "studio")
			{
				if(isset($filters["genre"]))
				{
					$albumsResults = $this->asArray()->select('id, album.name, year, rating, "album" as type')->distinct()
																					->from('genre, genrealbum')
																					->where(['genre.name' => 'genrealbum.genreName', 'album.id' => 'genrealbum.albumId'], NULL, FALSE)
																					->whereIn('genre.name', $filters["genre"])
																					->like(['album.name' => $s])
																					->orderBy($sortBy, $direction)
																					->limit(10, $offset)->findAll();
				}
				else
				{
					$albumsResults = $this->asArray()->select('id, name, year, rating, "album" as type')
																					->like(['name' => $s])
																					->orderBy($sortBy, $direction)
																					->limit(10, $offset)->findAll();
				}

				foreach($albumsResults as &$album) # & makes it so it is by reference and can be modified
				{
					$album["artist"] = $modelArtist->getNameByAlbum($album["id"]);
					$album["genre"] = $modelGenre->getNameByAlbum($album["id"]);
					$album["studio"] = $modelStudio->getNameByAlbum($album["id"]);
				}
				unset($album); # Always unset the value by reference as good practise, since changing it here would mess up with the actual array
			}


			/* ------------------------------- Get artists ------------------------------ */
			if($showOnly != "album" && $showOnly != "studio")
			{
				$artistsResults = $modelArtist->findArtist($s, $filters, $direction, $offset);
			}

			/* ------------------------------- Get studios ------------------------------- */
			if($showOnly != "artist" && $showOnly != "album")
			{
				$studiosResults = $modelStudio->findStudio($s, $filters, $direction, $offset);
			}


			/* ------------------------------ MERGE RESULTS ----------------------------- */

			$results = array_merge($albumsResults, $artistsResults, $studiosResults);

			return $results;

	}




	# returns all albums by genre
	public function findByGenre($genreName = false)
	{
		# If this function is called without values for genreName, throws a error page back.
		if(($genreName === false) || ($genreName === NULL))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		return $this->asArray()->select('album.*', false)->from('genre, genrealbum')
							->where(['genrealbum.albumId' => 'album.id', 'genrealbum.genreName' => 'genre.name'], NULL, FALSE)
							->where('genre.name', $genreName)
							->findAll();
	}
	
}