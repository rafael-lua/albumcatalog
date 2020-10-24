<?php namespace App\Models;

use CodeIgniter\Model;

use App\Models\Search;
use App\Models\Collection;

/* -------------------------------------------------------------------------- */
/*                  A model to work with the user activities                  */
/* -------------------------------------------------------------------------- */


class Activity extends Model
{	
	protected $table = "activity";	
	protected $primaryKey = "userId";
	protected $returnType = "array";
	
  protected $allowedFields = ['userId', 'number', 'occurredDate', 'descri', 'hide', 'collectionReference'];
  
    
  /* -------------------------------------------------------------------------- */
  /*                          return all user activites                         */
  /* -------------------------------------------------------------------------- */
  
  public function getUserActivity($userId = false)
  {
    # If this function is called without values for albumId, throws a error page back.
		if(($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    

  }




  /* -------------------------------------------------------------------------- */
  /*                          return all user activites                         */
  /* -------------------------------------------------------------------------- */
  
  public function updateVisibility($userId = false, $collectionId = false, $hide = 0)
  {
    # If this function is called without values for userId or collectionId, throws a error page back.
		if(($userId === false) || ($userId === NULL) || !is_numeric($userId) || ($collectionId === false) || ($collectionId === NULL) || !is_numeric($collectionId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
    
    $this->where(['userId' => $userId, 'collectionReference' => $collectionId])->set(['hide' => $hide])->update();

  }



  /* -------------------------------------------------------------------------- */
  /*                          return all user activites                         */
  /* -------------------------------------------------------------------------- */
  
  public function insertActivity($userId = false, $type = false, $albumId = false, $rankValue = false, $collectionId = false)
  {
    # If this function is called without values for userId or type, throws a error page back.
		if(($userId === false) || ($userId === NULL) || !is_numeric($userId) || ($type === FALSE) || ($type === NULL) )
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    # ge the last activity number reference
    $lastActivity = $this->asArray()->select('number')->where('userId', $userId)->orderBy('number', 'DESC')->first();
    if($lastActivity == NULL){$lastActivity = 0;}
    else{$lastActivity = (int)$lastActivity["number"];}

    # check if collection is public or not, and get its name
    $hide = 0;
    if($collectionId != false && $collectionId != NULL)
    {
      $collections = new Collection();
      if($collections->getVisible($collectionId) == "hide"){$hide = 1;}

      $collectionName = $collections->getCollectionName($collectionId);
    }

    # get album's name
    if($albumId != false && $albumId != NULL)
    {
      $albums = new Search();
      $albumName = $albums->getAlbumName($albumId);
      $albumName = $albumName["name"];
    }

    

    $inserted = false;


    /* ----------------------- insert the correct activity ---------------------- */

    if($type == "rank-album")
    {
      $dateNow = date("Y-m-d");

      $data = [
				'userId' => $userId,
				'number' => $lastActivity + 1,
				'descri' => "Deu nota " . $rankValue . " ao álbum " . $albumName,
				'hide' => $hide,
        'occurredDate' => $dateNow,
        'collectionReference' => 0
			];
			$this->insert($data);
    }
    elseif($type == "review-album")
    {
      $dateNow = date("Y-m-d");

      $data = [
				'userId' => $userId,
				'number' => $lastActivity + 1,
				'descri' => "Escreveu uma crítica ao álbum " . $albumName,
				'hide' => $hide,
        'occurredDate' => $dateNow,
        'collectionReference' => 0
			];
			$this->insert($data);
    }
    elseif($type == "create-collection")
    {
      $dateNow = date("Y-m-d");

      $data = [
				'userId' => $userId,
				'number' => $lastActivity + 1,
				'descri' => "Criou a coleção " . $collectionName,
				'hide' => $hide,
        'occurredDate' => $dateNow,
        'collectionReference' => $collectionId
			];
			$this->insert($data);
    }
    elseif($type == "add-collection")
    {
      $dateNow = date("Y-m-d");

      $data = [
				'userId' => $userId,
				'number' => $lastActivity + 1,
				'descri' => "Adicionou o álbum " . $albumName . " à coleção " . $collectionName,
				'hide' => $hide,
        'occurredDate' => $dateNow,
        'collectionReference' => $collectionId
			];
			$this->insert($data);
    }
    elseif($type == "want-collection")
    {
      $dateNow = date("Y-m-d");

      $data = [
				'userId' => $userId,
				'number' => $lastActivity + 1,
				'descri' => "Pretende escutar o álbum " . $albumName,
				'hide' => $hide,
        'occurredDate' => $dateNow,
        'collectionReference' => $collectionId
			];
			$this->insert($data);
    }
    elseif($type == "complete-collection")
    {
      $dateNow = date("Y-m-d");

      $data = [
				'userId' => $userId,
				'number' => $lastActivity + 1,
				'descri' => "Completou o álbum " . $albumName,
				'hide' => $hide,
        'occurredDate' => $dateNow,
        'collectionReference' => $collectionId
			];
			$this->insert($data);
    }
    elseif($type == "dump-collection")
    {
      $dateNow = date("Y-m-d");

      $data = [
				'userId' => $userId,
				'number' => $lastActivity + 1,
				'descri' => "Abandonou o álbum " . $albumName,
				'hide' => $hide,
        'occurredDate' => $dateNow,
        'collectionReference' => $collectionId
			];
			$this->insert($data);
    }
    elseif($type == "wait-collection")
    {
      $dateNow = date("Y-m-d");

      $data = [
				'userId' => $userId,
				'number' => $lastActivity + 1,
				'descri' => "Esperando lançar o álbum " . $albumName,
				'hide' => $hide,
        'occurredDate' => $dateNow,
        'collectionReference' => $collectionId
			];
			$this->insert($data);
    }


    # Check if user has more than 100 activities. If it has, delete the oldest one. 
    if($inserted == true)
    {
      

    }

  }

	


}