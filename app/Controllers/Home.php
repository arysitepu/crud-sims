<?php

namespace App\Controllers;
use App\Models\Auth_model;
class Home extends BaseController
{

    protected $session;
    protected $auth_model;

    public function __construct()
    {
        $this->session = session();
        $this->auth_model = new Auth_model();
    }
    public function index()
    {
        if(!$this->session->has('isLogin')){
            return redirect()->to('/');
        }
        return view('dashboard');
    }


    public function user()
    {
        echo "berhasil masuk sebagai user";
    }
}
