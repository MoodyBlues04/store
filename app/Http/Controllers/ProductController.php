<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\User;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
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
        $this->authorize('update', $product);

        return view('product.edit', compact('product'));
    }

    /**
     * Updates product's data
     * @param Product $product
     * @throws \Exception
     */
    public function update(Product $product)
    {
        $this->authorize('update', $product);

        $data = request()->validate([
            'name' => ['nullable', 'string', 'max:20'],
            'price' => ['nullable', 'int'],
            'amount' => ['nullable', 'int'],
            'image' => ['nullable', 'image'],
            'description' => ['string', 'max:500', 'nullable'],
            'characteristics' => ['string', 'max:500', 'nullable'],
            'photos' => 'nullable',
            'photos.*' => 'mimes:jpg,jpeg,png',
        ]);

        $imagePath = $product->image;
        if (request('image') !== null) {
            $product->removeImage();
            $imagePath = $this->storeProductImage(request('image'));
        }

        $product->name = isset($data['name']) ? $data['name'] : $product->name;
        $product->price = isset($data['price']) ? $data['price'] : $product->price;
        $product->amount = isset($data['amount']) ? $data['amount'] : $product->amount;
        $product->image =  $imagePath;
        $product->description = isset($data['description']) ? $data['description'] : null;
        $product->characteristics = isset($data['characteristics']) ? $data['characteristics'] : null;
        $product->save();

        if (isset(request()->photos)) {
            $product->removePhotos();
            
            if (!$product->storePhotos(request()->photos)) {
                throw new \Exception("Product's photos not saved");
            }          
        }  

        return redirect('/profile/' . auth()->user()->id);
    }

    /**
     * Shows product page
     * @param Product $product
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
            'description' => ['string', 'max:500', 'nullable'],
            'characteristics' => ['string', 'max:500', 'nullable'],
            'photos' => 'required',
            'photos.*' => 'mimes:jpg,jpeg,png',
        ]);

        $product = auth()->user()->products()->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'amount' => $data['amount'],
            'description' => isset($data['description']) ? $data['description'] : null,
            'characteristics' => isset($data['characteristics']) ? $data['characteristics'] : null,
            'image' => $this->storeProductImage(request('image'))
        ]);

        if (!$product->storePhotos(request()->photos)) {
            throw new \Exception("Product's photos not saved");
        }

        return redirect('/profile/' . auth()->user()->id);
    }

    /**
     * Deletes product
     * @param Product $product
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->removeImage();
        $product->removePhotos();
        $product->delete();

        return redirect('/profile/' . auth()->user()->id);    
    }

    /**
     * Stores and resize an image
     * @param UploadedFile $image
     * @return string
     */
    public function storeProductImage($image)
    {
        $imagePath = $image->store('product_images', 'public');
        $img = Image::make(public_path("storage/{$imagePath}"))->resize(610, 350);
        $img->save();

        return $imagePath;
    }
}
