<?php namespace App\Models;

use CodeIgniter\Model;

###
# Class to work with the studio table!
###
class Studio extends Model
{
	protected $table = "studio";
	
	protected $primaryKey = "id";
    protected $returnType = "array";
	
	
	# Returns all the data of an studio
	public function getFullStudio($studioId = false){}
	
	
	# Returns only the name (array) of studios based on the albumId
	public function getNameByAlbum($albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		return $this->asArray()->select('studio.name', FALSE)->from('studioalbum')
							->where(['studioalbum.studioId' => 'studio.id', 'studioalbum.albumId' => $albumId], NULL, FALSE)
							->findAll();							
	}
	
}
