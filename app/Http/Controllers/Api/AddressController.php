<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AddressResource;
use App\Repositorys\AddressRepository;
use App\Http\Controllers\ApiController;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\Extra;
use App\Repositorys\ExtraRepository;
use App\Models\Size;
use App\Repositorys\SizeRepository;

class AddressController extends ApiController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->resource = AddressResource::class;
        $this->model = app( Address::class );
        $this->repositry =  new AddressRepository( $this->model ) ;
    }

    /**
     * @param AddressRequest $request
     * @return void
     */
    public function save( AddressRequest $request ){
        return $this->store( $request );
    }

    public function store( $data )
    {
        $extraRepo  = new ExtraRepository( app(Extra::class) );
        $sizeRepo   = new SizeRepository( app(Size::class) );
        $model = $this->repositry->save( $data );

        foreach ($data['sizes'] as  $value) {
            $value['Address_id'] = $model->id;
            $extra = $extraRepo->save( $value );
        }

        foreach ($data['extras'] as  $value) {
            $value['Address_id'] = $model->id;
            $extra = $sizeRepo->save( $value );
        }




        if ($model) {
            return $this->returnData( 'data' , new $this->resource( $model ), __('Succesfully'));
        }

        return $this->returnError(__('Sorry! Failed to create !'));
    }



}
