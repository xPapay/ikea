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
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'notify_task_assigned',
        'notify_task_unassigned',
        'notify_task_edited',
        'notify_task_deleted',
        'notify_task_accomplished',
        'notify_task_accepted',
        'notify_task_rejected',
        'notify_comment_added',
        'notify_task_before_deadline',
        'no_interruption_from',
        'no_interruption_to',
        ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function setNoInterruptionFromAttribute($value)
    {
        $this->attributes['no_interruption_from'] = $value . ":00";
    }

    public function setNoInterruptionToAttribute($value)
    {
        $this->attributes['no_interruption_to'] = $value . ":00";
    }

    public function getNoInterruptionFromAttribute($value)
    {
        $pieces = explode(":", $value, 2);
        $hour = preg_replace('/^00/', '0', $pieces[0]);
        return $hour;
    }

    public function getNoInterruptionToAttribute($value)
    {
        $pieces = explode(":", $value, 2);
        $hour = preg_replace('/^00/', '0', $pieces[0]);
        return $hour;
    }

    public function getNoInterruptionFromTimeAttribute($value)
    {
        return $this->attributes['no_interruption_from'];
    }

    public function getNoInterruptionToTimeAttribute($value)
    {
        return $this->attributes['no_interruption_to'];
    }

    /**
     * Get all tasks ordered by user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderedTasks()
    {
        return $this->hasMany('App\Task', 'ordered_by');
    }

    public function orderedTasksUsers()
    {
        return $this->hasManyThrough('App\Task_User', 'App\Task', 'ordered_by');
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
        $commentId = $this->comments()->save($comment);
        $executable->addComment($commentId);
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
        return $this->belongsToMany('App\Task')->withPivot('accomplish_date', 'confirmed')->withTimestamps();
    }

    public function supportedTasks()
    {
        return $this->belongsToMany('App\Task', 'user_support_task')->withTimestamps();
    }

    public function user_tasks()
    {
        return $this->hasMany('App\Task_User');
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

    public function followups()
    {
        return $this->hasMany('App\Issue', 'followup_by');
    }

    /**
     * Order new Task
     *
     * @param \App\Task $task
     * @param array $executors
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function orderTask(Task $task, array $executors, $tags, $supporters = array())
    {
        $task = $this->orderedTasks()->save($task);
        if ($tags != null)
        {
            $task->assignTag($tags);
        }
        $task->assignToUsers($executors);
        $task->assignSupportToUsers($supporters);
        return $task;
    }

    /**
     * Report new Issue
     *
     * @param \App\Issue $issue
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function reportIssue(Issue $issue, array $executors)
    {
        $issue = $this->reportedIssues()->save($issue);
        return $issue->assignToUsers($executors);
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function getRolesListAttribute()
    {
        return $this->roles->lists('id')->toArray();
    }

    public function assignRole($role)
    {
        $role == null ? $role = array() : $role;
        return $this->roles()->sync($role);
    }

    public function addRole($role)
    {
        if (is_object($role) && get_class($role) == 'App\Role')
        {
            return $this->roles()->save($role);
        }
        return $this->roles()->attach($role);
    }

    public function hasRole($role)
    {
        if (is_string($role))
        {
            return $this->roles->contains('name', $role);
        }

        // if is given a collection

        return $this->roles->intersect($role)->count();
    }

    public function isAdmin()
    {
        if ($this->hasRole('admin'))
        {
            return true;
        }

        return false;
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Notification', 'notification_user', 'user_id', 'notification_id')->withPivot('delayed');
    }

    public function triggeredNotifications()
    {
        return $this->hasMany('App\Notification');
    }
    
}
