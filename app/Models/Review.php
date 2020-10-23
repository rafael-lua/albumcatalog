<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\Activity;

use App\Models\Collection;

###
# A model to work with review data.
###

class Review extends Model
{	
	protected $table = "review";	
	protected $primaryKey = "id";
	protected $returnType = "array";
	
	protected $allowedFields = ['userId', 'albumId', 'wording', 'title', 'creationDate'];
	
	



	# Returns all the reviews based on the album id.
	public function getReviewsByAlbum($albumId = false)
	{
		# If this function is called without value for albumid, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		return $this->asArray()->select('useraccount.id as userId, username, review.title, review.wording, review.creationDate', false)->from('useraccount')
							->where(['review.userId' => 'useraccount.id', 'review.albumId' => $albumId], NULL, FALSE)
							->findAll();
		
	}



	/* -------------------------------------------------------------------------- */
	/*                 Return the review from the user to the album               */
	/* -------------------------------------------------------------------------- */

	public function getUserAlbumReview($userId = false, $albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		return $this->asArray()->select('wording, title, creationDate')->where(['userId' => $userId, 'albumId' => $albumId])->first();

	}



	
	/* -------------------------------------------------------------------------- */
	/*                 Return the review from the user to the album               */
	/* -------------------------------------------------------------------------- */

	public function getUserAlbumReviewRecent($userId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		return $this->asArray()->select('wording, title, creationDate, albumId')
													->where(['userId' => $userId])
													->orderBy('creationDate', 'DESC')
													->first();

	}



	/* -------------------------------------------------------------------------- */
	/*                             Insert user's review                           */
	/* -------------------------------------------------------------------------- */

	public function insertReview($userId = false, $albumId = false, $wording = "", $title = "")
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$activities = new Activity();

		$review_exist = $this->select('userId')->where(['userId' => $userId, 'albumId' => $albumId])->countAllResults();
		if($review_exist <= 0)
		{
			$dateNow = date("Y-m-d");

			$data = [
				'userId' => $userId,
				'albumId' => $albumId,
				'wording' => $wording,
				'title' => $title,
				'creationDate' => $dateNow
			];
			$this->insert($data);

			$collections = new Collection();
			$collections->updateAlbumStateCollection($albumId, $userId, "review", "+");

			$activities->insertActivity($userId, "review-album", $albumId);
		}

	}


	/* -------------------------------------------------------------------------- */
	/*                             Update user's review                           */
	/* -------------------------------------------------------------------------- */
	public function updateReview($userId = false, $albumId = false, $wording = "", $title = "")
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$activities = new Activity();

		$review_exist = $this->select('userId')->where(['userId' => $userId, 'albumId' => $albumId])->countAllResults();
		if($review_exist > 0)
		{
			$this->where(['userId' => $userId, 'albumId' => $albumId])->set(['wording' => $wording, 'title' => $title])->update();
			
			$collections = new Collection();
			$collections->updateAlbumStateCollection($albumId, $userId, "review", "+");

			$activities->insertActivity($userId, "review-album", $albumId);
		}
	}



	/* -------------------------------------------------------------------------- */
	/*                             Delete user's review                           */
	/* -------------------------------------------------------------------------- */
	public function deleteReview($userId = false, $albumId = false)
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$review_exist = $this->select('userId')->where(['userId' => $userId, 'albumId' => $albumId])->countAllResults();
		if($review_exist > 0)
		{
			$this->where(['userId' => $userId, 'albumId' => $albumId])->delete();

			$collections = new Collection();
			$collections->updateAlbumStateCollection($albumId, $userId, "review", "-");
		}
	}


}