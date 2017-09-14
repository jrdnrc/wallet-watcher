<?php declare(strict_types=1);

namespace App\Http\Requests\Blockchain;

use App\Http\Requests\Request;

/**
 * Class AddressBalanceRequest
 *
 * @author jrdn rc <jordan@jcrocker.uk>
 */
final class AddressBalanceRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'addresses' => 'required|array',
        ];
    }
}