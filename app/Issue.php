<?php

namespace App;


use Carbon\Carbon;

class Issue extends Executable
{
    protected $fillable = [
        'name',
        'description',
        'solution',
        'deadline',
        'followup_date',
        'followup_by',
        'costs'
    ];

    public function followupBy()
    {
        return $this->belongsTo('App\User', 'followup_by');
    }

    public function scopeWithStatus($query, $status)
    {
        if ($status == 'unfinished')
            return $query->whereNull('accomplish_date');
        if ($status == 'finished')
            return $query->whereNotNull('accomplish_date');
        if ($status == 'followup_wait')
            return $query->whereNotNull('accomplish_date')->where('followup_date', '>', date("Y-m-d H:i:s",time()));
        if ($status == 'all')
            return $query;
        throw new Exception('Undefined Status');
    }

    public function setFollowUpDateAttribute($date)
    {
        $this->attributes['followup_date'] = Carbon::createFromFormat('d. m. Y', $date);
    }

    public function getFollowUpDateAttribute($date)
    {
        return Carbon::parse($date)->format('d. m. Y');
    }

}
