<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
//    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'name',
        'code',
        'external_id',
        'type',
        'emblem',
        'number_of_available_seasons',
        'area_code',
        'area_flag',
    ];
}
