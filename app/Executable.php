<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class Executable extends Model
{

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
    public function addComment(Comment $comment)
    {
        $this->comments()->sync([$comment->id]);
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

}