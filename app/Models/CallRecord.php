<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallRecord extends Model
{
    use HasFactory;

    protected $table='call_records';

    protected $fillable=['call_id', 'caller_id', 'callee_id', 'minutes', 'start', 'end', 'type', 'coins'];
}
