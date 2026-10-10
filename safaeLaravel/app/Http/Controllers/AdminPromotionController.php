<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class AdminPromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->get();

        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')
                ->store('promotions', 'public');
        }

        Promotion::create([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'content' => $request->content,
            'event_date' => $request->event_date,
            'image' => $image
        ]);

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promosi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);

        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        if ($request->hasFile('image')) {
            $promotion->image = $request->file('image')
                ->store('promotions', 'public');
        }

        $promotion->title = $request->title;
        $promotion->short_description = $request->short_description;
        $promotion->content = $request->content;
        $promotion->event_date = $request->event_date;
        $promotion->save();

        return redirect()
            ->route('admin.promotions.index');
    }

    public function destroy($id)
    {
        Promotion::destroy($id);

        return back();
    }

    public function show($id)
    {
        $promotion = Promotion::findOrFail($id);

        return view('promotions.show', compact('promotion'));
    }
}