<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Creates product
     */
    public function create()
    {
        return view('product.create');
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
            'description' => ['required', 'string', 'max:500'],
            'characteristics' => ['required', 'string', 'max:500'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path('storage/' . $imagePath))->resize(230, 140);
        $image->save();

        auth()->user()->products()->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'characteristics' => $data['characteristics'],
            'image' => $imagePath,
        ]);

        return redirect('/profile/' . auth()->user()->id);
    }

    /**
     * Shows product page
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }
}
