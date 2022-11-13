<?php

namespace App\Http\Controllers\Api;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Repositories\Repository;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\WalletResource;
use App\Http\Controllers\ApiController;

class WalletController extends ApiController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->resource = WalletResource::class;
        $this->model = app(Wallet::class);
        $this->repositry =  new Repository($this->model);
    }

    public function save( WalletRequest $request ){
        if(Auth::user()->wallet()->count() > 0){
            return $this->returnError('Sorry! Failed to create wallet, You have one already!');
        }
        return $this->store( $request->all() );

    }


       /**
     * profile function
     *
     * @param [type] $id
     * @return void
     */
    public function view($id)
    {
        $model = $this->repositry->getByID($id);

        if (!$model) {
            $data['name'] = 'Wallet';
            $data['total'] = 0;
            $data['user_id'] = Auth::user()->id;
            return $this->store( $data );
        }
        return $this->returnData('data', new $this->resource( $model ), __('Get  succesfully'));

        return $this->returnError(__('Sorry! Failed to get !'));
    }

}
