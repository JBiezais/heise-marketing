<?php

namespace App\NumberQueue\Database\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $value
 */
class NumberQueue extends Model
{
    protected $table = 'number_queue';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'value',
        'created_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => 'integer',
        ];
    }
}
