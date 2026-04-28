<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * Attribute, die per Mass Assignment befüllt werden dürfen.
     */
    protected $fillable = [
        'ctgry_name',
        'ctgry_description',
    ];

    /**
     * Eine Category kann mehreren JobPostings zugeordnet sein.
     */
    public function jobPostings(): HasMany
    {
        return $this->hasMany(JobPosting::class);
    }
}
