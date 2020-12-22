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
        $division = $this->create($data->all());
        return $division ?? false;
    }
}
