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

class CollectionAlbum extends Model
{	
	protected $table = "collectionalbum";	
	protected $primaryKey = "collectionId";
  protected $returnType = "array";
	
  protected $allowedFields = ['collectionId', 'albumId'];


 

	
  
  
	
}