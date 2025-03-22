<?php

namespace App\Models;

// use Illuminate\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
// use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobSeeker extends Model
{
    // use Authenticatable, Authorizable, HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email_id', 'phone_number', 'qualification', 'area', 'industry', 'role', 'experience', 'paste_resume', 'resume', 'certificate', 'branch_id', 'isUploaded', 'is_cert_attested', 'passport_no', 'dob', 'nationality', 'exp_india', 'exp_abroad', 'isDeleted', 'designation'
    ];

    protected $table = 'jobseeker_info';
    protected $primaryKey = 'jobseeker_id';
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
