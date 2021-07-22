<div class="row card text-center">
    <div class="card-header">
        PDF, TXT, WORD or CSV files
    </div>
    <div class="card-body form-group">
        <h3 class="card-title">Upload a file (10MB limit)</h3>
        <form action="/" method="post" enctype="multipart/form-data">
            @csrf
            <input autocomplete="off" type="file" name="document" id="document">
            <button class="btn btn-primary" type="submit">Upload</button>
        </form>
    </div>
</div>
