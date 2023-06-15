<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlySettlement extends Model
{
    use HasFactory;

    protected $table = 'MonthlySettlementInfo';

    protected $fillable = [
        'UserID',
        'Month',
        'ReportDate',
        'PersonInResponse',
        'Reporter',
        'Dept',
        'PrescribedWorkingDay',
        'ActuallyWorkingDay',
        'Month',
        'SumKeptTime',
        'SumWorkingTime',
        'SumRestTime',
        'WorkingPlace',
        'Remarks',
    ];

    protected $hidden = [];

    protected $casts = [
        'SumKeptTime' => 'datetime:H:i',
        'SumWorkingTime' => 'datetime:H:i',
        'SumRestTime' => 'datetime:H:i'
    ];
}
