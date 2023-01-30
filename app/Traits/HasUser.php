<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

trait HasUser {

    /**
     * Scope a query to only include auth users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisAuth($query)
    {
        return $query->where('user_id', Auth::id())
                    ->with('user');
    }

    /**
     * Get the user associated with the HasUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
