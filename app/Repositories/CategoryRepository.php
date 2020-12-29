<?php

namespace App\Repositories;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Category());
    }

    public function getAll(){
        return $this->all();
    }

    public function createCategory($data){
        $category = $this->create($data->all());
        return $category ?? false;
    }

    public function updateCategory($data,$id){
        $category = $this->update($data->all(),$id);
        return $category ?? false;
    }

    public function deleteCategory($id){
        $category = $this->delete($id);
        return $category ?? false;
    }
}
