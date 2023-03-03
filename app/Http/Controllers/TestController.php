<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TestController extends Controller
{
    public function test()
    {
        $disk = Storage::disk('disk');

        $path = "image/bAVzH6bYgrvCiKVnCCdLIYfa7wHIWlOotUup0ul4.png";

        $file = $disk->get($path);

        $filename = $disk->path($path);

        $response = new StreamedResponse(function () use ($file) {
            echo $file;
        });

        $response->headers->set('Content-Type', $disk->mimeType($path));
        $response->headers->set('Content-Length', $disk->size($path));
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $filename);

        return $response;

    }
    public function url()
    {
        $path = "image/bAVzH6bYgrvCiKVnCCdLIYfa7wHIWlOotUup0ul4.png";
        // Storage::disk('disk')->setVisibility($path, 'public');
        // $url = Storage::disk('disk')->temporaryUrl( $path,now()->addMinutes(5));
        // dd($url);
        $url = Storage::temporaryUrl(
            $path,
            now()->addMinutes(5),
            [
                'ResponseContentType' => 'application/octet-stream',
                'ResponseContentDisposition' => 'attachment; filename=file2.jpg',
            ]
        );

    }
    public function download(Request $request)
    {
        $disk = Storage::disk('disk');
        return response()->stream();
    }
}
