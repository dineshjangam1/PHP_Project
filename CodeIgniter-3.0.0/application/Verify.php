<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include '../models/VerifyDao.php';
class Verify extends CI_Controller {


	public function index()
	{
		if(verify($_GET['email'],$_GET['v']))
		{
			header('Location: ../views/Login.php');
			die();
		}
		else
		{
			//cannot activate
			header('Location: ../views/Login.php?err3=1');
			die();
		}
	}
}
