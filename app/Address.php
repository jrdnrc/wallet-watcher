<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Address extends Model
{
    /** @var string[] */
    protected $fillable = ['address', 'wallet_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'wallet_id');
    }

    /**
     * @param Builder $query
     * @return Collection
     */
    public function scopeAddresses(Builder $query) : Collection
    {
        return $query->get(['address'])->pluck('address');
    }
}
