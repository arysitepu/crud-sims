<?php

namespace App\Controllers;
use App\Models\Categories_model;

class Categories extends BaseController{


    protected $category_model;

    public function __construct()
    {
        $this->category_model = new Categories_model();
    }

    public function index()
    {

        $categories = $this->category_model->findAll();

        $data = [
            'name_category' => $categories
        ];

        dd($data);
    }

}