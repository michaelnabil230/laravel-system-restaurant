<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'BackupDatabase';
    protected $process;
    protected $fileBackup;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->fileBackup = storage_path('app/backup/' . date('Y-m-d-H-i-s') . '.sql');

        $this->process = Process::fromShellCommandline(sprintf(
            'C:\xampp\mysql\bin\mysqldump --host="%s" --user="%s" --password="%s" %s > %s',
            env('DB_HOST'),
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE'),
            $this->fileBackup
        ));

    }
    // C:\xampp\mysql\bin\mysqldump

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->process->mustRun();
            $this->line(json_encode(__('site.backup_success')));
            return;
        } catch (\Exception $exception) {
            if (file_exists($this->fileBackup)) {
                unlink($this->fileBackup);
            }
            $this->line(json_encode(__('site.backup_failed')));
            return;
        }
    }
}
