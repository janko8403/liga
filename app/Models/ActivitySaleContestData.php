<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitySaleContestData extends Model
{
    use HasFactory;

    protected $fillable = ['*'];

    protected $table ='activities_sales_contests_data';

}
