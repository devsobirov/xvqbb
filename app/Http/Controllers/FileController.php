<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Storage;

class FileController extends Controller
{
    public function open(File $file)
    {
        $this->middleware('role');
        return Storage::response($file->path, $file->getReadableFileName());
    }

    public function download(File $file)
    {
        $this->middleware('role');
        return Storage::download($file->path, $file->getReadableFileName());
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'array',
            'file.*' => 'file',
            'dir' => 'string'
        ]);

        /** @var UploadedFile $file */
        $file = $request->file[0];
        $saveDir = 'files'. DIRECTORY_SEPARATOR . $request->dir;
        if (!Storage::exists($saveDir)) {
            Storage::makeDirectory($saveDir);
        }
        $path = $file->storeAs($saveDir, $this->getFileName($file, $request->file_name));

        if ($path) {
            $stored = File::create([
                'path' => $path,
                'filable_type' => $request->filable_type,
                'filable_id' => $request->filable_id,
                'extension' => $file->getClientOriginalExtension(),
                'size' => round(((int) $file->getSize()) / 1024 , 2), // KB
                'user_id' => auth()->id()
            ]);

            return response()->json(['success' => 'File uploaded', 'file' => $stored]);
        }

        return response()->json(['message' => 'Uploading error'], 400);
    }

    public function delete(File $file)
    {
        abort_if(
            !auth()->user()->isAdmin() || $file->filable_id != auth()->user()->workplace()?->id,
            403,
            'Faylni ochirish uchun huquqlar yetarli emas'
        );

        $path = $file->path;
        $file->delete();
        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        return response()->json(['success' => 'ok'], 204);
    }

    protected function getFileName(UploadedFile $file, ?string $filename = null)
    {
        $ext = $file->getClientOriginalExtension();
        $name = !empty($filename) ? $filename : Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $nextId = \DB::table('files')->max('id') + 1;
        return $nextId . '_' . $name . '.' . $ext;
    }
}
