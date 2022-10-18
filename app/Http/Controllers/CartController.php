<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ResponseTrait;
    public function getCart(){

        $cart = Cart::session(Auth::user()->id);

        // dd($cart->getContent());

        return $this->returnData('data', $cart->getContent());

    }
}
