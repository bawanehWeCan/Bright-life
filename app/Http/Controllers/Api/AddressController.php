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
use Illuminate\Support\Facades\Auth;

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

    public function user_address(){
        $address = Auth::user()->address;


        if ($address) {
            return $this->returnData('data', new $this->resource( $address ), __('Get  succesfully'));
        }

        return $this->returnError(__('Sorry! Failed to get !'));
    }

}
