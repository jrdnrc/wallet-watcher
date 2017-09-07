<?php

namespace App\Http\Requests\Wallet;

use App\Http\Requests\Request;

final class NewWalletRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'name'      => 'required|string',
            'addresses' => 'array',
        ];
    }
}
