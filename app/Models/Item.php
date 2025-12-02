<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'party_id',
        'name',
        'quantity',
        'guest_id',
    ];

    /**
     * Get the guest that is bringing the item.
     */
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}