<?php

namespace App\Models;

// use Illuminate\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
// use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Laravel\Lumen\Auth\Authorizable;

class Job extends Model
{
    // use Authenticatable, Authorizable, HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_title', 'post_description', 'post_location', 'post_expiry_date', 'post_status', 'walkin_date', 'walkin_location', 'walkin_visibility', 'profile_details', 'client_id', 'client_visibility'
    ];

    protected $table = 'post_info';
    protected $primaryKey = 'post_id';
    const CREATED_AT = 'added_date';
    const UPDATED_AT = 'modified_date';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password',
    // ];
}
