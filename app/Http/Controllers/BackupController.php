<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Storage::files('backups');
        return view('admin.backup.index', compact('backups'));
    }

    public function download($filename)
    {
        $filePath = storage_path("app/backups/{$filename}");
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->back()->with('error', 'El respaldo no existe.');
    }
    public function createBackup()
    {
        try {
            $date = now()->format('Y-m-d_H-i-s');
            $backupPath = storage_path("app/backups/backup-{$date}.sql");
    
            $databaseHost = env('DB_HOST');
            $databaseName = env('DB_DATABASE');
            $databaseUser = env('DB_USERNAME');
            $databasePassword = env('DB_PASSWORD');
    
            $command = sprintf(
                'mysqldump -h %s -u %s -p%s %s > %s',
                escapeshellarg($databaseHost),
                escapeshellarg($databaseUser),
                escapeshellarg($databasePassword),
                escapeshellarg($databaseName),
                escapeshellarg($backupPath)
            );
    
            exec($command, $output, $result);
    
            // Log the command output and result
            Log::info('Backup Command Output: ', $output);
            Log::info('Backup Command Result: ' . $result);
    
            if ($result === 0) {
                return redirect()->route('admin.backup.index')->with('success', 'Respaldo creado exitosamente.');
            }
    
            return redirect()->route('admin.backup.index')->with('error', 'Error al crear el respaldo.');
        } catch (\Exception $e) {
            Log::error('Error al crear respaldo: ' . $e->getMessage());
            return redirect()->route('admin.backup.index')->with('error', 'Error al crear el respaldo.');
        }
    }

    public function restoreBackup(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimetypes:application/sql,text/plain',
        ]);

        $file = $request->file('backup_file');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Archivo de respaldo no válido.');
        }

        $path = $file->storeAs('temp', 'restore.sql');

        $databaseHost = env('DB_HOST');
        $databaseName = env('DB_DATABASE');
        $databaseUser = env('DB_USERNAME');
        $databasePassword = env('DB_PASSWORD');

        $command = sprintf(
            'mysql -h %s -u %s -p%s %s < %s',
            escapeshellarg($databaseHost),
            escapeshellarg($databaseUser),
            escapeshellarg($databasePassword),
            escapeshellarg($databaseName),
            storage_path('app/' . $path)
        );

        exec($command, $output, $result);

        Storage::delete($path);

        if ($result === 0) {
            return redirect()->back()->with('success', 'Base de datos restaurada exitosamente.');
        }

        return redirect()->back()->with('error', 'Error al restaurar la base de datos.');
    }
}
