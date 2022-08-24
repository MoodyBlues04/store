<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Creates product
     */
    public function create()
    {
        return view('product.create');
    }
}
