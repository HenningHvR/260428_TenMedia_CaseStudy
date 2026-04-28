<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPosting extends Model
{
    use HasFactory;

    /**
     * Attribute, die per Mass Assignment befüllt werden dürfen.
     * Fremdschlüssel wie company_id und category_id werden bewusst nicht aufgenommen.
     */
    protected $fillable = [
        'title',
        'jp_description',
        'jp_location',
        'experience_level',
        'employment_type',
        'salary',
        'is_active',
    ];

    /**
     * Datentyp-Umwandlungen für Eloquent.
     */
    protected $casts = [
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Ein JobPosting gehört zu genau einer Company.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Ein JobPosting gehört zu genau einer Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
