<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TopicController extends Controller
{
    /**
     * Get all topics with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $genreId = $request->get('genre_id');

        $query = Topic::with(['user', 'genre', 'comments']);

        if ($genreId) {
            $query->where('genre_id', $genreId);
        }

        $topics = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return ResponseHelper::success($topics, 'Topics retrieved successfully');
    }

    /**
     * Get topic by ID
     */
    public function show($id)
    {
        $topic = Topic::with(['user', 'genre', 'comments.user'])
                     ->findOrFail($id);

        return ResponseHelper::success($topic, 'Topic retrieved successfully');
    }

    /**
     * Create new topic
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'genre_id' => 'required|exists:genres,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $data = [
            'genre_id' => $request->genre_id,
            'user_id' => $request->user()->id,
            'judul' => $request->judul,
            'isi' => $request->isi,
        ];

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('topics/images', 'public');
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('topics/files', 'public');
        }

        $topic = Topic::create($data);
        $topic->load(['user', 'genre']);

        return ResponseHelper::success($topic, 'Topic created successfully', 201);
    }

    /**
     * Update topic
     */
    public function update(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);

        // Check if user is owner or admin
        if ($topic->user_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return ResponseHelper::error('Unauthorized', 403);
        }

        $validator = Validator::make($request->all(), [
            'genre_id' => 'sometimes|exists:genres,id',
            'judul' => 'sometimes|string|max:255',
            'isi' => 'sometimes|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->only(['genre_id', 'judul', 'isi']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            if ($topic->gambar) {
                Storage::disk('public')->delete($topic->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('topics/images', 'public');
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            if ($topic->file) {
                Storage::disk('public')->delete($topic->file);
            }
            $data['file'] = $request->file('file')->store('topics/files', 'public');
        }

        $topic->update($data);
        $topic->load(['user', 'genre']);

        return ResponseHelper::success($topic, 'Topic updated successfully');
    }

    /**
     * Delete topic
     */
    public function destroy(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);

        // Check if user is owner or admin
        if ($topic->user_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return ResponseHelper::error('Unauthorized', 403);
        }

        // Delete files
        if ($topic->gambar) {
            Storage::disk('public')->delete($topic->gambar);
        }
        if ($topic->file) {
            Storage::disk('public')->delete($topic->file);
        }

        $topic->delete();

        return ResponseHelper::success(null, 'Topic deleted successfully');
    }
}
