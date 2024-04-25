<?php

namespace App\Models;
use CodeIgniter\Model;

class Auth_model extends Model{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'username', 'password', 'role'];
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}