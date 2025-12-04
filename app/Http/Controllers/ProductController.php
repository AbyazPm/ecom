<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductImage;
use App\Models\Wishlist;

class ProductController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth')->except(['index', 'show', 'addToCart', 'removeFromCart', 'cart', 'checkoutForm', 'checkoutProcess']);
    }

    
    // Homepage / katalog
public function index(Request $request)
{
    $query = Product::query();

    // SEARCH nama / kategori
    if ($request->filled('q')) {
        $q = $request->q;
        $query->where(function($sub) use ($q) {
            $sub->where('nama_produk', 'like', "%{$q}%")
                ->orWhere('kategori', 'like', "%{$q}%");
        });
    }

    // FILTER kategori
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    // FILTER harga minimal
    if ($request->filled('min_harga')) {
        $query->where('harga', '>=', $request->min_harga);
    }

    // FILTER harga maksimal
    if ($request->filled('max_harga')) {
        $query->where('harga', '<=', $request->max_harga);
    }

    $products = $query->orderBy('created_at','desc')->paginate(8)->withQueryString();
    return view('products.index', compact('products'));
}



    public function create()
{
    return view('products.create');
}

public function store(Request $request)
{
    // validasi input
    $request->validate([
        'nama_produk' => 'required|string|max:150',
        'harga' => 'required|numeric|min:0',
        'kategori' => 'nullable|string|max:100',
        'stok' => 'required|integer|min:0',
        'deskripsi' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'foto_tambahan.*' => 'image|mimes:jpg,jpeg,png|max:2048', // ditambah
    ]);

    // upload foto utama jika ada
    $path = null;
    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('produk', 'public');
    }

    // simpan produk ke database dulu
    $product = \App\Models\Product::create([
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'kategori' => $request->kategori,
        'stok' => $request->stok,
        'deskripsi' => $request->deskripsi,
        'foto' => $path,
    ]);

    // upload gambar tambahan (setelah product dibuat)
    if ($request->hasFile('foto_tambahan')) {
        foreach ($request->file('foto_tambahan') as $img) {
            $pathImg = $img->store('produk', 'public');

            \App\Models\ProductImage::create([
                'product_id' => $product->id,  // sekarang variabel sudah ada
                'path_image' => $pathImg,
            ]);
        }
    }

    return redirect()->route('home')->with('success', 'Produk berhasil ditambahkan!');
}

// edit produk
public function edit($id)
{
    $product = Product::with('images')->findOrFail($id);
    return view('products.edit', compact('product'));
}



// update produk
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $product->update([
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'kategori' => $request->kategori,
        'deskripsi' => $request->deskripsi,
    ]);

    // 🔴 Hapus foto tambahan yang dicentang
    if ($request->has('delete_images')) {
        foreach ($request->delete_images as $img_id) {
            $img = ProductImage::find($img_id);

            if ($img) {
                // hapus file fisik
                if (file_exists(storage_path('app/public/'.$img->path_image))) {
                    unlink(storage_path('app/public/'.$img->path_image));
                }
                $img->delete();
            }
        }
    }

    // 🟢 Upload foto tambahan baru
    if ($request->hasFile('foto_tambahan')) {
        foreach ($request->file('foto_tambahan') as $file) {
            $path = $file->store('produk', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'path_image' => $path,
            ]);
        }
    }

    return redirect()->route('products.edit', $product->id)
                     ->with('success', 'Produk berhasil diperbarui!');
}



// hapus produk
public function destroy($id)
{
    $product = \App\Models\Product::findOrFail($id);

    // hapus gambar dari storage
    if ($product->foto && file_exists(storage_path('app/public/'.$product->foto))) {
        unlink(storage_path('app/public/'.$product->foto));
    }

    $product->delete();
    return redirect()->route('home')->with('success', 'Produk berhasil dihapus!');
}
// 🟩 DETAIL PRODUK
public function show($id)
{
    $product = \App\Models\Product::findOrFail($id);
    return view('products.show', compact('product'));
}

