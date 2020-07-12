<?php namespace App\Models;

use CodeIgniter\Model;


###
# Class to work with the artist table!
###
class Artist extends Model
{
	protected $table = "artist";
	
	protected $primaryKey = "id";
    protected $returnType = "array";
	
	
	# Returns all the data of an artist
	public function getFullArtist($artistId = false){}
	
	
	# Returns only the name (array) of artists based on the albumId
	public function getNameByAlbum($albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		return $this->asArray()->select('artist.name', FALSE)->from('artistalbum')
							->where(['artistalbum.artistId' => 'artist.id', 'artistalbum.albumId' => $albumId], NULL, FALSE)
							->findAll();		
	}
	
}