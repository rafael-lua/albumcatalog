<?php namespace App\Controllers;


# Controle principal da aplicação.
# Ele é usado para chamada de páginas principais da aplicação, que estão dentro da pasta mainpages. 
# Por exemplo o home, about, etc...

class Mainpage extends BaseController
{	
	# The index function that monts the home page!
	public function index()
	{
		$data = [];
		
		if($this->session->has("userAccount"))
		{
			$data["userAccount"] = $this->session->get("userAccount");
		}
		
		# Home errors handling. Each ID triggers a different error message.
		$errorNumber = $this->session->get("homeErrorId");
		if(!empty($errorNumber) && $errorNumber != 0)
		{
			switch ($errorNumber) {
				case 1: # Search empty error!
					$data["searchError"] = "Digite um nome para pesquisar!";
					$this->session->set("homeErrorId", 0);
					break;
				case 2: # Login error!
					$data["loginError"] = "Usuário/senha são obrigatórios ou estão incorretos!";
					$this->session->set("homeErrorId", 0);
					break;
				case 3: # No results found (!SHOULD CHANGE IN THE FUTURE, THE NO REUSLTS PAGE SHOULD BE THE SAME OF THE RESULTS!)
					$data["searchError"] = "Nenhum resultado encontrado! Tente algo diferente...";
					$this->session->set("homeErrorId", 0);
					break;
			}
		}
		
		echo view('templates/header');
		echo view('templates/loginsection', $data);
		echo view('mainpages/home', $data);
		echo view('templates/footer');
	}
	
	# Every route that should end in the home of the website will call the redirectHome of this control.
	# Then the route of base_url you take care of sending to home. This is done so the url in the browser is 
	# reseted to only "something.com" or "localhost/" instead of the full url that was redirected
	public function redirectHome()
	{
		return redirect()->to(base_url());
	}
	
	# This view will show the page that is called of it exists in the mainpages folder
	public function view($page = 'home')
	{
		# Check if the page exists
		if(!is_file(APPPATH.'Views/mainpages/'.$page.'.php'))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		}
		
		$data = [];
		if($this->session->has("userAccount"))
		{
			$data["userAccount"] = $this->session->get("userAccount");
		}
		
		echo view('templates/header');
		echo view('templates/loginsection', $data);
		echo view('mainpages/'.$page, $data);
		echo view('templates/footer');
	}
	
	# views of test are called by the route in here. Will be removed when deployed.
	public function debugView()
	{
		echo view('test/headertest');
		echo view('test/bulmatest');
		echo view('templates/footer');
	}
	
}