<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Http;

use Intervention\Image\Facades\Image;

class StorageController extends Controller
{
    public function skinShow($filename)
    {
        $path = 'skins/' . $filename;
        if (Storage::disk('public')->exists($path)) {
            $file = Storage::disk('public')->get($path);
            return (new Response($file, 200))->header('Content-Type', 'image/png');
        } else {
            $defaultPath = 'skins/default.png';
            $defaultFile = Storage::disk('public')->get($defaultPath);
            return (new Response($defaultFile, 200))->header('Content-Type', 'image/png');
        }
    }
    public function headShow($filename)
    {
      $path = 'skins/' . $filename;

      if (Storage::disk('public')->exists($path)) {
        $image = Storage::disk('public')->get($path);

        // Используйте Intervention Image для обрезания изображения (получение только головы) и увеличения его до 512x512
        $img = Image::make($image);
        $head = $img->crop(8, 8, 8, 8)->resize(512, 512)->encode('png');

        return (new Response($head, 200))
            ->header('Content-Type', 'image/png');
    } else {
        // Если файл не найден, вернем изображение default.png с обрезанной головой и увеличенным размером
        $defaultPath = 'skins/default.png';
        $defaultFile = Storage::disk('public')->get($defaultPath);

        $img = Image::make($defaultFile);
        $head = $img->crop(8, 8, 8, 8)->resize(512, 512)->encode('png');

        return (new Response($head, 200))
            ->header('Content-Type', 'image/png');
    }
    }

}
