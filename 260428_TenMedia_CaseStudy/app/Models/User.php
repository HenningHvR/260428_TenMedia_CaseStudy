<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Attribute, die per Mass Assignment befüllt werden dürfen.
     *
     * @var list<string>
     */
    protected $fillable = [
        'usr_name',
        'email',
        'password',
        'role',
    ];

    /**
     * Attribute, die bei der Ausgabe verborgen werden.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute, die automatisch umgewandelt werden sollen.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Ein User kann mehrere Companies besitzen.
     */
    public function companies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Ein User kann über seine Companies mehrere JobPostings besitzen.
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

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
