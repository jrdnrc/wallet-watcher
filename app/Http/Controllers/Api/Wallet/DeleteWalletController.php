<?php declare(strict_types=1);

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Wallet;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DeleteWalletController
 * @package App\Http\Controllers\Api\Wallet
 * @author Jordan Crocker <jordan@hotsnapper.com>
 */
final class DeleteWalletController extends Controller
{
    /**
     * @param string $walletId
     * @return Response
     * @throws \Exception
     */
    public function __invoke(string $walletId) : Response
    {
        Wallet::where('wallet_id', $walletId)->delete();

        return response()->json(['deleted' => true]);
    }
}
