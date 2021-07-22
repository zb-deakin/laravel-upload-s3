@extends('layouts.outer-html')

@section('title', 'Document uploader')

@section('content')

    @include('documents.uploadFile')

    @include('documents.listUploadedDocuments')

@endsection
