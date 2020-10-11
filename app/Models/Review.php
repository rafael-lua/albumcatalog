<?php namespace App\Models;

use CodeIgniter\Model;

###
# A model to work with review data.
###

class Review extends Model
{	
	protected $table = "review";	
	protected $primaryKey = "id";
	protected $returnType = "array";
	
	protected $allowedFields = ['userId', 'albumId', 'wording'];
	
	
	# Returns all the reviews based on the album id.
	public function getReviewsByAlbum($albumId = false)
	{
		# If this function is called without value for albumid, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		return $this->asArray()->select('username, wording', false)->from('useraccount')
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

		return $this->asArray()->select('wording')->where(['userId' => $userId, 'albumId' => $albumId])->first();

	}



	/* -------------------------------------------------------------------------- */
	/*                             Insert user's review                           */
	/* -------------------------------------------------------------------------- */

	public function insertReview($userId = false, $albumId = false, $wording = "")
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$review_exist = $this->select('userId')->where(['userId' => $userId, 'albumId' => $albumId])->countAllResults();
		if($review_exist <= 0)
		{
			$data = [
				'userId' => $userId,
				'albumId' => $albumId,
				'wording' => $wording
			];
			$this->insert($data);
		}
	}


	/* -------------------------------------------------------------------------- */
	/*                             Update user's review                           */
	/* -------------------------------------------------------------------------- */
	public function updateReview($userId = false, $albumId = false, $wording = "")
	{
		# If this function is called without values for albumId, throws a error page back.
		if(($albumId === false) || ($albumId === NULL) || !is_numeric($albumId) || ($userId === false) || ($userId === NULL) || !is_numeric($userId))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$review_exist = $this->select('userId')->where(['userId' => $userId, 'albumId' => $albumId])->countAllResults();
		if($review_exist > 0)
		{
			$this->where(['userId' => $userId, 'albumId' => $albumId])->set(['wording' => $wording])->update();
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
		}
	}


}