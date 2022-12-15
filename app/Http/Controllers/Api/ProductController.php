<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Repositorys\ProductRepository;
use App\Http\Controllers\ApiController;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Extra;
use App\Models\Group;
use App\Models\GroupItem;
use App\Repositorys\ExtraRepository;
use App\Models\Size;
use App\Repositories\Repository;
use App\Repositorys\SizeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends ApiController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->resource = ProductResource::class;
        $this->model = app( Product::class );
        $this->repositry =  new ProductRepository( $this->model ) ;
    }

    /**
     * @param ProductRequest $request
     * @return void
     */
    public function save( ProductRequest $request ){

        return $this->store( $request );
    }

    public function store( $data )
    {

        DB::beginTransaction();
        $data['name'] = ['en'=>$data['name_en'],'ar'=>$data['name_ar']];
        $data['content'] = ['en'=>$data['content_en'],'ar'=>$data['content_ar']];
        $data['type'] = ['en'=>$data['type_en'],'ar'=>$data['type_ar']];
        $product = $this->repositry->save( $data );

        $groupRepo      = new Repository( app( Group::class ) );
        $groupItemRepo  = new Repository( app( GroupItem::class ) );

        foreach ($data['groups'] as $group) {
            $group['product_id'] = $product->id;
            $group['name'] = ['en'=>$group['name_en'],'ar'=>$group['name_ar']];
            $group['type'] = ['en'=>$group['type_en'],'ar'=>$group['type_ar']];
            $model = $groupRepo->save( $group );

            // dd( $model );

            foreach ($group['items'] as $item) {
                $item['group_id'] = $model['id'];
                $item['name'] = ['en'=>$item['name_en'],'ar'=>$item['name_ar']];
                $groupItemRepo->save($item);
            }
        }
        DB::commit();

        if ($product) {
            return $this->returnData( 'data' , new $this->resource( $product ), __('Succesfully'));
        }else{
            DB::rollback();
            return $this->returnError(__('Sorry! Failed to create !'));
        }
    }

    public function pagination( $lenght = 10 )
    {

        $data =  $this->repositry->pagination( $lenght );

        return $this->returnData( 'data' , ProductResource::collection( $data ), __('Succesfully'));


    }

    public function lookfor(ProductRequest $request){

        return $this->search('name',$request->keyword);

    }

    public function image( $id, Request $request ){
        $product = Product::find($id);

        $product->image = $request->save;

        $product->save();

        return $this->returnData( 'data' , new $this->resource( $product ), __('Succesfully'));


    }

}
