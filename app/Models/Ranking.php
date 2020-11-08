<?php namespace App\Models;

use CodeIgniter\Model;

use App\Models\Search;
use App\Models\Collection;
use App\Models\Activity;

###
# A model to work with ranking data.
###

class Ranking extends Model
{	
	protected $table = "ranking";	
	protected $primaryKey = "userId";
	protected $returnType = "array";

	protected $allowedFields = ['userId', 'albumId', 'note', 'rankingDate'];
	

	/* -------------------------------------------------------------------------- */
	/*                 Return the note from the user to the album                 */
	/* -------------------------------------------------------------------------- */

	public function getUserAlbumRank($userId = false, $albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$userRank = $this->asArray()->select('note')->where(['userId' => $userId, 'albumId' => $albumId])->first();


		/* ----------------------- check if there is results. ----------------------- */
		/* ----------- If not, still returns an empty array for the array_merge ----------- */
		if(!empty($userRank)){
			return $userRank;
		}
		else
		{ 
			return [];
		}
	}



	/* -------------------------------------------------------------------------- */
	/*                 Return all notes from the user to all albums               */
	/* -------------------------------------------------------------------------- */

	public function getUserRankings($userId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$search = new Search();

		$userNotes = $this->asArray()->select('note, albumId, rankingDate')
											->where(['userId' => $userId])
											->orderBy('rankingDate', 'DESC')
											->findAll(5);

		foreach($userNotes as &$note)
		{
			$note = array_merge($note, $search->getAlbumName($note["albumId"]));
		}
		unset($note);


		return $userNotes;

	}




	/* -------------------------------------------------------------------------- */
	/*                 Updates/insert the user note for the album                 */
	/* -------------------------------------------------------------------------- */

	public function updateUserAlbumRank($userId = false, $albumId = false, $note = 0)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$activities = new Activity();

		/* ------------------ check if user already rated the album ----------------- */
		$rating_exist = $this->select('userId')->where(['userId' => $userId, 'albumId' => $albumId])->countAllResults();
		if($rating_exist <= 0)
		{
			$dateNow = date("Y-m-d");

			$data = [
				'userId' => $userId,
				'albumId' => $albumId,
				'note' => $note,
				'rankingDate' => $dateNow
			];
			$this->insert($data);

			$collections = new Collection();
			$collections->updateAlbumStateCollection($albumId, $userId, "ranking", "+");

			$activities->insertActivity($userId, "rank-album", $albumId, $note);

		}
		elseif($note == 0)
		{
			$this->where(['userId' => $userId, 'albumId' => $albumId])->delete();
			
			$collections = new Collection();
			$collections->updateAlbumStateCollection($albumId, $userId, "ranking", "-");
		}
		else
		{
			$dateNow = date("Y-m-d");

			$this->where(['userId' => $userId, 'albumId' => $albumId])->set(['note' => $note, 'rankingDate' => $dateNow])->update();

			$collections = new Collection();
			$collections->updateAlbumStateCollection($albumId, $userId, "ranking", "+");

			$activities->insertActivity($userId, "rank-album", $albumId, $note);
		}

	}
	
}