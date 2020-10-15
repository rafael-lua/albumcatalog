<?php namespace App\Models;

use CodeIgniter\Model;

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
	
  protected $allowedFields = ['userId', 'title', 'visible'];


  /* -------------------------------------------------------------------------- */
  /*                 return all informations about a collection                 */
  /* -------------------------------------------------------------------------- */

	public function getFullCollection($collectionId = false)
	{



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
    
    $collections = $this->asArray()->select('id, title, visible')->where(['userId' => $userId])->findAll();

    foreach($collections as &$collection) # & makes it so it is by reference and can be modified
    {
      $collection["genres"] = $this->asArray()->select('genre.name', FALSE)
                                            ->from('genre, collectiongenre')
                                            ->where(['collection.id' => 'collectiongenre.collectionId', 'genre.name' => 'collectiongenre.genreName'], NULL, FALSE)
                                            ->where('collection.id', $collection["id"], NULL, FALSE)
                                            ->findAll();
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
    $collectiongenre->insertCollectionGenre($collectionId, $genres);

    return $collectionId;

  }

	
}