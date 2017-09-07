<?php declare(strict_types=1);

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\AddAddressToWalletRequest;
use App\Wallet;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AddAddressToWalletController
 * @package App\Http\Controllers
 * @author Jordan Crocker <jordan@hotsnapper.com>
 */
final class AddAddressToWalletController extends Controller
{
    /**
     * @param AddAddressToWalletRequest $request
     * @param string $walletId
     * @return Response
     */
    public function __invoke(AddAddressToWalletRequest $request, string $walletId) : Response
    {
        /** @var Wallet $wallet */
        $wallet = tap(Wallet::where(['wallet_id' => $walletId])->first())->watch($request->request->get('address'));

        return response()->json([
            'wallet_id'     => $wallet->wallet_id,
            'address_count' => $wallet->addresses()->count(),
        ]);
    }
}
