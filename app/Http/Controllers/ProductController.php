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
     */
    public function update(Product $product)
    {
        $this->authorize('update', $product);

        $data = request()->validate($this->validationRules);

        // TODO переделать сохранение фотографий:
        // 1) если не введены, сохраняются старые
        // 2) усли введены, старые удаляются

        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->amount = $data['amount'];
        $product->image = request('image')->store('uploads', 'public');
        $product->description = isset($data['description']) ? $data['description'] : null;
        $product->characteristics = isset($data['characteristics']) ? $data['characteristics'] : null;
        $product->save();

        if (!$this->storeProductPhotos($product, request()->photos)) {
            throw new \Exception("Product's photos not saved");
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

        $product = auth()->user()->products->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'amount' => $data['amount'],
            'description' => isset($data['description']) ? $data['description'] : null,
            'characteristics' => isset($data['characteristics']) ? $data['characteristics'] : null,
            'image' => request('image')->store('uploads', 'public'),
        ]);

        if (!$this->storeProductPhotos($product, request()->photos)) {
            throw new \Exception("Product's photos not saved");
        }

        return redirect('/profile/' . auth()->user()->id);
    }

    /**
     * Stores all product photos
     * @param Product $product
     * @param UploadedFile[] $photos
     * @return bool
     */
    public function storeProductPhotos(Product $product, $photos)
    {
        try {
            foreach($photos as $photo) {
                $photoPath = $photo->store('uploads', 'public');

                $product->productPhotos()->create([
                    'path' => $photoPath,
                ]);
            }
        } catch (\Exception) {
            return false;
        }
        
        return true;
    }    
}
