<?php

namespace App\Controllers;
use App\Models\Categories_model;
use App\Models\Product_model;

class Product extends BaseController{

    protected $category_model;
    protected $product_model;
    protected $session;

    public function __construct()
    {
        $this->category_model = New Categories_model();
        $this->product_model = new Product_model();
        $this->session = session();
    }

    public function index()
    {
        
        $product = $this->product_model->getProduct()->getResultArray();
        $category = $this->category_model->findAll();
        $data = [
            'products' => $product,
            'categories' => $category
        ];
        // dd($data);
        return view('admin/products', $data);
    }

    public function add()
    {
        $category = $this->category_model->findAll();
        $validation = \Config\Services::validation();
        $data = [
            'categories' => $category,
            'validation' => $validation
        ];
        return view('admin/add-product', $data);
    }

    public function save()
    {
        if(!$this->validate([
            'nama_barang' => [
                'rules' => 'required|is_unique[products.nama_barang]',
                'errors' => [
                    'required' => 'Nama barang harus diisi!',
                    'is_unique' => 'Nama barang harus unik'
                ]
            ],

            'id_category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'silahkan pilih category',
                ]
            ],

            'stock_barang' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'stock barang harus diisi',
                    'numeric' => 'stock barang harus berupa angka'
                ]
            ],

            'harga_beli' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'harga beli harus diisi',
                    'numeric' => 'harga beli harus berupa angka'
                ]
            ],

            'harga_jual' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'harga jual harus diisi',
                    'numeric' => 'harga beli harus berupa angka'
                ]
            ],

            'gambar' => [
                'rules' => 'uploaded[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,100]',
                'errors' => [
                    'uploaded' => 'Gambar wajib diunggah',
                    'mime_in' => 'Gambar harus berformat JPG atau PNG',
                    'max_size' => 'Ukuran gambar tidak boleh melebihi 100KB'
                ]
            ]

        ])){
            session()->setFlashdata('error', 'input data gagal silahkan perbaiki');
            session()->setFlashdata('error_input', $this->validator->listErrors());
            return redirect()->back();
        } 

        $file_gambar = $this->request->getFile('gambar');
        if($file_gambar->getError() == 4){
            $nama_gambar = 'default.jpg';
        }else{
            $nama_gambar = $file_gambar->getRandomName();
            $file_gambar->move('assets/img', $nama_gambar);
        }
            
        $nama_barang = $this->request->getVar('nama_barang');
        $id_category = $this->request->getVar('id_category');
        $stock_barang = $this->request->getVar('stock_barang');
        $harga_beli = $this->request->getVar('harga_beli');
        $harga_jual = $this->request->getVar('harga_jual');

        $product = [
            'nama_barang' =>  $nama_barang,
            'id_category' => $id_category,
            'stock_barang' => $stock_barang,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
            'gambar' => $nama_gambar
        ];

        // dd($product);
        $this->product_model->save($product);
        session()->setFlashdata('success', 'data berhasil di input');
        return redirect()->back();
    }

    public function edit($id)
    {
       $product = $this->product_model->getDetailProduct($id);
       $category = $this->category_model->findAll();
       $data = [
        'product' => $product,
        'categories' => $category
       ];
    //    dd($data);
       return view('admin/edit-product', $data);
    }

    public function update($id)
    {
        if(!$this->validate([
            'nama_barang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama barang harus diisi!'
                ]
            ],

            'id_category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'silahkan pilih category',
                ]
            ],

            'stock_barang' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'stock barang harus diisi',
                    'numeric' => 'stock barang harus berupa angka'
                ]
            ],

            'harga_beli' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'harga beli harus diisi',
                    'numeric' => 'harga beli harus berupa angka'
                ]
            ],

            'harga_jual' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'harga jual harus diisi',
                    'numeric' => 'harga beli harus berupa angka'
                ]
            ],

            'gambar' => [
                'rules' => 'mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,100]',
                'errors' => [
                    'uploaded' => 'Gambar wajib diunggah',
                    'mime_in' => 'Gambar harus berformat JPG atau PNG',
                    'max_size' => 'Ukuran gambar tidak boleh melebihi 100KB'
                ]
            ]

        ])){
            session()->setFlashdata('error', 'input data gagal silahkan perbaiki');
            session()->setFlashdata('error_input', $this->validator->listErrors());
            return redirect()->back();
        } 
        $file_gambar = $this->request->getFile('gambar');
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

        $nama_barang = $this->request->getVar('nama_barang');
        $id_category = $this->request->getVar('id_category');
        $stock_barang = $this->request->getVar('stock_barang');
        $harga_beli = $this->request->getVar('harga_beli');
        $harga_jual = $this->request->getVar('harga_jual');

        $product = [
            'id_product' => $id,
            'nama_barang' =>  $nama_barang,
            'id_category' => $id_category,
            'stock_barang' => $stock_barang,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
            'gambar' => $nama_gambar
        ];
        // dd($product);
        $this->product_model->save($product);
        session()->setFlashdata('success', 'data berhasil di update');
        return redirect()->back();
    }

    public function delete($id)
    {
        $product = $this->product_model->find($id);
        if($product['gambar'] != 'default.jpg'){
            unlink('assets/img/'.$product['gambar']);
        }

        $this->product_model->delete($id);
        session()->setFlashdata('success', 'berhasil menghapus'.' '.$product['nama_barang']);
        return redirect()->back();
    }

    public function search()
    {
        $nama_barang = $this->request->getVar('nama_barang');
        $id_category = $this->request->getVar('id_category');

        if($id_category){
            $products = $this->product_model->search($nama_barang, $id_category)->getResultArray();
        }elseif($nama_barang){
            $products = $this->product_model->search($nama_barang, $id_category)->getResultArray();
        }elseif($nama_barang && $id_category){
            $products = $this->product_model->search($nama_barang, $id_category)->getResultArray();
        }else{
            $products = $this->product_model->getProduct()->getResultArray();
        }

        $category = $this->category_model->findAll();
        $data = [
            'products' => $products,
            'categories' => $category
        ];
        // dd($data);
        return view('admin/products', $data);
    }

}
