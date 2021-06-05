<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Master_model;
use CodeIgniter\Controller;

class Discussion extends Controller
{
	public function __construct()
	{
		$this->master = new Master_model();
	}
	
	public function index()
	{
		//
	}
}
