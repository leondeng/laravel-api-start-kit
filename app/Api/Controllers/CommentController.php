<?php

namespace Api\Controllers;

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Comment;
use Api\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    public function show(User $user, Comment $comment)
    {
        return $comment;
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
