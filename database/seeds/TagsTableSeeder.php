<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* 태그 */
        App\Tag::truncate();
        DB::table('article_tag')->truncate();

        $tags = config('project.tags');

        foreach(array_transpose($tags) as $slug => $names) {
            App\Tag::create([
                'name' => $names['ko'],
                'ko' => $names['ko'],
                'en' => $names['en'],
                'slug' => Str::slug($slug)
            ]);
        }

        // foreach($tags as $slug => $name) {
        //     App\Tag::create([
        //         'name' => $name,
        //         'slug' => Str::slug($slug)
        //     ]);
        // }

      /**
       * 별도의 seeder class로 추출하고 마스터시더에서 call()할 때는 
       * command구문없이도 콘솔에 결과가 출력된다.
       */
        // $this->command->info('Seeded : tags table');

        /* 변수 선언 */
        $faker = app(Faker\Generator::class);
        $users = App\User::all();
        $articles = App\Article::all();
        $tags = App\Tag::all();

        /* 아티클과 태그 연결 */
        foreach($articles as $article) {
            $article->tags()->sync(
                $faker->randomElements($tags->pluck('id')->toArray(), rand(1, 3))
            );
        }

        // $this->command->info('Seed : article_tag table');
    }
}
