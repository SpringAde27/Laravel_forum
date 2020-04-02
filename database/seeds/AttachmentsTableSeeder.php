<?php

use Illuminate\Database\Seeder;

class AttachmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! app()->environment(['production'])) {
          // 운영 환경이 아닐 때만 개발용 시딩을 실행한다.
          $this->seedForDev();
        }
    }

    protected function seedForDev()
    {
        App\Attachment::truncate();

        $faker = app(Faker\Generator::class);
        $users = App\User::all();
        $articles = App\Article::all();
        $tags = App\Tag::all();

        if (! File::isDirectory(attachments_path())) {
            File::makeDirectory(attachments_path(), 775, true);
        }

        File::cleanDirectory(attachments_path());

        // public/files/.gitignore 파일이 있어야 커밋할 때 빈 디렉터리를 유지할 수 있다.
        File::put(attachments_path('.gitignore'), "*\n!.gitignore");

        $this->command->error(
            'Downloading ' . $articles->count() . ' images from lorempixel. It takes time...'
        );

        $articles->each(function ($article) use ($faker) {
            $path = $faker->image(attachments_path());
            $filename = File::basename($path);
            $bytes = File::size($path);
            $mime = File::mimeType($path);

            $this->command->warn("File saved: {$filename}");

            $article->attachments()->save(
                factory(App\Attachment::class)->make(compact('filename', 'bytes', 'mime'))
            );
        });

        // 테스트용 고아 첨부파일을 만든다.
        foreach(range(1, 10) as $index) {
            $path = $faker->image(attachments_path());
            $filename = File::basename($path);
            $bytes = File::size($path);
            $mime = File::mimeType($path);
            $this->command->warn("File saved: {$filename}");

            factory(App\Attachment::class)->create([
                'filename' => $filename,
                'bytes' => $bytes,
                'mime' => $mime,
                'created_at' => $faker->dateTimeBetween('-1 months'),
            ]);
        }

        $this->command->info('Seeded: attachments table and files');
    }
}
