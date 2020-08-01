<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\General\CollectionHelper;
use App\Http\Controllers\Controller;
use Artisan;
use DB;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super_admin');
    }//end of constructor

    public function index()
    {
        $download = request('download') ?? '';
        if ($download) {
            $backup = storage_path('app/backup/' . $download);
            if (file_exists($backup)) {
                $headers = array(
                    'Content-Type' => 'application/octet-stream',
                );
                return response()->download($backup, '', $headers);
            }
        }

        $backups = collect(glob(storage_path('app/backup/') . "*.sql"))->map(function ($backup) {
            $arr = explode('/', $backup);
            return [
                'name' => end($arr),
                'path' => $backup,
                'size' => number_format(filesize($backup) / 1048576, 2) . 'MB',
                'time' => date('Y-m-d g:i:s A', filemtime($backup)),
            ];
        });

        $backups = CollectionHelper::paginate($backups);

        return view('dashboard.backups.index', compact('backups'));

    }

    public function process()
    {
        $file = request('file');
        $action = request('action');
        $pathFull = storage_path('app/backup/' . $file);
        if ($action === 'remove') {
            unlink($pathFull);
            $msg = __('site.deleted_successfully');
        } else {
            DB::unprepared(file_get_contents($pathFull));
            $msg = __('site.restore_success');
        }
        session()->flash('success', $msg);
        return redirect()->route('dashboard.backups.index');
    }

    public function create()
    {
        $return = Artisan::call('BackupDatabase');
        $output = Artisan::output();
        session()->flash('success', json_decode($output));
        return redirect()->route('dashboard.backups.index');
    }
}
