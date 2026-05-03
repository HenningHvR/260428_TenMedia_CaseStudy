<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    // Ein User kann mehrere Companies besitzen.
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    // Ein User kann über seine Companies mehrere JobPostings besitzen.
    public function jobPostings(): HasManyThrough
    {
        return $this->hasManyThrough(
            JobPosting::class,
            Company::class,
            'user_id',
            'company_id',
            'id',
            'id'
        );
    }
}
