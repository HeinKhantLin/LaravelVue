<?php

namespace App\Repositories;

use App\Models\Tag;
use Exception;
use Illuminate\Support\Facades\DB;

class TagRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Tag());
    }

    public function getAll(){
        return $this->all();
    }

    public function createTag($data){
        $tag = $this->create($data->all());
        return $tag ?? false;
    }

    public function updateTag($data,$id){
        $tag = $this->update($data->all(),$id);
        return $tag ?? false;
    }

    public function deleteTag($id){
        $tag = $this->delete($id);
        return $tag ?? false;
    }
}
