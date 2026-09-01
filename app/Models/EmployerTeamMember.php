<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerTeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'user_id',
        'permission_level',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getPermissionLabelAttribute()
    {
        return ucfirst($this->permission_level);
    }
}
