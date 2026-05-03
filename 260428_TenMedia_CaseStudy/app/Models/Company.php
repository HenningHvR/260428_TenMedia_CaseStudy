<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    // Attribute, die per Mass Assignment befüllt werden dürfen.
    protected $fillable = [
        'cmpny_name',
        'cmpny_description',
        'website',
        'cmpny_location',
    ];

    // Eine Company kann mehrere Provider besitzen.
    public function providers(): HasMany
    {
        return $this->hasMany(User::class)
            ->where('role', 'provider');
    }

    // Eine Company kann mehrere JobPostings besitzen.
    public function jobPostings(): HasMany
    {
        return $this->hasMany(JobPosting::class);
    }
}
