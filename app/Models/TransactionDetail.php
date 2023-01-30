<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionDetail extends Model
{
    use HasFactory;
    const STATE_PENDING    = 1;
    const STATE_PROCESSING = 2;
    const STATE_CANCEL     = 3;
    const STATE_SUCCESS    = 4;
    const STATE_ERROR      = 5;

    protected $guarded = ['id'];
    protected $with = ['states'];
    public $timestamps = false;

    /**
     * Get all of the states for the TransactionDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states(): HasMany
    {
        return $this->hasMany(TransactionDetailState::class, 'transaction_detail_id', 'id');
    }
}
