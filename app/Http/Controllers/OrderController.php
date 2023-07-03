<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $products_list = [
            [
                'product_id' => $request->input('product_id'),
                'price' => $request->input('product_price'),
                'count' => '1'
            ]
        ];

        $products = urlencode(serialize($products_list));
        $sender = urlencode(serialize($_SERVER));

        $data = [
            'key' => getenv('CRM_SECRET_KEY'), // Your secret token
            'order_id' => number_format(round(microtime(true) * 10), 0, '.', ''),
            'country' => 'UA',
            'office' => '1',
            'products' => $products,
            'bayer_name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'payment' => '',
            'sender' => $sender,
            'utm_source' => session('utms.utm_source'),
            'utm_medium' => session('utms.utm_medium'),
            'utm_term' => session('utms.utm_term'),
            'utm_content' => session('utms.utm_content'),
            'utm_campaign' => session('utms.utm_campaign')
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://romandubil.lp-crm.biz/api/addNewOrder.html');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $out = curl_exec($curl);
        curl_close($curl);


        if ($out === false) {
            // cURL request failed
            return redirect()->back()->with('error', 'API request failed');
        } else {
            // Assuming the response is in JSON format
            $response = json_decode($out, true);

            // Check the status field in the response
            if (isset($response['status']) && $response['status'] === 'ok') {
                // API request was successful
                return redirect()->back()->with('success', $response['message']);
            } else {
                // API request returned an error
                return redirect()->back()->with('error', $response['message']);
            }
        }
    }
}
