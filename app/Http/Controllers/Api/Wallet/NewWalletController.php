<?php declare(strict_types=1);

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\NewWalletRequest;
use App\Wallet;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NewWalletController
 * @package App\Http\Controllers\Wallet
 * @author Jordan Crocker <jordan@hotsnapper.com>
 */
final class NewWalletController extends Controller
{
    /**
     * @param NewWalletRequest $request
     * @return Response
     */
    public function __invoke(NewWalletRequest $request) : Response
    {
        $wallet = Wallet::create(['wallet_id' => uuid(), 'name' => $request->request->get('name')])
            ->withAddresses($request->request->get('addresses', []));

        return response()->json(['wallet_id' => $wallet->wallet_id]);
    }
}
