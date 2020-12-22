<?php

namespace App\Repositories;

class BaseRepository
{
    protected $model;

    /**
    * BaseRepository constructor.
    * @param $model
    */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
    * @return mixed
    */
    public function first()
    {
        return $this->model->first();
    }

    /**
    * @param $id
    * @return mixed
    */
    public function find($id)
    {

        return $this->model->find($id);
    }

    /**
    * @param $data
    * @return mixed
    */
    public function create($data)
    {
        return $this->model->create($data);

//        foreach ($data as $index => $value) {
//            $this->model->{$index} = $value;
//        }
//        $this->model->save();
//        return $this->model;
    }

    /**
    * @param $data
    * @return mixed
    */
    public function createMany($data)
    {
        return $this->model->createMany($data);
    }

    /**
    * @param null $data
    * @return mixed
    */
    public function get($data = null)
    {
        return $this->model->get($data);
    }

    /**
    * @param $data
    * @param $id
    * @return mixed
    */
    public function update($data, $id)
    {
        return tap($this->model->find($id))->update($data);

//        $model = $this->model->find($id);
//        foreach ($data as $index => $value) {
//            $model->{$index} = $value;
//        }
//        $model->save();
//        $model->searchable();
//        return $this->model;
    }

    /**
    * @param $name
    * @param null $data
    * @param null $third
    * @return mixed
    */
    public function where($name, $data = null, $third = null)
    {
        if ($data === null && is_array($name)) {
            return $this->model->where($name);
        } else if ($third != null) {
            return $this->model->where($name, $data, $third);
        }
        return $this->model->where($name, $data);
    }

    /**
    * @param $data
    * @return mixed
    */
    public function with($data)
    {
        return $this->model->with($data);
    }

    /**
    * @return mixed
    */
    public function all()
    {
        return $this->model->all();
    }

    /**
    * @param $name
    * @param $data
    * @return mixed
    */
    public function whereIn($name, $data)
    {
        return $this->model->whereIn($name, $data);
    }

    /**
    * @param $id
    * @return mixed
    */
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    /**
    * @param $id
    * @return mixed
    */
    public function forceDelete($id)
    {
        return $this->model->find($id)->forceDelete();
    }

    /**
    * @param $finder
    * @param $data
    * @return mixed
    */
    public function updateOrCreate($finder, $data)
    {
        return $this->model->updateOrCreate($finder, $data);
    }

    /**
    * @param $data
    * @return mixed
    */
    public function firstOrCreate($needle, $data)
    {
        return $this->model->firstOrCreate($needle, $data);
    }

    public function firstOrCreateDesignation($needle)
    {
        return $this->model->firstOrCreate($needle);
    }

    /**
    * @param $name
    * @param string $ascending
    * @return mixed
    */
    public function orderBy($name, $ascending = 'ASC')
    {
        return $this->model->orderBy($name, $ascending);
    }

    /**
    * @param $property
    * @return mixed
    */
    public function pluck($property)
    {
        return $this->model->pluck($property);
    }
}
