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

        return $this->returnData('data', new CartResource($cart->getContent()));

    }
}
