<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentsRequest;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(CommentsRequest $request, Article $article)
    {
        $comment = $article->comments()->create(array_merge(
            $request->all(), ['user_id' => $request->user()->id]
        ));

        flash()->success('작성하신 댓글을 저장했습니다.');

        return redirect(route('articles.show', $article->id) . '#comment_'.$comment->id);
    }

    public function update(CommentsRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->all());

        return redirect(route('articles.show', $comment->commentable->id).'#comment_'.$comment->id);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        if($comment->replies->count() > 0) {
            $comment->delete();
        } else {
            $comment->forceDelete();
        }

        return response()->json($comment, 200);
    }
}
