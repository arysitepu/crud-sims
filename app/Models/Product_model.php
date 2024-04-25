<?php

namespace App\Models;
use CodeIgniter\Model;

class Product_model extends Model{
    protected $table = 'products';
    protected $primaryKey = 'id_product';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_barang', 'harga_beli', 'harga_jual', 'stock_barang', 'id_category', 'gambar'];
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
   

    public function getProduct()
    {
        $builder = $this->select('*');
        $builder->join('categories', 'products.id_category = categories.id_category');
        $builder->orderBy('products.id_product', 'DESC');
        $query = $builder->get();
        return $query;
    }

    public function getDetailProduct($id)
    {
        $builder = $this->select('*');
        $builder->join('categories', 'products.id_category = categories.id_category');
        $query = $builder->where('id_product', $id)->first();
        return $query;
    }

    public function search($nama_barang, $id_category)
    {
        $builder = $this->select('*');
        $builder->join('categories', 'products.id_category = categories.id_category');
        if($nama_barang){
            $query = $builder->like('products.nama_barang', $nama_barang);
            return $query->get();
        }

        if($id_category){
            $query = $builder->where('products.id_category', $id_category);
            return $query->get();
        }
        
        if($nama_barang && $id_category){
            $query = $builder->like('products.nama_barang', $nama_barang)->where('products.id_category',$id_category);
            return $query->get();
        }
    }

}
