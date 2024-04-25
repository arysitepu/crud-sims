<?php

namespace App\Models;
use CodeIgniter\Model;

class Categories_model extends Model{
    protected $table = 'categories';
    protected $primaryKey = 'id_category';
    protected $useTimestamps = true;
    protected $allowedFields = ['name_category'];
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function getCategories(){
        $builder = $this->select('*');
        $query = $builder->get();

        return $query;
    }
}

