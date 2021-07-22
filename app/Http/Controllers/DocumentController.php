<?php

namespace App\Http\Controllers;

use App\Jobs\SendUploadNotificationMailJob;
use App\Models\Document;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use PhpParser\Comment\Doc;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{

    private function customValidationMessages(): array
    {
        return [
            'document.required' => 'No file was selected',
            'document.max' => '10MB limit for file sizes.',
        ];
    }

    public function index(): View
    {
        $documents = Document::paginate('25');

        return view('documents.index', [
            'documents' => $documents,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            ['document' => ['bail', 'required', 'max:10240', 'mimes:pdf,txt,word,xml,csv']],
            $this->customValidationMessages()
        );

        $homeRoute = redirect()->route('home');

        try {
            $s3DocumentPathAndFileName = $request->file('document')->store('document', 's3');
        } catch (Exception $exception) {
            Log::alert($exception);
            return $homeRoute->with('error', "Could not upload - server error, try again later.");
        }

        $originalFileName = $request->file('document')->getClientOriginalName();
        $uploadFileSizeInKb = $request->file('document')->getSize() / 1000;
        $s3FullDocumentURL = Storage::disk('s3')->url($s3DocumentPathAndFileName);
        $slug = basename($s3DocumentPathAndFileName);

        try {
            $document = Document::create([
                'slug' => $slug,
                'original_filename' => $originalFileName,
                'file_size_in_kb' => $uploadFileSizeInKb,
                'upload_date_time' => Carbon::now(),
                's3_file_path_and_filename' => $s3DocumentPathAndFileName,
                's3_full_url' => $s3FullDocumentURL,
            ]);
        } catch (Exception $exception) {
            Log::alert($exception);
            return $homeRoute->with('error', "Could not save data - server error, try again later.");
        }

        SendUploadNotificationMailJob::dispatch($document);

        return $homeRoute->with('success', "Upload successful: {$originalFileName}");

    }


    public function show(Document $document): StreamedResponse
    {

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename={$document->original_filename}",
            'filename'=> $document->original_filename
        ];

        return Storage::disk('s3')->response($document->s3_file_path_and_filename, $document->original_filename, $headers);

    }

}
