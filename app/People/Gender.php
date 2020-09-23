<?php

declare(strict_types=1);

namespace App\People;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gender extends Model
{
    /**
     * Eloquent relationship: Each gender may have many people.
     *
     * @return HasMany
     */
    public function people(): HasMany
    {
        return $this->hasMany(People::class);
    }
}
