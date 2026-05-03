<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    // Eine Company gehört zu genau einem User bzw. Provider.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Eine Company kann mehrere JobPostings besitzen.
    public function jobPostings(): HasMany
    {
        return $this->hasMany(JobPosting::class);
    }
}
