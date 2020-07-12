<?php namespace App\Models;

use CodeIgniter\Model;

###
# A model to work with ranking data.
###

class Ranking extends Model
{	
	protected $table = "ranking";	
	protected $primaryKey = "userId";
    protected $returnType = "array";
	
}