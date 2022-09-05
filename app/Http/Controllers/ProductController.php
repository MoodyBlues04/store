<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\CustomResponse;
use App\Exceptions\InternalServerException;
use App\Exceptions\NotFoundModelException;
use App\Helpers\ImageHelper;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\User;
use App\Repository\ProductRepository;
use Illuminate\Http\Client\Request;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

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
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        return view('product.edit', compact('product'));
    }

    /**
     * Updates product's data
     * @throws \Exception
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $imagePath = $product->image;
        if ($request->getImage() !== null) {
            $this->productRepository->removeImageById($product->id);
            $imagePath = ImageHelper::storeProductImage($request->getImage());
        }

        $product->name = $request->name ?? $product->name;
        $product->price = $request->price ?? $product->price;
        $product->amount = $request->amount ?? $product->amount;
        $product->image =  $imagePath;
        $product->description = $request->description ?? null;
        $product->characteristics = $request->characteristics ?? null;


        if (!$this->productRepository->save($product)) {
            throw new NotFoundModelException(
                "Product not saved",
                Response::HTTP_NOT_FOUND,
                CustomResponse::NOT_FOUND_MODEL_ERROR
            );
        }

        if ($request->getPhotos() !== null) {
            $this->productRepository->removePhotosById($product->id);
            
            if (!$this->productRepository->storePhotosById($product->id, $request->getPhotos())) {
                throw new InternalServerException(
                    "Product's photos not saved",
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    CustomResponse::INTERNAL_SERVER_ERROR
                );
            }          
        }  

        return redirect('/profile/' . auth()->user()->id);
    }

    /**
     * Shows product page
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
        $products = $this->productRepository->getLatestPaginated();
        return view('product.index', compact('products'));
    }

    /**
     * Stores new product into the DB
     * @throws \Exception
     */
    public function store(ProductStoreRequest $request)
    {
        $product = auth()->user()->products()->create([
            'name' => $request->name,
            'price' => $request->price,
            'amount' => $request->amount,
            'description' => $request->description ?? null,
            'characteristics' => $request->characteristics ?? null,
            'image' => ImageHelper::storeProductImage($request->getImage())
        ]);

        if (!$this->productRepository->storePhotosById($product->id, $request->getPhotos())) {
            throw new InternalServerException(
                "Product's photos not saved",
                Response::HTTP_INTERNAL_SERVER_ERROR,
                CustomResponse::INTERNAL_SERVER_ERROR
            );
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
        
        if (!$this->productRepository->delete($product)) {
            throw new InternalServerException(
                "Product not deleted",
                Response::HTTP_INTERNAL_SERVER_ERROR,
                CustomResponse::INTERNAL_SERVER_ERROR
            );
        }

        return redirect('/profile/' . auth()->user()->id);    
    }
}
