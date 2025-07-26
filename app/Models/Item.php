<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_code',
        'name',
        'category',
        'type',
        'selling_price',
        'cost_price',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array<string, string>
     */

     protected $casts = [
        'selling_price'=> 'float',
        'cost_price'=> 'float',
        'is_active'=> 'boolean',
    ];

    /**
     * The default values for attributes.
     * @var array<string, mixed>
     */

    protected $attributes = [
        'item_code' => '',
        'name' => '',
        'category' => '',
        'type' => '',
        'selling_price' => 0.0,
        'cost_price' => 0.0,
        'is_active' => true,
    ];


    /**
     * Scope a query to filter items by category.
     *
     * @param Builder $query
     * @param string|null $category
     * @return Builder
     */

     public function scopeByCategory (Builder $query, ?string $category): Builder
    {
        return $category ? $query->where('category', $category) : $query;
    }

    /**
     * Scope a query to filter items by type.
     *
     * @param Builder $query
     * @param string|null $type
     * @return Builder
     */
    public function scopeByType (Builder $query, ?string $type): Builder
    {
        return $type ? $query->where('type', $type) : $query;
    }

    /**
     * Scope a query to search items by name.
     *
     * @param Builder $query
     * @param string|null $search
     * @return Builder
     */
    public function scopeSearch (Builder $query, ?string $search): Builder
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    /**
     * Scope a query to filter items by active status.
     *
     * @param Builder $query
     * @param bool $active
     * @return Builder
     */
    public function scopeActive (Builder $query, bool $active = true): Builder
    {
        return $active ? $query->where('is_active', true) : $query;
    }

    /**
     * Scope a query to sort items by a given field and direction.
     *
     * @param Builder $query
     * @param string $field
     * @param string $direction
     * @return Builder
     */
    public function scopeSortBy(Builder $query, string $field = 'name', string $direction = 'asc'): Builder
    {
        return $query->orderBy($field, $direction);
    }
}
