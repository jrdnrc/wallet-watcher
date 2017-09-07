<?php

namespace App\Http\Requests\Wallet;

use App\Http\Requests\Request;

class AddAddressToWalletRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'address' => 'required|string',
        ];
    }
}
