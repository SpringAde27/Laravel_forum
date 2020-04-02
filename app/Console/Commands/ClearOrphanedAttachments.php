<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearOrphanedAttachments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:coa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '고아가 된 첨부파일을 주기적으로 삭제합니다.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orphaned = \App\Attachment::whereNull('article_id')
                    ->where( 'created_at', '<', \Carbon\Carbon::now()->subWeek() )->get();

        // 프로그레스 바를 표시하기 위한 장식
        $bar = $this->output->createProgressBar(count($orphaned));

        foreach ($orphaned as $attachment) {
            $path = attachments_path($attachment->filename);
            \File::delete($path);
            $attachment->delete();
            $bar->advance();
            $this->line('삭제완료 >> '.$path);
        }

        $this->info('고아가 된 첨부 파일을 모두 삭제했습니다.');

        return;
    }
}
