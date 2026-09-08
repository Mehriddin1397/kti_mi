<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function download(Request $request, Document $document): StreamedResponse
    {
        $task = $document->task;

        abort_unless(
            $request->user()->can('upload', $task) || $request->user()->can('review', $task),
            403
        );

        return Storage::disk('local')->download($document->file_path, $document->file_name);
    }
}
