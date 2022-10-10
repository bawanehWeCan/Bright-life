<?php

namespace App\Repositorys;

class AddressRepository extends AbstractRepository
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
        $model->name    = $data['name'];
        $model->region    = $data['region'];
        $model->street    = $data['street'];
        $model->building_number    = $data['building_number'];
        $model->floor    = $data['floor'];
        $model->apartment_number    = $data['apartment_number'];
        $model->additional_tips    = $data['additional_tips'];
        $model->phone_number    = $data['phone_number'];
        $model->user_id    = $data['user_id'];

        $model->save();

        return $model->fresh();

    }
}
