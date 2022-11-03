<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SupplierResource;
use App\Traits\ResponseTrait;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\ProductItem;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ResponseTrait;
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = new Order();
            $order->user_id = $request->user_id;
            $order->supplier_id = $request->supplier_id;
            $order->note = !empty($request->note) ? $request->note : '';
            $order->type = $request->type;
            $order->total = $request->total;
            $order->status = 'Pending';
            $order->payment_method = $request->payment_method;
            $order->tax = $request->tax;
            $order->delivery_fee = $request->delivery_fee;
            $order->discount = $request->discount;
            $order->percentage = $request->percentage;
            $order->order_value = (double)(($request->total + $request->tax + $request->delivery_fee  + $request->percentage) - $request->discount);

            $order->save();

            foreach ($request->products as $product) {

                $cart_item = new CartItem();
                $cart_item->product_id = $product['product_id'];
                $cart_item->order_id = $order->id;
                $cart_item->quantity = $product['quantity'];
                $cart_item->size_id = $product['size_id'];
                $cart_item->note = !empty($product['note']) ? $product['note'] : '';
                $cart_item->price = $product['price'];
                $cart_item->save();

                foreach ($product['extras'] as $extra) {
                    $product_item = new ProductItem();
                    $product_item->cart_item_id = $cart_item->id;
                    $product_item->extra_id = $extra['extra_id'];
                    $product_item->save();
                }
            }
            DB::commit();
        } catch (Exception $e) {
            //throw $th;

            DB::rollBack();

            dd($e);
        }

        return $this->returnData('data', new OrderResource($order), '');
    }

    public function update(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->lat = $request->lat;
        $order->long = $request->long;
        $order->save();

        // $stuRef = app('firebase.firestore')->database()->collection('orders')->newDocument();
        // $stuRef->set([
        //     'user_id' => $order->user_id,
        //     'restaurant_id' => $order->restaurant_id,
        //     'restaurant_name' => $order->restaurant->name,
        //     'status' => $order->status,
        //     'note' => $order->note,
        //     'lat' => $order->lat,
        //     'long' => $order->long,
        //     'total' => $order->total,
        //     'driver_id' => 0,
        //     'res_lat' => $order->restaurant->lat,
        //     'res_long' => $order->restaurant->lng,
        //     'res_zone' => $order->restaurant->zone,
        //     'created_at' => $order->created_at,
        //     'position' => array( 'geohas'=>'alaa','geopoint' => array( 'aaa','aaa' ) ),
        // ]);

        return $this->returnData('data', new OrderResource($order), '');
    }

    public function myOrders(){
        $orders = Auth::user()->orders;

        // dd($orders);

        return $this->returnData('data',  OrderResource::collection($orders), '');
    }

    public function myProducts(){
        $products = Auth::user()->products;

        return $this->returnData('data',  ProductResource::collection($products), '');

    }

    public function search( Request $request ){

        $users = User::where('name', 'like', '%' . $request->input('number') . '%' )->where('type','suppliers')->get();

        // dd( $users );

        if($users){

            return $this->returnData( 'data' , SupplierResource::collection( $users ), __('Succesfully'));
        }


    }

    public function view(Order $order)
    {
        return $this->returnData("Order",new OrderResource($order));
    }
    public function orderSearch(Request $request)
    {
        if ($request->has('id')) {
            $order = Order::where('id',$request->id)->first();
            if($order){
                return $this->returnData('data', new OrderResource($order), '');
            }
            return $this->returnError('Sorry! No Available data');

        }elseif ($request->has('number')) {
            $order = Order::where('number','like', '%' . $request->number . '%' )->paginate(10);
            if(!$order){
                return $this->returnError('Sorry! No Available data');
            }
            return $this->returnData('data', OrderResource::collection($order), '');
        }
    }

    public function list(){
        $orders = Order::paginate(10);
        return $this->returnData("data",OrderResource::collection($orders));
    }
}
