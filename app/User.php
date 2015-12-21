<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get all tasks ordered by user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderedTasks()
    {
        return $this->hasMany('App\Task', 'ordered_by');
    }

    /**
     * Get all issues reported by user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reportedIssues()
    {
        return $this->hasMany('App\Issue', 'ordered_by');
    }

    /**
     * Make comment on Executable instance
     *
     * @param \App\Comment $comment
     * @param \App\Executable $executable
     */
    public function makeComment(Comment $comment, Executable $executable)
    {
        $this->comments()->save($comment);
        $executable->addComment($comment);
    }

    /**
     * Get all user's comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get all tasks assigned to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany('App\Task')->withTimestamps();
    }

    /**
     * Get user's unfinished tasks
     *
     * @return mixed
     */
    public function unfinishedTasks()
    {
        return $this->tasks()->with('orderer')->where('accomplish_date', null)->get();
    }

    /**
     * Get all issues assigned to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function issues()
    {
        return $this->belongsToMany('App\Issue')->withTimestamps();
    }

    /**
     * Order new Task
     *
     * @param \App\Task $task
     * @param array $executors
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function orderTask(Task $task, array $executors)
    {
        $task = $this->orderedTasks()->save($task);
        return $task->assignToUsers($executors);
    }

    /**
     * Report new Issue
     *
     * @param \App\Issue $issue
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function reportIssue(Issue $issue)
    {
        return $this->reportedIssues()->save($issue);
    }
}
