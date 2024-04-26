<?php

namespace App\Controllers;
use App\Models\Categories_model;
use App\Models\Product_model;
use App\Models\Auth_model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Product extends BaseController{

    protected $category_model;
    protected $product_model;
    protected $auth_model;
    protected $session;

    public function __construct()
    {
        $this->category_model = New Categories_model();
        $this->product_model = new Product_model();
        $this->auth_model = new Auth_model();
        $this->session = session();
    }

    public function index()
    {
        $id = session()->get('id_user');
        $profile = $this->auth_model->find($id);
        $product = $this->product_model->getProduct()->getResultArray();
        $category = $this->category_model->findAll();
        $data = [
            'products' => $product,
            'categories' => $category,
            'profile' => $profile
        ];
        // dd($data);
        return view('admin/products', $data);
    }

    public function add()
    {
        $id = session()->get('id_user');
        $profile = $this->auth_model->find($id);
        $category = $this->category_model->findAll();
        $validation = \Config\Services::validation();
        $data = [
            'categories' => $category,
            'validation' => $validation,
            'profile' => $profile
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
       $id_user = session()->get('id_user');
       $profile = $this->auth_model->find($id_user);
       $product = $this->product_model->getDetailProduct($id);
    //    dd($product);
       $category = $this->category_model->findAll();
       $data = [
        'product' => $product,
        'categories' => $category,
        'profile' => $profile
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

        $id_user = session()->get('id_user');
        $profile = $this->auth_model->find($id_user);
        $category = $this->category_model->findAll();
        $data = [
            'products' => $products,
            'categories' => $category,
            'profile' => $profile
        ];
        // dd($data);
        return view('admin/products', $data);
    }

    public function excel()
    {
       
        $nama_barang = $this->request->getVar('nama_barang');
        $id_category = $this->request->getVar('id_category');

       // Inisialisasi variabel $products
        $products = [];

        // Periksa apakah terdapat nilai $nama_barang dan $id_category
        if($nama_barang && $id_category){
            $products = $this->product_model->search($nama_barang, $id_category)->getResult();
        } elseif($nama_barang) {
            $products = $this->product_model->search($nama_barang, $id_category)->getResult();
        } elseif($id_category) {
            $products = $this->product_model->search($nama_barang, $id_category)->getResult();
            // dd($products);
        } else {
            $products = $this->product_model->getProduct()->getResult();
        }
        
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'No');
        $activeWorksheet->setCellValue('B1', 'Nama Barang');
        $activeWorksheet->setCellValue('C1', 'Kategori');
        $activeWorksheet->setCellValue('D1', 'Harga beli');
        $activeWorksheet->setCellValue('E1', 'Harga Jual');
        $activeWorksheet->setCellValue('F1', 'Stock Barang');
        

        $column = 2;
        foreach($products as $product){
            $activeWorksheet->setCellValue('A'.$column, ($column-1));
            $activeWorksheet->setCellValue('B'.$column, $product->nama_barang);
            $activeWorksheet->setCellValue('C'.$column, $product->name_category);
            $activeWorksheet->setCellValue('D'.$column, 'Rp.'.' '.number_format($product->harga_beli, 2, ',', '.'));
            $activeWorksheet->setCellValue('E'.$column, 'Rp.'.' '.number_format($product->harga_jual, 2, ',', '.'));
            $activeWorksheet->setCellValue('F'.$column, $product->stock_barang);
            $column++;
        }

        $activeWorksheet->getStyle('A1:F1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1:F1')->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000']
                ]
            ]
        ];

        $activeWorksheet->getStyle('A1:F'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('C')->setWidth(20);
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
       

        $writer = new Xlsx($spreadsheet);
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=Data Barang.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

}
