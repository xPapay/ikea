<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

abstract class Executable extends Model
{

    public function setDeadlineAttribute($date)
    {
        $this->attributes['deadline'] = Carbon::createFromFormat('d. m. Y', $date);
    }

    public function getDeadlineAttribute($date)
    {
        return Carbon::parse($date)->format('d. m. Y');
    }

//    public function setAccomplishDateAttribute($date)
//    {
//        $this->attributes['accomplish_date'] = Carbon::createFromFormat('d. m. Y', $date);
//    }

    public function getAccomplishDateAttribute($date)
    {
        if ($date == null)
            return null;
        return Carbon::parse($date)->format('d. m. Y');
    }

    public function getExecutorsListAttribute()
    {
        return $this->executors->lists('id')->toArray();
    }

    /**
     * Get all comments belongs to Executable instance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments()
    {
        return $this->belongsToMany('App\Comment');
    }

    /**
     * Assign given comment to the Executable instance
     *
     * @param \App\Comment $comment
     */
    public function addComment($commentId)
    {
        $this->comments()->attach($commentId);
    }

    /**
     * Get the orderer of the Executable instance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderer()
    {
        return $this->belongsTo('App\User', 'ordered_by');
    }

    /**
     * Alias of orderer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reporter()
    {
        return $this->orderer();
    }

    /**
     * Get all executors of the Executable instance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function executors()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    /**
     * Assign Executable instance to given users
     *
     * @param array $users
     */
    public function assignToUsers(array $users)
    {
        $this->executors()->sync($users);
    }


    /**
     * Determine if given user is creator of the Executable instance
     *
     * @param $user
     * @return bool
     */
    public function isOwnedBy($user)
    {
        if (is_string($user))
        {
            return $this->orderer->id == $user;
        }

        if ($this->orderer == $user)
        {
            return true;
        }

        return false;
    }

    public function createToolTipster()
    {
        $tooltipster = app('App\Http\Tooltipster');
        return $tooltipster->create($this->executors);
    }

    public function scopeUnfinished($query, $count)
    {
        return $query->where('confirmed', 0)->orderBy('deadline', 'asc')->take($count);
    }

}