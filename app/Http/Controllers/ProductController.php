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
     * Validation rules for Profile model
     * @var array<string,string[]> $valdationRules field => rules
     */
    protected $validationRules = [
        'name' => ['required', 'string', 'max:20'],
        'price' => ['required', 'int'],
        'amount' => ['required', 'int'],
        'image' => ['required', 'image'],
        'description' => ['string', 'max:500', 'nullable'],
        'characteristics' => ['string', 'max:500', 'nullable'],
        'photos' => 'required',
        'photos.*' => 'mimes:jpg,jpeg,png',
    ];

    /**
     * Updates product's data
     * @param Product $product
     * @throws \Exception
     */
    public function update(Product $product)
    {
        $this->authorize('update', $product);
        
        ini_set('memory_limit', '16M');

        $data = request()->validate($this->validationRules);

        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->amount = $data['amount'];
        $product->image = $this->storeProductImage(request('image'));
        $product->description = isset($data['description']) ? $data['description'] : null;
        $product->characteristics = isset($data['characteristics']) ? $data['characteristics'] : null;
        $product->save();

        if (isset(request()->photos)) {
            if (!$product->storePhotos(request()->photos)) {
                throw new \Exception("Product's photos not saved");
            }

            if (!$product->removeOldPhotos()) {
                throw new \Exception("Old product's photos not deleted");
            }
        }        

        return redirect('/profile/' . auth()->user()->id);
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
        $data = request()->validate($this->validationRules);

        ini_set('memory_limit', '16M');

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
