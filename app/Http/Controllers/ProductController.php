<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\User;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // ! переделать, тк смотреть может любой, а создавать - нет
    }

    /**
     * Creates product
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Edits product's info
     * @param Product $product
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Shows product page
     * @param int $id
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Shows all products
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('product.index', compact('products'));
    }
    
    /**
     * Stores new product into the DB
     */
    public function store()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:20'],
            'price' => ['required', 'int'],
            'amount' => ['required', 'int'],
            'image' => ['required', 'image'],
            'description' => ['string', 'max:500'],
            'characteristics' => ['string', 'max:500'],
            'photos' => 'required',
            'photos.*' => 'mimes:jpg,jpeg,png'
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path('storage/' . $imagePath))->resize(230, 140);
        $image->save();

        $product = auth()->user()->products()->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'amount' => $data['amount'],
            'description' => isset($data['description']) ? $data['description'] : null,
            'characteristics' => isset($data['characteristics']) ? $data['characteristics'] : null,
            'image' => $imagePath,
        ]);

        foreach(request()->photos as $photo) {
            $photoPath = $photo->store('uploads', 'public');

            $product->productPhotos()->create([
                'path' => $photoPath,
            ]);
        }

        return redirect('/profile/' . auth()->user()->id);
    }

    
}
