<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /** @var array */
    protected $fillable = ['wallet_id', 'name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Address::class, 'wallet_id', 'wallet_id');
    }

    /**
     * @param string[] $addresses
     * @return Wallet
     */
    public function withAddresses(array $addresses) : Wallet
    {
        $this->addresses()->create(
            array_map(
                function ($address) {
                    return ['address' => $address];
                },
                $addresses
            )
        );

        return $this;
    }

    /**
     * @param string $address
     * @return void
     */
    public function watch(string $address) : void
    {
        $this->addresses()->save(new Address(['address' => $address]));
    }
}
