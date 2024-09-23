<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LogActivity extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'log_activity';

    protected $fillable = ['menu', 'activity'];
}
