<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageFileService
{
    public function putFileInStorage($file, $path)
    {
        return Storage::put($path, $file);
    }

    public function deleteFileFromStorage($file)
    {
        Storage::delete($file);
    }
}
