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
        $id = session()->get('id_user');
        $profile = $this->auth_model->find($id);
        $data = [
            'profile' => $profile
        ];
        // dd($data);
        return view('dashboard', $data);
    }


    public function profile($id)
    {
        $profile = $this->auth_model->find($id);
        $data = [
            'profile' => $profile
        ];

        return view('admin/profile', $data);
    }

    public function edit_profile($id)
    {
        $profile = $this->auth_model->find($id);
        $data = [
            'profile' => $profile
        ];
        return view('admin/edit_profile', $data);
    }

    public function update_profile($id)
    {

        if(!$this->validate([
            'gambar' => [
                'rules' => 'mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'mime_in' => 'Gambar harus berformat JPG atau PNG',
                ]
            ]

        ])){
            session()->setFlashdata('error', 'input data gagal silahkan perbaiki');
            session()->setFlashdata('error_input', $this->validator->listErrors());
            return redirect()->back();
        } 

        $file_gambar = $this->request->getFile('gambar');
        // dd($file_gambar);
        if($file_gambar->getError() == 4){
            $nama_gambar = $this->request->getVar('gambar_lama');
        }elseif($file_gambar->getError() == null){
            $nama_gambar = $file_gambar->getRandomName();
            $file_gambar->move('assets/img', $nama_gambar);
        }
        else{
            $nama_gambar = $file_gambar->getRandomName();
            $file_gambar->move('assets/img', $nama_gambar);
            unlink('assets/img'.$this->request->getVar('gambar_lama'));
        }

        $name = $this->request->getVar('name');
        $position = $this->request->getVar('position');
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $profile = [
            'id_user' => $id,
            'name' => $name,
            'position' => $position,
            'username' => $username,
            'password' => $password,
            'gambar' => $nama_gambar
        ];

       $this->auth_model->save($profile);
       session()->setFlashdata('success', 'data berhasil di update');
       return redirect()->back();
    }
}
