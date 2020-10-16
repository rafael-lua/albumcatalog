<?php namespace App\Models;

use CodeIgniter\Model;

use App\Models\Artist;
use App\Models\Studio;
use App\Models\Genre;
use App\Models\Review;

###
# A model to work with user related data. Brings account information, login and data related to the ACCOUNT: reviews, ranking, collections, etc...
###

class User extends Model
{	
	protected $table = "useraccount";	
	protected $primaryKey = "id";
  protected $returnType = "array";
	
	
	
	# returns true or false if the user account/password match an account in the database!
	public function checkUser($username = false, $password = false)
	{
		# If this function is called without values for user/password, throws a error page back.
		if(($username === false) || ($username === NULL) || ($password === false) || ($password === NULL))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		$user = $this->asArray()->select('id')->where(['username' => $username, 'password' => $password])->first();
		
		if(is_array($user) && count($user) == 1){ return true; } else { return false; }
	}
	
	
	
	# returns basic data of the user to the login session, like id and username.
	public function getUser($username = false, $password = false)
	{
		# If this function is called without values for user/password, throws a error page back.
		if(($username === false) || ($username === NULL) || ($password === false) || ($password === NULL))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		return $this->asArray()->select('id, username')->where(['username' => $username, 'password' => $password])->first();
	}
	


	/* -------------------------------------------------------------------------- */
	/*                      returns public data of a user id                      */
	/* -------------------------------------------------------------------------- */

	public function getPublicUser($userid)
	{
		# If this function is called without values for userid, throws a error page back.
		if(($userid === false) || ($userid === NULL) || !is_numeric($userid))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
		
		return $this->asArray()->select('id, username as name')->where(['id' => $userid])->first();
	}
	
	
	
}