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
	
	# Returns all albums that match the passed name, or if no value is passed return every single one!
	public function findAlbum($albumName = false) # If you pass a null value, it will not have default false!
	{
		if(($albumName === false) || ($albumName === NULL))
		{
			return $this->findAll();
		}
		
		return $this->asArray()->like(['name' => $albumName])->findAll();

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