<?php

namespace App\Http\Controllers;

use App\Services\CrmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_price = $request->input('$product_price');
        $name = $request->input('name');
        $phone = $request->input('phone');
        return CrmService::createOrder($product_id, $product_price, $name, $phone);
    }
}
