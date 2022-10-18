<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Auth;

class CartController extends Controller
{
    use ResponseTrait;
    public function getCart(){

        $cart = \Cart::session(Auth::user()->id);

        // dd($cart->getContent());

        return $this->returnData('data', CartResource::collection($cart->getContent()));

    }

    public function add(Request $request){
        // dd($request->product_id);

        $Product = Product::find($request->product_id); // assuming you have a Product model with id, name, description & price
        $rowId = $Product->id + 2 . Auth::user()->id; // generate a unique() row ID

        // add the product to cart
        \Cart::session(Auth::user()->id)->add(array(
            'id' => $rowId,
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'size_id'=>$request->size_id,
                'extras'=>$request->extras,
                'note'=>$request->note,
            ),
            'associatedModel' => $Product
        ));



        $cart = \Cart::session(Auth::user()->id);

        // dd($cart->getContent());

        return $this->returnData('data', CartResource::collection($cart->getContent()));
    }
}
