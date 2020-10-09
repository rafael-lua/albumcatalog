<?php namespace App\Controllers;



use App\Models\User;

class Accounts extends BaseController
{
	public function index()
	{
		# When the base account route is called, it brings the user page index.
	}
	
	###
	# Validates and log the user on the system!
	###
	public function login()
	{
		
		if(!$this->validate([
			"username" => 	"required",
			"password" => 	"required",
		]))
		{
			$this->session->set("homeErrorId", 1);
			return redirect()->to(base_url());
		}
		else
		{
			$username = $this->request->getVar("username", FILTER_SANITIZE_SPECIAL_CHARS);
			$password = $this->request->getVar("password", FILTER_SANITIZE_SPECIAL_CHARS);
			
			$userModel = new User();
			$userCheck = $userModel->checkUser($username, $password);
			
			if($userCheck == true)
			{
				$userAccount = $userModel->getUser($username, $password);
				$this->session->set("userAccount", $userAccount);
				
				return redirect()->to(base_url());
				
			}
			else
			{
				$this->session->set("homeErrorId", 2);
				return redirect()->to(base_url());
			}
			
		}
		
	}
	
	###
	# If the user is logged, log it off!
	###
	public function logoff()
	{
		if($this->session->has("userAccount"))
		{
			$this->session->remove("userAccount");
			return redirect()->to(base_url());
		}
		else
		{
			return redirect()->to(base_url());
		}
	}



	/* -------------------------------------------------------------------------- */
	/*                             User painel control                            */
	/* -------------------------------------------------------------------------- */

	public function userPainel()
	{
		if(!$this->session->has("userAccount"))
		{
			return redirect()->to(base_url());
		}
		else
		{

			$data = [];

			if($this->session->has("userAccount"))
			{
				$data["userAccount"] = $this->session->get("userAccount");
			}


			

			
			echo view('templates/header', $data);
			echo view('templates/loginsection', $data);
			echo view('mainpages/userpage', $data);
			echo view('templates/footer');
		}		

	}

}