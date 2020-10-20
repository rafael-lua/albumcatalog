<?php namespace App\Models;

use CodeIgniter\Model;


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

class CollectionGenre extends Model
{	
	protected $table = "collectiongenre";	
	protected $primaryKey = "collectionId";
  protected $returnType = "array";
	
  protected $allowedFields = ['collectionId', 'genreName'];


  /* -------------------------------------------------------------------------- */
  /*                       insert a collection genre entry                      */
  /* -------------------------------------------------------------------------- */

  public function insertCollectionGenre($collectionId = false, $genreName = false)
	{

    # If this function is called without values for userId, throws a error page back.
		if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId) || ($genreName === false) || ($genreName === NULL))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    $data = [
        'collectionId' => $collectionId,
        'genreName' => $genreName,
    ];
  
    $this->insert($data); 
    

  }


  /* -------------------------------------------------------------------------- */
  /*                      remove collection genre reference                     */
  /* -------------------------------------------------------------------------- */
  
  
  public function removeCollectionGenres($collectionId = false)
  {

    # If this function is called without values for userId, throws a error page back.
    if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
    {
      throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    $this->where(['collectionId' => $collectionId])->delete();
  
  }



    
  /* -------------------------------------------------------------------------- */
  /*                          Get the collection genres                         */
  /* -------------------------------------------------------------------------- */
  
	public function getCollectionGenre($collectionId = false)
	{

    # If this function is called without values for userId, throws a error page back.
		if(($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    return $this->asArray()->select('genreName as name')->where('collectionId', $collectionId)->findAll();    

  }

  
}