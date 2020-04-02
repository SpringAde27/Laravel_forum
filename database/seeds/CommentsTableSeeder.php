<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 변수 선언
        $faker = app(Faker\Generator::class);
        $articles = App\Article::all();

        // 최상위 댓글
        $articles->each(function ($article) {
            $article->comments()->save(factory(App\Comment::class)->make());
            $article->comments()->save(factory(App\Comment::class)->make());
        });

        // 자식 댓글 (댓글의 댓글)
        $articles->each(function ($article) use ($faker){
            $commentIds = App\Comment::pluck('id')->toArray();

            foreach(range(1,5) as $index) {
                $article->comments()->save(
                    factory(App\Comment::class)->make([
                        'parent_id' => $faker->randomElement($commentIds),
                    ])
                );
            }
        });

        // up & down 투표
        $comments = App\Comment::all();

        $comments->each(function ($comment) {
            $comment->votes()->save(factory(App\Vote::class)->make());
            $comment->votes()->save(factory(App\Vote::class)->make());
            $comment->votes()->save(factory(App\Vote::class)->make());
        });
    }
}
