<?php namespace App\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Ranking;
use App\Models\Collection;
use App\Models\StatusAlbum;


class DataManipulation extends BaseController
{
	
	public function index()
	{
    return redirect()->to(base_url());		
	}


  /* -------------------------------------------------------------------------- */
  /*                     Update the user's rank to the album                    */
  /* -------------------------------------------------------------------------- */

  public function updateRanking()
  {

    if(!$this->validate([
      "userid" 				=> 		"required",
      "albumid" 			=> 		"required",
      "note" 				  => 		"required",
		]))
		{
			return redirect()->to(base_url());
		}
		else
		{

      if($this->session->has("userAccount"))
      {
        $userId = $this->request->getVar("userid");
        $albumId = $this->request->getVar("albumid");
        $note = $this->request->getVar("note");

        $ranking = new Ranking();
        $ranking->updateUserAlbumRank($userId, $albumId, $note);

        return redirect()->to(base_url('search/showalbum/'.$albumId));
      }
    }

  }

  /* -------------------------------------------------------------------------- */
  /*               Insert/Update/Delete user's review on the album              */
  /* -------------------------------------------------------------------------- */

  public function updateReview()
  {

    if(!$this->validate([
      "userid" 				=> 		"required",
      "albumid" 			=> 		"required",
      "wording" 		  => 		"permit_empty|max_length[5000]|min_length[50]",
      "reviewtitle"   => 		"permit_empty|max_length[50]|min_length[5]",
      "action"        =>    "required|in_list[insert, update, delete]"
		]))
		{
      // echo $this->validator->listErrors();
			return redirect()->to(base_url());
		}
		else
		{
      $reviews = new Review();
      $action = $this->request->getVar("action");
      $wording = $this->request->getVar("wording");
      $title = $this->request->getVar("reviewtitle");

      if($action == "insert" && !empty($wording))
      {
        $reviews->insertReview($this->request->getVar("userid"), $this->request->getVar("albumid"), $wording, $title);
      }
      elseif($action == "update" && !empty($wording))
      {
        $reviews->updateReview($this->request->getVar("userid"), $this->request->getVar("albumid"), $wording, $title);
      }
      elseif($action == "delete")
      {
        $reviews->deleteReview($this->request->getVar("userid"), $this->request->getVar("albumid"));
      }


      return redirect()->to(base_url('search/showalbum/'.$this->request->getVar("albumid")));
    }
  }




  /* -------------------------------------------------------------------------- */
  /*                          changes the album state                           */
  /* -------------------------------------------------------------------------- */

  public function changeAlbumState()
  {

    if(!$this->validate([
      "albumid"               =>           "required",
      "statevalue"            =>           "required|in_list[0,1,2,3,4]",
		]) || !$this->session->has("userAccount"))
		{
      // echo $this->validator->listErrors();
			return redirect()->to(base_url());
		}
		else
		{
      $user = $this->session->get("userAccount");
      $albumId = $this->request->getVar("albumid");
      $stateValue = $this->request->getVar("statevalue");

      $status = new StatusAlbum();
      $status->updateAlbumState($user["id"], $albumId, $stateValue);

      return redirect()->to(base_url('search/showalbum/'.$albumId));          
    }
  }






    
  /* -------------------------------------------------------------------------- */
  /*                           create a new collection                          */
  /* -------------------------------------------------------------------------- */

  public function createCollection()
  {

    if(!$this->validate([
      "visibility"          =>    "required|in_list[show, hide]",
      "collectiontitle"     =>    "required|max_length[50]|min_length[4]",
      "genres[]" 			      => 		"permit_empty|in_list[rock, pop, electronic, classical, jazz]",
		]) || !$this->session->has("userAccount"))
		{
      // echo $this->validator->listErrors();
			return redirect()->to(base_url());
		}
		else
		{

      /* ----------------------- prepare data for creation ----------------------- */
      $user = $this->session->get("userAccount");

      $collections = new Collection();


      $collectionTitle = $this->request->getVar("collectiontitle");
      $collectionVisibility = $this->request->getVar("visibility");

      if(empty($this->request->getVar("genres[]")))
      {
        $colletionGenres = [];
      }  
      else
      {
        $colletionGenres = $this->request->getVar("genres[]");
      } 
      
      $newCollectionId = $collections->insertCollection($user["id"], $collectionTitle, $collectionVisibility, $colletionGenres);

      return redirect()->to(base_url('collection/'.$newCollectionId));      
      
    }
  }



  /* -------------------------------------------------------------------------- */
  /*                      update a existing collection                          */
  /* -------------------------------------------------------------------------- */

  public function updateCollection()
  {

    if(!$this->validate([
      "collectionid"        =>    "required",
      "collectiontitle"     =>    "required|max_length[50]|min_length[4]",
      "genres[]" 			      => 		"permit_empty|in_list[rock, pop, electronic, classical, jazz]",
		]) || !$this->session->has("userAccount"))
		{
      // echo $this->validator->listErrors();
			return redirect()->to(base_url());
		}
		else
		{

      $collections = new Collection();

      $collectionId = $this->request->getVar("collectionid");
      $collectionTitle = $this->request->getVar("collectiontitle");

      if(empty($this->request->getVar("genres[]")))
      {
        $colletionGenres = [];
      }  
      else
      {
        $colletionGenres = $this->request->getVar("genres[]");
      } 
      
      $newCollectionId = $collections->updateCollection($collectionId, $collectionTitle, $colletionGenres);

      return redirect()->to(base_url('painel'));      
      
    }
  }




  /* -------------------------------------------------------------------------- */
  /*                      add album to existing collection                      */
  /* -------------------------------------------------------------------------- */

  public function addToCollection()
  {

    if(!$this->validate([
      "albumId"             =>    "required",
      "collectionIds[]" 	  => 		"permit_empty",
		]) || !$this->session->has("userAccount"))
		{
      // echo $this->validator->listErrors();
			return redirect()->to(base_url());
		}
		else
		{
      $userAccount = $this->session->get("userAccount");

      $albumId = $this->request->getVar("albumId");
      $collectionIds = $this->request->getVar("collectionIds[]");
      if($collectionIds == NULL){$collectionIds = [];}
      
      $collections = new Collection();
      $userCollections = $collections->getCollectionByUser($userAccount["id"]);
      $collections->addAlbumCollection($collectionIds, $albumId, $userCollections);
              

      return redirect()->to(base_url('search/showalbum/'.$albumId));      
      
    }
  }



  /* -------------------------------------------------------------------------- */
  /*                      toggles the collection visibility                     */
  /* -------------------------------------------------------------------------- */

  public function toggleCollectionVisibility()
  {

    if(!$this->validate([
      "collectionid"          =>          "required",
		]) || !$this->session->has("userAccount"))
		{
      // echo $this->validator->listErrors();
			return redirect()->to(base_url());
		}
		else
		{
      $collectionid = $this->request->getVar("collectionid");

      $collections = new Collection();
      $collections->toggleVisible($collectionid);

      return redirect()->to(base_url('painel'));      
      
    }
  }


  /* -------------------------------------------------------------------------- */
  /*                           deletes the collection                           */
  /* -------------------------------------------------------------------------- */

  public function deleteCollection()
  {

    if(!$this->validate([
      "collectionid"          =>          "required",
		]) || !$this->session->has("userAccount"))
		{
      // echo $this->validator->listErrors();
			return redirect()->to(base_url());
		}
		else
		{
      $collectionid = $this->request->getVar("collectionid");

      $collections = new Collection();
      $collections->deleteCollection($collectionid);

      return redirect()->to(base_url('painel'));      
      
    }
  }

}