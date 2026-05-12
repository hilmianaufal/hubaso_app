<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->get();
        $categories = \App\Models\Category::all();

        return view('customer.order', compact(
            'menus',
            'categories'
        ));
    }

    public function addToCart($id)
    {
 
        $menu = Menu::findOrFail($id);
       if ($menu->stok <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok menu habis',
                'cart' => session()->get('cart', []),
                'total' => 0
            ], 422);
        }
        $cart = session()->get('cart', []);


        $currentQty = isset($cart[$id]) ? $cart[$id]['qty'] : 0;

        if ($currentQty + 1 > $menu->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi',
                'cart' => $cart,
                'total' => collect($cart)->sum(fn($item) => $item['harga'] * $item['qty'])
            ], 422);
        }

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'nama'  => $menu->nama,
                'harga' => $menu->harga,
                'foto'  => $menu->foto,
                'qty'   => 1
            ];
        }

        session()->put('cart', $cart);

        return $this->cartResponse();
    }

    private function generateQueue()
    {
        $lastOrder = Order::latest()->first();

        if (!$lastOrder) {

            return 'A001';
        }

        $lastNumber = intval(
            substr(
                $lastOrder->queue_number,
                1
            )
        );

        $newNumber = $lastNumber + 1;

        return 'A' .
            str_pad(
                $newNumber,
                3,
                '0',
                STR_PAD_LEFT
            );
    }

    public function checkout(Request $request)
{
    $request->validate([
        'catatan' => 'nullable|string|max:500',
    ]);

    $cart = session('cart', []);

    if (empty($cart)) {
        return back()->withErrors([
            'cart' => 'Keranjang masih kosong'
        ]);
    }

    if (!session('jenis_pesanan')) {
        return redirect('/order')->withErrors([
            'jenis_pesanan' => 'Silakan pilih jenis pesanan terlebih dahulu'
        ]);
    }

    $total = 0;

    foreach ($cart as $id => $item) {
        $menu = Menu::find($id);

        if (!$menu) {
            return back()->withErrors([
                'stok' => 'Menu tidak ditemukan'
            ]);
        }

        if ($menu->stok < $item['qty']) {
            return back()->withErrors([
                'stok' => $menu->nama . ' stok tidak mencukupi. Stok tersisa: ' . $menu->stok
            ]);
        }

        $total += $item['harga'] * $item['qty'];
    }

    $order = Order::create([
        'restaurant_table_id' => null,
        'nomor_meja_manual' => session('nomor_meja'),
        'nama_customer' => session('nama_customer', 'Guest'),
        'jenis_pesanan'      => session('jenis_pesanan'),
        'total'              => $total,
        'status'             => 'pending',
        'payment_status'     => 'unpaid',
        'queue_number'       => $this->generateQueue(),
        'catatan' => $request->catatan,
    ]);

    foreach ($cart as $id => $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id'  => $id,
            'qty'      => $item['qty'],
            'harga'    => $item['harga'],
            'subtotal' => $item['harga'] * $item['qty'],
        ]);

        $menu = Menu::find($id);

        $menu->decrement('stok', $item['qty']);
    }

    session()->forget('cart');
    session()->forget('jenis_pesanan');
    session()->forget('nomor_meja');
    session()->forget('nama_customer');

    return redirect('/payment/' . $order->id);
}
    public function invoice(Order $order)
    {
        $order->load([
            'table',
            'items.menu'
        ]);

        return view('customer.invoice',
                    compact('order'));
    }

        public function payment(Order $order)
        {
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            if (!$order->snap_token) {
                $params = [
                    'transaction_details' => [
                        'order_id' => 'HUBASO-' . $order->id . '-' . time(),
                        'gross_amount' => (int) $order->total,
                    ],
                    'customer_details' => [
                        'first_name' => $order->nama_customer,
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);

                $order->update([
                    'snap_token' => $snapToken,
                ]);
            }

            return view('customer.payment', compact('order'));
        }

    public function confirmPayment(Order $order)
    {
        $order->update([
            'payment_status' => 'waiting_verification'
        ]);

        return redirect('/invoice/' . $order->id)
            ->with('success',
            'Pembayaran berhasil dikirim');
    }

    private function cartResponse()
    {
        $cart = session('cart', []);

        $total = 0;
        $count = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
            $count += $item['qty'];
        }

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total' => $total,
            'count' => $count,
        ]);
    }

    public function minusCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']--;

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);

        return $this->cartResponse();
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return $this->cartResponse();
    }

    public function updateCart(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (!isset($cart[$id])) {
        return response()->json([
            'success' => false,
            'cart' => $cart,
            'total' => 0
        ]);
    }

    if ($request->action == 'increase') {

        $cart[$id]['qty']++;

    } elseif ($request->action == 'decrease') {

        $cart[$id]['qty']--;

        if ($cart[$id]['qty'] <= 0) {
            unset($cart[$id]);
        }

    } elseif ($request->action == 'remove') {

        unset($cart[$id]);

    }

    session()->put('cart', $cart);

    $total = 0;

    foreach ($cart as $item) {
        $total += $item['harga'] * $item['qty'];
    }

    return response()->json([
        'success' => true,
        'cart' => $cart,
        'total' => $total
    ]);
}

public function startOrder()
{
    return view('customer.start-order');
}

public function saveOrderType(Request $request)
{
    $request->validate([
        'jenis_pesanan' => 'required|in:Makan Di Tempat,Bungkus',
        'nomor_meja' => 'required_if:jenis_pesanan,Makan Di Tempat|nullable|string|max:50',
    ]);

    session([
        'jenis_pesanan' => $request->jenis_pesanan,
        'nomor_meja' => $request->nomor_meja,
    ]);

    return redirect('/order/menu');
}


public function saveCustomerName(Request $request)
{
    $request->validate([
        'nama_customer' => 'required|string|max:255',
    ]);

    session([
        'nama_customer' => $request->nama_customer,
    ]);

    return redirect('/checkout');
}
public function checkoutPage()
{
    $cart = session('cart', []);

    if (empty($cart)) {

        return redirect('/order/menu')
            ->withErrors([
                'cart' => 'Keranjang masih kosong'
            ]);
    }

    $total = 0;

    foreach ($cart as $item) {

        $total += $item['harga'] * $item['qty'];
    }

    return view('customer.checkout', compact(
        'cart',
        'total'
    ));
}
}