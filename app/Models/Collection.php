<?php namespace App\Models;

use CodeIgniter\Model;

use App\Models\User;
use App\Models\CollectionAlbum;
use App\Models\CollectionGenre;

/*

Sometimes SELECT needs a second value of false and WHERE a third value of false, so codeigntier don't protect the fields automatically.
When using compound names or alias (tablename.colunm), it can break the query.

BUT, using WHERE with false will not quote strings coming from variables, so for these ones a second where with protection can be called.

*/


#######################
#
# The search model has all the functions related to the collections
#
#######################

class Collection extends Model
{	
	protected $table = "collection";	
	protected $primaryKey = "id";
  protected $returnType = "array";
	
  protected $allowedFields = ['userId', 'title', 'visible', 'locked'];




  /* -------------------------------------------------------------------------- */
  /*                 return all informations about a collection                 */
  /* -------------------------------------------------------------------------- */

	public function getFullCollection($collectionId = false)
	{

    # If this function is called without values for userId, throws a error page back.
		if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    $users = new User();
    $collectiongenre = new CollectionGenre();
    $collectionalbum = new CollectionAlbum();

    $collection = $this->asArray()->where('id', $collectionId)->first();
    $collection["user"] = $users->getPublicUser($collection["userId"]);

    $collection["genres"] = $collectiongenre->getCollectionGenre($collection["id"]);
    $collection["albums"] = $collectionalbum->getCollectionAlbums($collection["id"], $collection["userId"]);

    unset($collection["userId"]); # Unset the userId, since it would be duplicated inside the user
    
    return $collection;

  }




  /* -------------------------------------------------------------------------- */
  /*                        return the user's colections                        */
  /* -------------------------------------------------------------------------- */
  
  public function getCollectionByUser($userId = false)
	{

    # If this function is called without values for userId, throws a error page back.
		if(($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    $collectiongenre = new CollectionGenre();
    
    $collections = $this->asArray()->select('id, title, visible, locked')->where(['userId' => $userId])->findAll();

    foreach($collections as &$collection) # & makes it so it is by reference and can be modified
    {
      $collection["genres"] = $collectiongenre->getCollectionGenre($collection["id"]);
    }
    unset($collection);

    return $collections;

  }

  


  /* -------------------------------------------------------------------------- */
  /*                       create a new user's collection                       */
  /* -------------------------------------------------------------------------- */
  public function insertCollection($userId = false, $title = "", $visibility = "show", $genres = [])
	{

    # If this function is called without values for userId, throws a error page back.
		if(($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    $data = [
      'title' => $title,
      'visible' => $visibility,
      'userId' => $userId
    ];

    # Insert returns the id of the last inserted data!
    $collectionId = $this->insert($data); 

    $collectiongenre = new CollectionGenre();
    foreach($genres as $genreName)
    {
      $collectiongenre->insertCollectionGenre($collectionId, $genreName);
    }

    return $collectionId;

  }



  /* -------------------------------------------------------------------------- */
  /*                       create a new user's collection                       */
  /* -------------------------------------------------------------------------- */
  public function updateCollection($collectionId = false, $title = "", $genres = [])
	{

    # If this function is called without values for userId, throws a error page back.
		if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    $this->where(['id' => $collectionId])->set(['title' => $title])->update();

    $collectiongenre = new CollectionGenre();
    $collectiongenre->removeCollectionGenres($collectionId);
    $collectiongenre->insertCollectionGenre($collectionId, $genres);
  

  }




  /* -------------------------------------------------------------------------- */
  /*                       deletes a collection                                 */
  /* -------------------------------------------------------------------------- */
  public function deleteCollection($collectionId)
	{

    # If this function is called without values for collectionId, throws a error page back.
		if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }


    $colletionVibility = $this->asArray()->select('locked')->where('id', $collectionId)->first();

    if($colletionVibility["locked"] == 0)
    {

      $collectiongenre = new CollectionGenre();
      $collectionalbum = new CollectionAlbum();

      $collectiongenre->removeCollectionGenres($collectionId);
      $collectionalbum->removeCollectionAlbums($collectionId);

      $this->where(['id' => $collectionId])->delete();
    }
    
    

  }



  /* -------------------------------------------------------------------------- */
  /*                       toggles the collection visibility                    */
  /* -------------------------------------------------------------------------- */
  public function toggleVisible($collectionId = false)
	{

    # If this function is called without values for collectionId, throws a error page back.
		if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    $colletionVibility = $this->asArray()->select('visible')->where('id', $collectionId)->first();

    if($colletionVibility["visible"] == "show")
    {
      $data = [ 'visible' => 'hide' ]; 
      $this->update($collectionId, $data);
    }
    elseif($colletionVibility["visible"] == "hide")
    {
      $data = [ 'visible' => 'show' ]; 
      $this->update($collectionId, $data);
    }
    

  }



  /* -------------------------------------------------------------------------- */
	/*                     get the album's state by user                          */
	/* -------------------------------------------------------------------------- */

	public function checkAlbumCollection($collectionId = false, $albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    $collectionalbum = new CollectionAlbum();
		
		$albumInCollection = $collectionalbum->isAlbumInCollection($collectionId, $albumId);
		if($albumInCollection > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
  }
  


  /* -------------------------------------------------------------------------- */
	/*                     add the album to the collections                       */
	/* -------------------------------------------------------------------------- */

	public function addAlbumCollection($collectionIds = false, $albumId = false, $userCollections = false)
	{
		# If this function is called without values for albumId, throws a error page back.
    if(($collectionIds === false) || ($collectionIds === NULL) || 
    ($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || 
    ($userCollections === false) || ($userCollections === NULL))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    $collectionalbum = new CollectionAlbum();

    foreach($userCollections as $collection)
    {
      $collectionalbum->removeCollectionByAlbum($collection["id"], $albumId);
    }

    if(!empty($collectionIds))
    {
      foreach($collectionIds as $collectionId)
      {
        $collectionalbum->insertAlbumCollection($collectionId, $albumId);
      }
    }
	}

	
}