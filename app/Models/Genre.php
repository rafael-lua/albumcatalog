<?php namespace App\Models;

use CodeIgniter\Model;

###
# Class to work with the genre table!
###
class Genre extends Model
{
	protected $table = "genre";
	
	protected $primaryKey = "name";
    protected $returnType = "array";
	
	
	# Returns all the data of an studio
	public function getFullGenre($genreName = false){}
	
	
	# Returns only the name (array) of genres based on the albumId
	public function getNameByAlbum($albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		return $this->asArray()->select('genre.name', FALSE)->from('genrealbum')
							->where(['genrealbum.genreName' => 'genre.name', 'genrealbum.albumId' => $albumId], NULL, FALSE)
							->findAll();		
	}
	
}