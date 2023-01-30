<?php

namespace App\Models;

use App\Traits\HasUser;
use Database\Factories\AdminBankFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BankAdmin extends Model
{
    use HasFactory;

    protected $table = 'admin_banks';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $with = ['bank'];

    protected static function newFactory()
    {
        return AdminBankFactory::new();
    }

    /**
     * Get the bank associated with the BankAdmin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bank(): HasOne
    {
        return $this->hasOne(Bank::class, 'id', 'bank_id');
    }
}
