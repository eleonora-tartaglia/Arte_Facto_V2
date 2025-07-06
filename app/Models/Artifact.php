<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Artifact extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'civilization_id',
        'source_id',
        'discovery_site',
        'discovery_year',
        'archaeologist',
        'discovery_context',
        'materials',
        'dimensions',
        'condition_grade',
        'condition_notes',
        'has_restoration',
        'authenticated',
        'authentication_certificate',
        'provenance_history',
        'legend',
        'price',
        'sale_type',
        'status',
        'images',
        'featured',
        'wishlist_count',
    ];

    protected $casts = [
        'materials' => 'array',
        'dimensions' => 'array',
        'provenance_history' => 'array',
        'images' => 'array',
        'has_restoration' => 'boolean',
        'authenticated' => 'boolean',
        'featured' => 'boolean',
        'price' => 'decimal:2',
        'wishlist_count' => 'integer',
    ];

    public function civilization(): BelongsTo
    {
        return $this->belongsTo(Civilization::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(ArtifactSource::class, 'source_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ArtifactTag::class, 'artifact_tag', 'artifact_id', 'tag_id');
    }

    public function auction(): HasOne
    {
        return $this->hasOne(Auction::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function usersInCart(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'cart_items', 'artifact_id', 'user_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

}