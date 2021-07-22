<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'original_filename',
        'file_size_in_kb',
        'upload_date_time',
        's3_file_path_and_filename',
        's3_full_url',
        'slug',
    ];

    protected $dates = ['upload_date_time'];
}
