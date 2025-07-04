<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArtifactSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'description',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function artifacts(): HasMany
    {
        return $this->hasMany(Artifact::class, 'source_id');
    }
}