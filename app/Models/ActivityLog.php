<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'model',
        'model_id',
        'action',
        'data',
        'old_values',
    ];

    /**
     * Summary of casts
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'old_values' => 'array',
    ];

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, ActivityLog>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of model
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Model, ActivityLog>
     */
    public function model()
    {
        return $this->morphTo();
    }
}
