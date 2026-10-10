<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Get all books
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $search  = $request->get('search');
        $genre   = $request->get('genre');
        $status  = $request->get('status');

        $query = Book::select(
            'id',
            'title',
            'author',
            'genre',
            'year',
            'description',
            'status',
            'content',
            'image_path'
        );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($genre) {
            $query->where('genre', $genre);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $books = $query->paginate($perPage);

        // 🔥 UBAH image_path → URL LENGKAP
        $books->getCollection()->transform(function ($book) {
            $book->image_path = $book->image_path
                ? asset('storage/' . $book->image_path)
                : '';
            return $book;
        });

        return ResponseHelper::success($books, 'Books retrieved successfully');
    }

    /**
     * Get book by ID
     */
    public function show($id)
    {
        $book = Book::select(
            'id',
            'title',
            'author',
            'genre',
            'year',
            'description',
            'status',
            'content',
            'image_path'
        )->findOrFail($id);

        return ResponseHelper::success([
            'id'          => $book->id,
            'title'       => $book->title,
            'author'      => $book->author,
            'genre'       => $book->genre,
            'year'        => $book->year,
            'description' => $book->description,
            'status'      => $book->status,
            'content'     => $book->content,
            // 🔥 URL LENGKAP
            'image_path'  => $book->image_path
                ? asset('storage/' . $book->image_path)
                : '',
        ], 'Book retrieved successfully');
    }

    /**
     * Store book
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'genre'       => 'required|string|max:100',
            'year'        => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'description' => 'required|string',
            'status'      => 'required|in:available,unavailable',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->only([
            'title',
            'author',
            'genre',
            'year',
            'description',
            'status',
            'content'
        ]);

        if ($request->hasFile('image')) {
            // 🔥 SIMPAN PATH SAJA
            $data['image_path'] = $request
                ->file('image')
                ->store('covers', 'public');
        }

        $book = Book::create($data);

        // 🔥 RESPONSE URL LENGKAP
        $book->image_path = $book->image_path
            ? asset('storage/' . $book->image_path)
            : '';

        return ResponseHelper::success($book, 'Book created successfully', 201);
    }

    /**
     * Update book
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|string|max:255',
            'author'      => 'sometimes|string|max:255',
            'genre'       => 'sometimes|string|max:100',
            'year'        => 'sometimes|integer|min:1000|max:' . (date('Y') + 1),
            'description' => 'sometimes|string',
            'status'      => 'sometimes|in:available,unavailable',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->only([
            'title',
            'author',
            'genre',
            'year',
            'description',
            'status',
            'content'
        ]);

        if ($request->hasFile('image')) {

            if ($book->image_path && Storage::disk('public')->exists($book->image_path)) {
                Storage::disk('public')->delete($book->image_path);
            }

            $data['image_path'] = $request
                ->file('image')
                ->store('covers', 'public');
        }

        $book->update($data);

        $book->image_path = $book->image_path
            ? asset('storage/' . $book->image_path)
            : '';

        return ResponseHelper::success($book, 'Book updated successfully');
    }

    /**
     * Delete book
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->image_path && Storage::disk('public')->exists($book->image_path)) {
            Storage::disk('public')->delete($book->image_path);
        }

        $book->delete();

        return ResponseHelper::success(null, 'Book deleted successfully');
    }
}
