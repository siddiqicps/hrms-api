<?php

namespace App\Models;

// use Illuminate\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
// use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Laravel\Lumen\Auth\Authorizable;

class Client extends Model
{
    // use Authenticatable, Authorizable, HasFactory;
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_name', 'client_testimonial', 'client_profile', 'client_status', 'client_logo'
    ];

    protected $table = 'clients_info';
    protected $primaryKey = 'client_id';

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
