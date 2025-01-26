<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'external_id',
        'name',
        'short_name',
        'tla',
        'crest',
        'address',
        'website',
        'founded',
        'venue',
        'coach_name',
        'coach_nationality',
    ];
}
