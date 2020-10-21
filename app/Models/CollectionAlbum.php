<?php namespace App\Models;

use CodeIgniter\Model;

use App\Models\Artist;
use App\Models\Ranking;

/*

Sometimes SELECT needs a second value of false and WHERE a third value of false, so codeigntier don't protect the fields automatically.
When using compound names or alias (tablename.colunm), it can break the query.

BUT, using WHERE with false will not quote strings coming from variables, so for these ones a second where with protection can be called.

*/


#######################
#
# The search model has all the functions related to the collections-genre
#
#######################

class CollectionAlbum extends Model
{	
	protected $table = "collectionalbum";	
	protected $primaryKey = "collectionId";
  protected $returnType = "array";
	
  protected $allowedFields = ['collectionId', 'albumId'];


  /* -------------------------------------------------------------------------- */
  /*                          Get the collection genres                         */
  /* -------------------------------------------------------------------------- */

  public function getCollectionAlbums($collectionId = false, $userId = false)
  {

    # If this function is called without values for userId, throws a error page back.
    if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
    {
      throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    $albums = $this->asArray()->select('album.id, album.name, album.year, state', FALSE)
                          ->from('album, statusalbum')
                          ->where(['album.id' => 'collectionalbum.albumId', 'collectionalbum.collectionId' => $collectionId], NULL, FALSE)
                          ->where(['statusalbum.albumId' => 'album.id', 'statusalbum.userId' => $userId], NULL, FALSE)
                          ->findAll();
    
    $artists = new Artist();
    $rankings = new Ranking();

    foreach($albums as &$album)
    {
      $album["artists"] = $artists->getNameByAlbum($album["id"]);
      $album["rank"] = $rankings->getUserAlbumRank($userId, $album["id"]);
    }
    unset($album);

    return $albums;

  }

  
    
  /* -------------------------------------------------------------------------- */
  /*                    remove all collection album references                  */
  /* -------------------------------------------------------------------------- */
  
  
  public function removeCollectionAlbums($collectionId = false)
  {

    # If this function is called without values for userId, throws a error page back.
    if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
    {
      throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    $this->where(['collectionId' => $collectionId])->delete();
  
  }



  /* -------------------------------------------------------------------------- */
  /*            remove all collections for the album/user reference             */
  /* -------------------------------------------------------------------------- */
  
  
  public function removeCollectionByAlbum($collectionId = false, $albumId = false)
  {

    # If this function is called without values for userId, throws a error page back.
    if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId) || ($albumId === false) || ($albumId === NULL) || !is_numeric($albumId))
    {
      throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    $this->where(['collectionId' => $collectionId, 'albumId' => $albumId])->delete();
  
  }



  /* -------------------------------------------------------------------------- */
	/*                     insert an album into an collection                     */
	/* -------------------------------------------------------------------------- */

	public function insertAlbumCollection($collectionId = false, $albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($collectionId === false) || ($collectionId === NULL))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
    $data = [
      'collectionId' => $collectionId,
      'albumId' => $albumId,
    ];    
   
    $this->insert($data); 
    
		
	}



  /* -------------------------------------------------------------------------- */
	/*                     check if an album is in a collection                   */
	/* -------------------------------------------------------------------------- */

	public function isAlbumInCollection($collectionId = false, $albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
    return $this->where(['collectionId' => $collectionId, 'albumId' => $albumId])->countAllResults();
    
    
		
	}
	
}