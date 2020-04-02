<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticlesRequest;
use Illuminate\Auth\Middleware\Authenticate;

class ArticlesController extends Controller implements Cacheable
{
    /**
     * ArticlesController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Specify the tags for caching.
     *
     * @return string
     */
    public function cacheTags()
    {
        return 'articles';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug = null)
    {
        $cacheKey = cache_key('articles.index');
        
        $query = $slug ? \App\Tag::whereSlug($slug)->firstOrFail()->articles() : new \App\Article;

        // 정렬
        $query = $query->orderBy(
            $request->input('sort', 'created_at'),
            $request->input('order', 'desc'),
        );

        // 검색
        if ($keyword = request()->input('search')) {
            $raw = 'MATCH(title, content) AGAINST(? IN BOOLEAN MODE)';
            $query = $query->whereRaw($raw, [$keyword]);
        }
      
        // 즉시 로드 (N+1쿼리 문제 해결_with(): 인자로 받은 관계를 미리 로드)
        // $articles = \App\Article::with('user')->get();

        // 지연 로드 (나중에 필요시 관계 로드)
        // $articles->load('user');

        // $articles = $query->latest()->paginate(3);

        $articles = $this->cache($cacheKey, 5, $query, 'paginate', 3);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      /**
       * Null Object pattern
       * 작성 폼과 수정 폼이 공유하면서
       * old()메서드의 두번 째 인자로 인한 널 포인트 오류
       * 더미 null article객체를 바인딩해서 오류를 피하자.
       */
        $article = new \App\Article;

        return view('articles.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticlesRequest $request)
    {
        $payload = array_merge($request->all(), [
            'notification' => $request->has('notification'),
        ]);
      
        $article = $request->user()->articles()->create($payload);
        // $article = $request->user()->articles()->create($request->all());

        if(!$article) {
            flash('글이 저장되지 않았습니다.')->error();
            return back()->withInput();
        }

        $article->tags()->sync($request->input('tags'));

        // if ($request->has('attachments')) {
        //     $attachments = \App\Attachment::whereIn('id', $request->input('attachments'))->get();
        //     $attachments->each(function($attachment) use($article) {
        //         $attachment->article()->associate($article);
        //         $attachment->save();
        //     });
        // }

        // 첨부파일 연결
        $request->getAttachments()->each(function ($attachment) use ($article) {
            $attachment->article()->associate($article);
            $attachment->save();
        });

        event(new \App\Events\ArticlesEvent($article));
        event(new \App\Events\ModelChanged(['articles']));

        flash('작성하신 글이 저장되었습니다.')->success();

        // return redirect(route('articles.index'));
        return redirect(route('articles.show', $article->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * Implicit route model binding
     * @param \App\Article $article
     */
    public function show(\App\Article $article)
    {
        // $article = \App\Article::findOrFail($id);
        $article->view_count += 1;
        $article->save();

        $comments = $article->comments()
                            ->with('replies')
                            ->withTrashed()
                            ->whereNull('parent_id')
                            ->latest()
                            ->get();
        
        return view('articles.show', compact('article', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * Implicit route model binding
     * @param \App\Article $article
     */
    public function edit(\App\Article $article)
    {
        $this->authorize('update', $article);

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * Implicit route model binding
     * @param \App\Article $article
     * 폼 리퀘스트, 명시적 라우트 모델 바인딩, 대량할당, 플래시 컴포넌트
     */
    public function update(ArticlesRequest $request, \App\Article $article)
    {
        $this->authorize('update', $article);

        $payload = array_merge($request->all(), [
            'notification' => $request->has('notification'),
        ]);

        $article->update($payload);

        $article->tags()->sync($request->input('tags'));

        event(new \App\Events\ModelChanged(['articles']));

        flash()->success('수정하신 내용을 저장했습니다.');

        return redirect()->route('articles.show', $article->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * Implicit route model binding
     * @param \App\Article $article
     */
    public function destroy(\App\Article $article)
    {
        $this->authorize('delete', $article);
        
        $article->delete();

        foreach($article->attachments as $attachment) {
            \File::delete(attachments_path($attachment->name));
            $attachment->delete();
        }

        foreach($article->comments as $comment) {
            $comment->forceDelete();
        }

        event(new \App\Events\ModelChanged(['articles']));

        flash()->success('게시글을 삭제하였습니다.');

        return response()->json([], 204);
    }    
}
