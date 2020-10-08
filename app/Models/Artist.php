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


	
	public function findArtist($s, $filters, $direction, $offset)
	{
		$artists = [];

		
		# In the future, use "select" in the query to select only the desired fields, instead of everything.
		$artists = $this->asArray()->select('id, name, "artist" as type')
														->like(['name' => $s])
														->orderBy('name', $direction)
														->limit(10, $offset)->findAll();

		foreach($artists as $key => &$artist)
		{
			if(isset($filters["genre"]))
			{
				$artist["album"] = $this->asArray()->select('album.name, album.rating', false)->distinct()
												->from('album, artistalbum')
												->from('genre, genrealbum')
												->where(['artistalbum.artistId' => 'artist.id', 'artistalbum.albumId' => 'album.id', 'artist.id' => $artist["id"]], NULL, FALSE)
												->where(['genre.name' => 'genrealbum.genreName', 'album.id' => 'genrealbum.albumId'], NULL, FALSE)
												->whereIn('genre.name', $filters["genre"])
												->orderBy('album.rating', 'DESC')
												->limit(1)->first();
				
				if(empty($artist["album"])){unset($artists[$key]);}
			}
			else
			{
				$artist["album"] = $this->asArray()->select('album.name, album.rating', false)
												->from('album, artistalbum')
												->where(['artistalbum.artistId' => 'artist.id', 'artistalbum.albumId' => 'album.id', 'artist.id' => $artist["id"]], NULL, FALSE)
												->orderBy('album.rating', 'DESC')
												->limit(1)->first();
			}
		}
		unset($artist);
		

		return $artists;
	}
	
}