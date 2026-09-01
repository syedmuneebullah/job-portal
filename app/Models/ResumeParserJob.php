<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeParserJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'parsed_data',
        'status',
        'error_message',
        'completed_at',
    ];

    protected $casts = [
        'parsed_data' => 'array',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
