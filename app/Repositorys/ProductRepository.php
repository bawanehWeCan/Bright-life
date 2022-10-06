<?php

namespace App\Repositorys;

class ProductRepository extends AbstractRepository
{

    /**
     * @var Model
     */
    //protected $model = Restaurant::class;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * saveRestaurant function
     *
     * @param Array $data
     * @return void
     */
    public function save($data)
    {

        $model = new $this->model;
        $model->name        = $data['name'];
        $model->image       = $data['image'];
        $model->content     = $data['content'];
        $model->user_id     = $data['user_id'];
        $model->price       = $data['price'];
        $model->type        = $data['type'];
        $model->save();

        return $model->fresh();

    }
}
