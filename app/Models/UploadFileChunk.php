<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadFileChunk extends Model
{
    use HasFactory;
    protected $fillable = [
        'userid',
        'firstname',
        'lastname',
        'gender',
        'email',
        'phone',
        'dob',
        'jobTitle',
    ];
}
