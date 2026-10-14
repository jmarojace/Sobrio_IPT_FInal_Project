<?php

namespace App\Models;

use Database\Factories\FeedingRecordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedingRecord extends Model
{
    /** @use HasFactory<FeedingRecordFactory> */
    use HasFactory;

    protected $fillable = ['animal_id', 'feed_type', 'quantity_kg', 'fed_at', 'notes'];

    protected function casts(): array
    {
        return ['quantity_kg' => 'decimal:2', 'fed_at' => 'datetime'];
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
