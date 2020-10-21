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

class StatusAlbum extends Model
{	
	protected $table = "statusalbum";	
	protected $primaryKey = "userId";
  protected $returnType = "array";
	
	protected $allowedFields = ['userId', 'albumId', 'state'];
	


	/* -------------------------------------------------------------------------- */
	/*                     get the album's state by user                          */
	/* -------------------------------------------------------------------------- */

	public function getAlbumStateByUser($userId = false, $albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		$state = $this->asArray()->select('state')->where(['albumId' => $albumId, 'userId' => $userId], NULL, FALSE)->first();
		
		if(!empty($state)){
			
			return $state["state"];
		}
		else
		{
			return "none";
		}
	}


  /* -------------------------------------------------------------------------- */
  /*                     update the album's state by user                       */
  /*                         insert case don't exist                            */
	/* -------------------------------------------------------------------------- */

	public function updateAlbumState($userId = false, $albumId = false, $stateValue = 0)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    if($stateValue == 0){ $newState = "none"; }
    elseif($stateValue == 1){ $newState = "wanting"; }
    elseif($stateValue == 2){ $newState = "waiting"; }
    elseif($stateValue == 3){ $newState = "completed"; }
    elseif($stateValue == 4){ $newState = "dumped"; }
		
		$state_exist = $this->select('state')->where(['userId' => $userId, 'albumId' => $albumId])->countAllResults();
		if($state_exist > 0)
		{
			$this->where(['userId' => $userId, 'albumId' => $albumId])->set(['state' => $newState])->update();
		}
		else
		{
      $data = [
				'userId' => $userId,
				'albumId' => $albumId,
        'state' => $newState,      
      ];
			$this->insert($data);
		}

	}


  
	
}