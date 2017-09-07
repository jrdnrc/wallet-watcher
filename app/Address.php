<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /** @var array */
    protected $fillable = ['address', 'wallet_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'wallet_id');
    }
}
