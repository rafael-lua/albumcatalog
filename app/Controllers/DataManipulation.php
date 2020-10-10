<?php namespace App\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Ranking;

class DataManipulation extends BaseController
{
	
	public function index()
	{
    return redirect()->to(base_url());		
	}


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

	
}