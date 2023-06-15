<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class DailyWorkInfo extends Model
{
    use HasFactory;

    protected $table = 'DailyWorkInfo';

    protected $fillable = [
        'UserID',
        'Month',
        'Date',
        'DayOfWeek',
        'StartTime',
        'EndTime',
        'WorkingContent',
        'Remarks',
    ];

    protected $hidden = [];

    protected $casts = [
        'StartTime' => 'datetime:H:i',
        'EndTime' => 'datetime:H:i',
    ];

    // Start: Calculate Working Hours Automatically
    public function setStartTimeAttribute($value)
    {
        $this->attributes['StartTime'] = $value;

        if (!is_null($this->attributes['EndTime'])) {
            $restDuration = ($this->attributes['RestTime'] == '1:00') ? CarbonInterval::hours(1) : CarbonInterval::hours(0);
            $startTime = Carbon::parse($this->attributes['StartTime']);
            $endTime = Carbon::parse($this->attributes['EndTime']);
            $workingHours = $startTime->diff($endTime);

            // Convert to seconds
            $workingHoursInSeconds = $workingHours->s + ($workingHours->i * 60) + ($workingHours->h * 60 * 60);
            $restDurationInSeconds = $restDuration->totalSeconds;

            // Subtract and convert back to hours
            $workingHoursAfterRest = ($workingHoursInSeconds - $restDurationInSeconds) / 3600;
            $this->attributes['KeptHours'] = gmdate('H:i', $workingHoursInSeconds);
            $this->attributes['WorkingHours'] = gmdate('H:i', $workingHoursAfterRest * 3600);
        }
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['EndTime'] = $value;

        if (!is_null($this->attributes['StartTime'])) {
            $restDuration = ($this->attributes['RestTime'] == '1:00') ? CarbonInterval::hours(1) : CarbonInterval::hours(0);
            $startTime = Carbon::parse($this->attributes['StartTime']);
            $endTime = Carbon::parse($this->attributes['EndTime']);
            $workingHours = $startTime->diff($endTime);

            // Convert to seconds
            $workingHoursInSeconds = $workingHours->s + ($workingHours->i * 60) + ($workingHours->h * 60 * 60);
            $restDurationInSeconds = $restDuration->totalSeconds;

            // Subtract and convert back to hours
            $workingHoursAfterRest = ($workingHoursInSeconds - $restDurationInSeconds) / 3600;
            $this->attributes['KeptHours'] = gmdate('H:i', $workingHoursInSeconds);
            $this->attributes['WorkingHours'] = gmdate('H:i', $workingHoursAfterRest * 3600);
        }
    }
    // End: Calculate Working Hours Automatically

    // Functions to relate monthly work
    public function getBelondMonthlyReport()
    {
        return $this->belongsToMany(EmployeeMonth::class, 'daily_work', 'employee_daily_work_id', 'employee_month_id');
    }

    // Start: Construct Function
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['DayOfWeek'] == $attributes['DayOfWeek'];

        $this->attributes['StayTime'] = '0:00';
        $this->attributes['RestTime'] = ($this->attributes['DayOfWeek'] == 'SAT' or $this->attributes['DayOfWeek'] == 'SUN') ? '0:00' : '1:00';
        $this->attributes['WorkingHours'] = '0:00';
    }
    // End: Construct Function
}
