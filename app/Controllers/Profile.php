<?php

namespace App\Controllers;
use App\Models\Categories_model;
use App\Models\Product_model;
use App\Models\Auth_model;

class Profile extends BaseController{

    protected $auth_model;
    protected $session;
    public function __construct()
    {
        $this->auth_model = new Auth_model();
        $this->session = session();
    }
    public function index()
    {
        
    }

}