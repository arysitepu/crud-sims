<?php

namespace App\Controllers;
use App\Models\Auth_model;

class Auth extends BaseController
{
    protected $auth_model;
    protected $session;

    public function __construct()
    {
        $this->auth_model = new Auth_model();
        $this->session = session();
    }
    public function index()
    {
        return view('login');
    }

    public function login_process()
    {
        $data = $this->request->getVar();
        // dd($data['username'], $data['password']);
        $user = $this->auth_model->where('username', $data['username'])->first();
        
        if($user){
            // dd($user);
            if($data['password'] !== $user['password']){
                session()->setFlashdata('error_login', 'email atau password anda salah silahkan input dengan benar');
                return redirect()->back();
            }else{
                $redirectRoute = $this->getRedirectRoute($user['role']);
                // dd($redirectRoute);
                $sessLogin = [
                    'isLogin' => true,
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                // dd($sessLogin);
                session()->set($sessLogin);
                return redirect()->to(base_url($redirectRoute));
            }
        }else{
            session()->setFlashdata('error_login', 'username tidak ditemukan');
            return redirect()->back();
        }
    }

    public function getRedirectRoute($role)
    {
        switch($role){
            case 1:
                return 'superadmin/dashboard';
            case 0: 
                return '/user/dashboard';
        }
    }

    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
