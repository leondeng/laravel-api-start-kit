<?php

namespace Api\Controllers;

use App\Models\User;
use App\Models\Comment;
use Api\Requests\UpdateCommentRequest;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function show(User $user, Comment $comment, CommentService $commentService)
    {
        // return $comment;
        return $commentService->find($comment->id);
    }

    public function update(UpdateCommentRequest $request, User $user, Comment $comment)
    {
        $comment->update($request->validated());

        return $comment;
    }

    public function index(User $user)
    {
        return $user->comments;
    }

    public function destroy(User $user, Comment $comment)
    {
        $comment->delete();

        return response(NULL, 204);
    }
}
