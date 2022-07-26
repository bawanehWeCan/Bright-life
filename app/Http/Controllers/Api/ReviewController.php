<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReviewResource;
use App\Http\Controllers\ApiController;
use App\Models\User;

class ReviewController extends ApiController
{
    public function __construct()
    {
        $this->resource = ReviewResource::class;
        $this->model = app(Review::class);
        $this->repositry =  new Repository($this->model);
    }

    public function test(){
        return $this->list();
    }

    public function save(ReviewRequest $request ){
        $request['user_id'] = Auth::user()->id;
        $sup = User::find($request->supplier_id);
        $request['reviewable_id'] = $sup->id;
        $request['reviewable_type'] = get_class($sup);
        return $this->store( $request->all() );
    }

    public function edit($id,Request $request){
        $request['user_id'] = Auth::user()->id;
        return $this->update($id,$request->all());

    }


}
