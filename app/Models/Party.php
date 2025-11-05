<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Party extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'host_id',
        'name',
        'description',
        'party_date',
        'location',
    ];

    /**
     * Get the user that is hosting the party.
     */
    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    /**
     * Get the guests attending the party.
     */
    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    /**
     * Get all of the items for the party
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}