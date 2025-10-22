<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RefreshGuestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guest:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'すべてのデータをリセットして最新の日付でダミーデータを再作成します';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('データベースのリセットを開始します...');

        try {
            $this->info('すべてのデータを削除しています...');

            // 外部キー制約を一時的に無効化
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // すべてのテーブルのデータを削除（truncateは暗黙的にコミットするためトランザクション不要）
            Task::truncate();
            Project::truncate();
            DB::table('team_user')->truncate();
            Team::truncate();
            User::truncate();

            // 外部キー制約を再度有効化
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->info('新しいダミーデータを作成しています...');

            // シーダーを実行
            $this->call('db:seed');

            $this->info('すべてのデータがリセットされました！');
            $this->info('ゲストユーザーでログイン可能です:');
            $this->info('  Email: guest@example.com');
            $this->info('  Password: guestpass0406');

            return 0;
        } catch (\Exception $e) {
            // エラー時は外部キー制約を再度有効化
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->error('エラーが発生しました: ' . $e->getMessage());
            $this->error('スタックトレース: ' . $e->getTraceAsString());
            return 1;
        }
    }
}
