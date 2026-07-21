<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Attribute, die per Mass Assignment befüllt werden dürfen.
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_id',
    ];

    // Attribute, die bei der Ausgabe verborgen werden.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Attribute, die automatisch umgewandelt werden sollen.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Ein User kann optional genau einer Company zugeordnet sein.
    // Fachlich wird diese Zuordnung für Provider genutzt.
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Ein User kann über seine Company mehrere JobPostings besitzen.
    public function jobPostings(): HasManyThrough
    {
        return $this->hasManyThrough(
            JobPosting::class,
            Company::class,
            'id',
            'company_id',
            'company_id',
            'id'
        );
    }
}
