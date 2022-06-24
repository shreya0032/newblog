<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_name','description','role_id','previous_info','present_info','created_by', 'created_at', 'updated_at'
    ];

}
