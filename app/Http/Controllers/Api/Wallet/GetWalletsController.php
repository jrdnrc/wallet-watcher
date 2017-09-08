<?php declare(strict_types=1);

namespace App\Http\Controllers\Api\Wallet;

use App\Address;
use App\Http\Controllers\Controller;
use App\Wallet;
use Blockchain\Blockchain;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetWalletsController
 * @package App\Http\Controllers\Api\Wallet
 * @author Jordan Crocker <jordan@hotsnapper.com>
 */
final class GetWalletsController extends Controller
{
    /** @var Blockchain */
    private $blockchain;

    /**
     * @param Blockchain $blockchain
     */
    public function __construct(Blockchain $blockchain)
    {
        $this->blockchain = $blockchain;
    }

    /**
     * @return Response
     */
    public function __invoke() : Response
    {
        $wallets = Wallet::all(['wallet_id', 'name'])
            ->each(
                function ($wallet) {
                    $wallet->addresses = Address::where('wallet_id', $wallet->wallet_id)->get(['address']);
                    $wallet->balance   = $wallet->addresses->sum(
                        function ($address) {
                            return $this->blockchain->Explorer->getAddress($address)->final_balance;
                        }
                    );

                    $wallet->fiat = $this->blockchain->Rates->fromBTC($wallet->balance * pow(10, 8), 'GBP');
                }
            );

        return response()->json($wallets);
    }
}
