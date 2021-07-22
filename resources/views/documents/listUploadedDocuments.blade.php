<div class="row mt-4">
    <div class="table-responsive rounded">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Size</th>
                <th>Upload date</th>
            </tr>
            </thead>
            <tbody>
            @isset($documents)
                @forelse($documents as $document)
                    <tr>
                        <td>
                            <a href="{{ url("/view-document/{$document->slug}") }}">
                                {{ $document->original_filename }}
                            </a>
                        </td>
                        <td>{{ $document->file_size_in_kb }}KB</td>
                        <td>{{ $document->upload_date_time }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>No files uploaded yet.</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforelse
            @endisset
            </tbody>
        </table>
        {{ $documents->links() }}
    </div>
</div>
