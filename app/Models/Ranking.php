<?php namespace App\Models;

use CodeIgniter\Model;

use App\Models\Search;

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

		return $this->asArray()->select('note')->where(['userId' => $userId, 'albumId' => $albumId])->first();

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

		/* ------------------ check if user already rated the album ----------------- */
		$rating_exist = $this->select('userId')->where(['userId' => $userId, 'albumId' => $albumId])->countAllResults();
		if($rating_exist <= 0)
		{
			$data = [
				'userId' => $userId,
				'albumId' => $albumId,
				'note' => $note
			];
			$this->insert($data);
		}
		elseif($note == 0)
		{
			$this->where(['userId' => $userId, 'albumId' => $albumId])->delete();
		}
		else
		{
			$this->where(['userId' => $userId, 'albumId' => $albumId])->set(['note' => $note])->update();
		}
	}
	
}