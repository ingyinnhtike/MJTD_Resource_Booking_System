<?php
/**
 * Model generated using LaraAdmin
 * Help: http://laraadmin.com
 * LaraAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Dwij IT Solutions
 * Developer Website: http://dwijitsolutions.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car_Request_Status extends Model
{
    use SoftDeletes;
    
    protected $table = 'car_request_statuses';
    
    protected $hidden = [
    
    ];
    
    protected $guarded = [];
    
    protected $dates = ['deleted_at'];
}
