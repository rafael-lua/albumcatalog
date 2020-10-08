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



	public function findStudio($s, $filters, $direction, $offset)
	{
		$studios = [];

		
		# In the future, use "select" in the query to select only the desired fields, instead of everything.
		$studios = $this->asArray()->select('id, name, "studio" as type')
														->like(['name' => $s])
														->orderBy('name', $direction)
														->limit(10, $offset)->findAll();

		foreach($studios as $key => &$studio)
		{
			if(isset($filters["genre"]))
			{
				$studio["album"] = $this->asArray()->select('album.name, album.rating', false)->distinct()
												->from('album, studioalbum')
												->from('genre, genrealbum')
												->where(['studioalbum.studioId' => 'studio.id', 'studioalbum.albumId' => 'album.id', 'studio.id' => $studio["id"]], NULL, FALSE)
												->where(['genre.name' => 'genrealbum.genreName', 'album.id' => 'genrealbum.albumId'], NULL, FALSE)
												->whereIn('genre.name', $filters["genre"])
												->orderBy('album.rating', 'DESC')
												->limit(1)->first();
				
				if(empty($studio["album"])){unset($studios[$key]);}
			}
			else
			{
				$studio["album"] = $this->asArray()->select('album.name, album.rating', false)
												->from('album, studioalbum')
												->where(['studioalbum.studioId' => 'studio.id', 'studioalbum.albumId' => 'album.id', 'studio.id' => $studio["id"]], NULL, FALSE)
												->orderBy('album.rating', 'DESC')
												->limit(1)->first();
			}
		}
		unset($studio);
		

		return $studios;
	}
	
}
