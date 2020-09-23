<?php

declare(strict_types=1);

namespace App\People;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class People extends Model
{
    /**
     * @inheritDoc
     */
    protected $table = 'people';

    /**
     * Eloquent relationship: Person belongs to the gender.
     *
     * @return BelongsTo
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }
}
