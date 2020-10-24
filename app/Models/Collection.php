<?php namespace App\Models;

use CodeIgniter\Model;

use App\Models\User;
use App\Models\CollectionAlbum;
use App\Models\CollectionGenre;
use App\Models\Activity;

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
	
  protected $allowedFields = ['userId', 'title', 'visible', 'locked', 'baseid'];




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
      'userId' => $userId,
      'baseid' => 9 # 9 is the base value for user created collections
    ];

    # Insert returns the id of the last inserted data!
    $collectionId = $this->insert($data); 

    $collectiongenre = new CollectionGenre();
    foreach($genres as $genreName)
    {
      $collectiongenre->insertCollectionGenre($collectionId, $genreName);
    }

    $activities = new Activity();
    $activities->insertActivity($userId, "create-collection", false, false, $collectionId);

    return $collectionId;

  }



  /* -------------------------------------------------------------------------- */
  /*                         update a  user's collection                        */
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
  public function toggleVisible($collectionId = false, $userId = false)
	{

    # If this function is called without values for collectionId, throws a error page back.
		if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    $colletionVibility = $this->asArray()->select('visible')->where('id', $collectionId)->first();

    if($colletionVibility["visible"] == "show")
    {
      $data = [ 'visible' => 'hide' ]; 
      $this->update($collectionId, $data);

      $activities = new Activity();
      $activities->updateVisibility($userId, $collectionId, 1);
    }
    elseif($colletionVibility["visible"] == "hide")
    {
      $data = [ 'visible' => 'show' ]; 
      $this->update($collectionId, $data);
     
      $activities = new Activity();
      $activities->updateVisibility($userId, $collectionId, 0);
    }

    
    

  }


  /* -------------------------------------------------------------------------- */
  /*                         checks collection visibility                       */
  /* -------------------------------------------------------------------------- */
  public function getVisible($collectionId = false)
	{

    # If this function is called without values for collectionId, throws a error page back.
		if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    $colletionVibility = $this->asArray()->select('visible')->where('id', $collectionId)->first();

    return $colletionVibility["visible"];
    

  }


  /* -------------------------------------------------------------------------- */
  /*                         returns the collection name                        */
  /* -------------------------------------------------------------------------- */
  public function getCollectionName($collectionId = false)
	{

    # If this function is called without values for collectionId, throws a error page back.
		if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    $colletionName = $this->asArray()->select('title')->where('id', $collectionId)->first();

    return $colletionName["title"];
    

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

	public function addAlbumCollection($collectionIds = false, $albumId = false, $userCollections = false, $userId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
    if(($collectionIds === false) || ($collectionIds === NULL) || 
    ($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || 
    ($userId === false) || ($userId === NULL) || !is_numeric($userId) || 
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
      $activities = new Activity();
      
      foreach($collectionIds as $collectionId)
      {
        $collectionalbum->insertAlbumCollection($collectionId, $albumId);

        $activities->insertActivity($userId, "add-collection", $albumId, false, $collectionId);
      }
    }



  }
  



  /* -------------------------------------------------------------------------- */
	/*                     update albums and state collections                    */
	/* -------------------------------------------------------------------------- */

	public function updateAlbumStateCollection($albumId = false, $userId = false, $state = false, $action = "")
	{
		# If this function is called without values for albumId, throws a error page back.
    if(($userId === false) || ($userId === NULL) || !is_numeric($userId) || 
    ($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || 
    ($state === false) || ($state === NULL))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    $collectionalbum = new CollectionAlbum();

    if($state == "review") # review album update state, use action as reference for adding or deleting
    {
      $userCollection = $this->asArray()->select('id')->where(['userId' => $userId, 'baseid' => 0])->first();
      if($action == "+")
      {
        if($collectionalbum->isAlbumInCollection($userCollection["id"], $albumId) == 0)
        {
          $collectionalbum->insertAlbumCollection($userCollection["id"], $albumId);
        }
      }
      elseif($action == "-")
      {
        if($collectionalbum->isAlbumInCollection($userCollection["id"], $albumId) > 0)
        {
          $collectionalbum->removeCollectionByAlbum($userCollection["id"], $albumId);
        }
      }
    }
    elseif($state == "ranking") # ranking collection update state
    {
      $userCollection = $this->asArray()->select('id')->where(['userId' => $userId, 'baseid' => 1])->first();
      if($action == "+")
      {
        if($collectionalbum->isAlbumInCollection($userCollection["id"], $albumId) == 0)
        {
          $collectionalbum->insertAlbumCollection($userCollection["id"], $albumId);
        }
      }
      elseif($action == "-")
      {
        if($collectionalbum->isAlbumInCollection($userCollection["id"], $albumId) > 0)
        {
          $collectionalbum->removeCollectionByAlbum($userCollection["id"], $albumId);
        }
      }
    }
    elseif($state == "none") # remove from all state collections
    {
      $baseList = [2, 3, 4, 5];
      $userBaseCollections = $this->asArray()->select('id')->where('userId', $userId)->whereIn('baseid', $baseList)->findAll();
      foreach($userBaseCollections as $collection)
      {
        $collectionalbum->removeCollectionByAlbum($collection["id"], $albumId);
      }
    }
    elseif($state == "wanting") # add to only wanting collection
    {
      $baseList = [2, 3, 4, 5];
      $userBaseCollections = $this->asArray()->select('id')->where('userId', $userId)->whereIn('baseid', $baseList)->findAll();
      foreach($userBaseCollections as $collection)
      {
        $collectionalbum->removeCollectionByAlbum($collection["id"], $albumId);
      }

      $userCollection = $this->asArray()->select('id')->where(['userId' => $userId, 'baseid' => 2])->first();
      $collectionalbum->insertAlbumCollection($userCollection["id"], $albumId);

      $activities = new Activity();
      $activities->insertActivity($userId, "want-collection", $albumId, false, $userCollection["id"]);
    }
    elseif($state == "waiting") # add to only waiting collection
    {
      $baseList = [2, 3, 4, 5];
      $userBaseCollections = $this->asArray()->select('id')->where('userId', $userId)->whereIn('baseid', $baseList)->findAll();
      foreach($userBaseCollections as $collection)
      {
        $collectionalbum->removeCollectionByAlbum($collection["id"], $albumId);
      }

      $userCollection = $this->asArray()->select('id')->where(['userId' => $userId, 'baseid' => 3])->first();
      $collectionalbum->insertAlbumCollection($userCollection["id"], $albumId);

      $activities = new Activity();
      $activities->insertActivity($userId, "wait-collection", $albumId, false, $userCollection["id"]);
    }
    elseif($state == "completed") # add to only completed collection
    {
      $baseList = [2, 3, 4, 5];
      $userBaseCollections = $this->asArray()->select('id')->where('userId', $userId)->whereIn('baseid', $baseList)->findAll();
      foreach($userBaseCollections as $collection)
      {
        $collectionalbum->removeCollectionByAlbum($collection["id"], $albumId);
      }

      $userCollection = $this->asArray()->select('id')->where(['userId' => $userId, 'baseid' => 4])->first();
      $collectionalbum->insertAlbumCollection($userCollection["id"], $albumId);

      $activities = new Activity();
      $activities->insertActivity($userId, "complete-collection", $albumId, false, $userCollection["id"]);
    }
    elseif($state == "dumped") # add to only dumped collection
    {
      $baseList = [2, 3, 4, 5];
      $userBaseCollections = $this->asArray()->select('id')->where('userId', $userId)->whereIn('baseid', $baseList)->findAll();
      foreach($userBaseCollections as $collection)
      {
        $collectionalbum->removeCollectionByAlbum($collection["id"], $albumId);
      }

      $userCollection = $this->asArray()->select('id')->where(['userId' => $userId, 'baseid' => 5])->first();
      $collectionalbum->insertAlbumCollection($userCollection["id"], $albumId);

      $activities = new Activity();
      $activities->insertActivity($userId, "dump-collection", $albumId, false, $userCollection["id"]);
    }


  }

	
}