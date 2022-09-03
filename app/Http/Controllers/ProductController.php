<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\User;
use App\Repository\ProductRepository;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
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

        $data = request()->validate([ // TODO тоже request
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
            $this->productRepository->removeImageById($product->id);
            $imagePath = ImageHelper::storeProductImage(request('image'));
        }

        $product->name = $data['name'] ?? $product->name;
        $product->price = $data['price'] ?? $product->price;
        $product->amount = $data['amount'] ?? $product->amount;
        $product->image =  $imagePath;
        $product->description = $data['description'] ?? null;
        $product->characteristics = $data['characteristics'] ?? null;


        if (!$product->save()) {
            throw new \Exception("Product not saved");
        }

        if (request()->photos !== null) {
            $product->removePhotos();
            
            if (!$this->productRepository->storePhotosById($product->id, request()->photos)) {
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
        $products = $this->productRepository->getDescOrdered();
        return view('product.index', compact('products'));
    }

    /**
     * Stores new product into the DB
     * @throws \Exception
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
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        if (!$product->delete()) {
            throw new \Exception("Product not deleted");
        }

        return redirect('/profile/' . auth()->user()->id);    
    }
}
