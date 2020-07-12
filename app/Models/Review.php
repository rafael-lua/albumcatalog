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


}