// 🟩 TAMPILKAN KERANJANG
public function cart()
{
    $cart = session()->get('cart', []);
    return view('products.cart', compact('cart'));
}

// 🟩 TAMBAHKAN KE KERANJANG
public function addToCart($id)
{
    $product = \App\Models\Product::findOrFail($id);
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            'nama_produk' => $product->nama_produk,
            'harga' => $product->harga,
            'foto' => $product->foto,
            'quantity' => 1,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}

// 🟩 HAPUS DARI KERANJANG
public function removeFromCart($id)
{
    $cart = session()->get('cart', []);
    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->route('cart.show')->with('success', 'Produk dihapus dari keranjang!');
}

// 🟩 Form checkout
public function checkoutForm()
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('home')->with('error', 'Keranjang masih kosong!');
    }

    $user = auth()->user();   // kirim data user

    return view('products.checkout', compact('cart', 'user'));
}


// 🟩 Proses checkout
public function checkoutProcess(Request $request)
{
    $request->validate([
        'alamat' => 'required|string|max:255',
        'no_hp' => 'required|string|max:20',
    ]);

    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('home')->with('error', 'Keranjang masih kosong!');
    }

    $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['quantity']);

    // Simpan ke tabel orders
    $order = Order::create([
        'user_id' => auth()->id(),
        'nama_pemesan' => auth()->user()->name,      // otomatis dari akun
        'email' => auth()->user()->email,            // otomatis dari akun
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp,
        'total_harga' => $total,
    ]);

    // Simpan item pesanan & kurangi stok
    foreach ($cart as $id => $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $id,
            'quantity' => $item['quantity'],
            'harga_satuan' => $item['harga'],
            'subtotal' => $item['harga'] * $item['quantity'],
        ]);

        // Kurangi stok produk
        \App\Models\Product::where('id', $id)
            ->decrement('stok', $item['quantity']);
    }

    // Kosongkan keranjang
    session()->forget('cart');

    return redirect()
        ->route('orders.list')
        ->with('success', 'Pesanan berhasil dibuat!');
}


// 🟩 Riwayat pesanan
public function orders()
{
    $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
    return view('products.orders', compact('orders'));
}


public function laporanPenjualan()
{
    $orders = \App\Models\Order::with('items.product')->latest()->get();

    return view('products.report', compact('orders'));
}

// 🟩 Dashboard Admin
public function dashboardAdmin()
{
    $totalProduk = \App\Models\Product::count();
    $totalPesanan = \App\Models\Order::count();
    $totalPendapatan = \App\Models\Order::sum('total_harga');

    $pesananTerbaru = \App\Models\Order::latest()->take(5)->get();

    return view('admin.dashboard', compact('totalProduk', 'totalPesanan', 'totalPendapatan', 'pesananTerbaru'));
}


public function addToWishlist($id)
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login dulu untuk menambahkan wishlist!');
    }

    Wishlist::firstOrCreate([
        'user_id' => auth()->id(),
        'product_id' => $id,
    ]);

    return back()->with('success', 'Produk ditambahkan ke wishlist!');
}

public function wishlist()
{
    $wishlist = Wishlist::where('user_id', auth()->id())->with('product')->get();
    return view('products.wishlist', compact('wishlist'));
}

public function removeWishlist($id)
{
    Wishlist::where('user_id', auth()->id())->where('product_id', $id)->delete();
    return back()->with('success', 'Produk dihapus dari wishlist!');
}

public function invoice($id)
{
    $order = Order::with('items.product')->where('user_id', auth()->id())->findOrFail($id);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('products.invoice', compact('order'))
            ->setPaper('A4', 'portrait');

    return $pdf->download('Invoice-'.$order->id.'.pdf');
}

public function adminOrders()
{
    $orders = Order::with('user')->latest()->paginate(10);
    return view('admin.orders', compact('orders'));
}

public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $order->update(['status' => $request->status]);

    return back()->with('success', 'Status pesanan berhasil diperbarui!');
}

}


