<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Eine Company gehört zu genau einem User.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Eine Company kann mehrere JobPostings besitzen.
    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class);
    }
}
