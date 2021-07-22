@component('mail::message')
# File Uploaded

<strong>"{{ $document->filename }}"</strong> was successfully uploaded
on <strong>{{ $document->upload_date_time->format('d/m/Y') }}</strong>
at <strong>{{ $document->upload_date_time->format('h:ma') }}</strong>
and was <strong>{{ $document->file_size_in_kb }}KB</strong> in size.

@endcomponent
