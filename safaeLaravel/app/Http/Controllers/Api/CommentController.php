<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Comments;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Get all comments for a topic
     */
    public function index(Request $request)
    {
        $topicId = $request->get('topic_id');

        $query = Comments::with(['user', 'topic']);

        if ($topicId) {
            $query->where('topic_id', $topicId);
        }

        $comments = $query->orderBy('created_at', 'desc')->get();

        return ResponseHelper::success($comments, 'Comments retrieved successfully');
    }

    /**
     * Get comment by ID
     */
    public function show($id)
    {
        $comment = Comments::with(['user', 'topic'])->findOrFail($id);

        return ResponseHelper::success($comment, 'Comment retrieved successfully');
    }

    /**
     * Create new comment
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|exists:topics,id',
            'isi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $comment = Comments::create([
            'topic_id' => $request->topic_id,
            'user_id' => $request->user()->id,
            'isi' => $request->isi,
        ]);

        $comment->load(['user', 'topic']);

        return ResponseHelper::success($comment, 'Comment created successfully', 201);
    }

    /**
     * Update comment
     */
    public function update(Request $request, $id)
    {
        $comment = Comments::findOrFail($id);

        // Check if user is owner
        if ($comment->user_id !== $request->user()->id) {
            return ResponseHelper::error('Unauthorized', 403);
        }

        $validator = Validator::make($request->all(), [
            'isi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 422, $validator->errors());
        }

        $comment->update(['isi' => $request->isi]);
        $comment->load(['user', 'topic']);

        return ResponseHelper::success($comment, 'Comment updated successfully');
    }

    /**
     * Delete comment
     */
    public function destroy(Request $request, $id)
    {
        $comment = Comments::findOrFail($id);

        // Check if user is owner or admin
        if ($comment->user_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return ResponseHelper::error('Unauthorized', 403);
        }

        $comment->delete();

        return ResponseHelper::success(null, 'Comment deleted successfully');
    }
}
