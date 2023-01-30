<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    use HasFactory, HasUser;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $with = ['bank'];

    /**
     * Get the bank associated with the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bank(): HasOne
    {
        return $this->hasOne(Bank::class, 'id', 'bank_id');
    }
}
