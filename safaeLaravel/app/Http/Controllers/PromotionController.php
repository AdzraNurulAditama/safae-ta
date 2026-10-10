<?php

namespace App\Http\Controllers;

use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->get();

        return view('promotions.index', compact('promotions'));
    }

    public function show($id)
    {
        $promotion = Promotion::findOrFail($id);

        return view('promotions.show', compact('promotion'));
    }
}