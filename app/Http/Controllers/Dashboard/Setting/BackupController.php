<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $file = request('file') ?? '';
        if ($file) {
            if (Storage::exists($file)) {
                $stream = Storage::readStream($file);

                return response()->stream(function () use ($stream) {
                    fpassthru($stream);
                }, 200, [
                    "Content-Type" => Storage::getMimetype($file),
                    "Content-Length" => Storage::getSize($file),
                    "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
                ]);
            }
            abort(404);
        }
        $path = (string)preg_replace('/[^a-zA-Z0-9.]/', '-', config('backup.backup.name'));
        $files = Storage::files($path);
        $backups = [];
        foreach ($files as $k => $file) {
            if (substr($file, -4) == '.zip' && Storage::exists($file)) {
                $backups[] = [
                    'name' => $file,
                    'size' => $this->humanFileSize(Storage::size($file)),
                    'time' => date('Y-m-d g:i:s A', Storage::lastModified($file)),
                ];
            }
        }
        $backups = array_reverse($backups);

        return view('dashboard.setting.backups.index', compact('backups'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);
        $file = $request->file;
        if (Storage::exists($file)) {
            Storage::delete($file);
            session()->flash('success', __('dashboard.deleted_successfully'));
        }

        return to_route('dashboard.setting.backups.index');
    }

    public function create()
    {
        dispatch(function () {
            Artisan::call('backup:clean');
            Artisan::call('backup:run');
        });
        session()->flash('success', __('dashboard.backup_success'));

        return to_route('dashboard.setting.backups.index');
    }

    private function humanFileSize($size)
    {
        if ($size >= 1 << 30)
            return number_format($size / (1 << 30), 2) . 'GB';
        if ($size >= 1 << 20)
            return number_format($size / (1 << 20), 2) . 'MB';
        if ($size >= 1 << 10)
            return number_format($size / (1 << 10), 2) . 'KB';

        return number_format($size) . ' bytes';
    }
}
