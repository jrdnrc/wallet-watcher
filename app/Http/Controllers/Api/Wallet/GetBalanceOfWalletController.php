<?php declare(strict_types=1);

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Wallet;
use Blockchain\Blockchain;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetBalanceOfWalletController
 * @package App\Http\Controllers
 * @author Jordan Crocker <jordan@hotsnapper.com>
 */
final class GetBalanceOfWalletController extends Controller
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
     * @param string $walletId
     * @return Response
     */
    public function __invoke(string $walletId) : Response
    {
        $wallet = Wallet::where(['wallet_id' => $walletId])->first();

        $sum = $wallet
            ->addresses
            ->sum(
                function ($address) {
                    return $this->blockchain->Explorer->getAddress($address->address)->final_balance;
                }
            );

        $fiat = $this->blockchain->Rates->fromBTC($sum * pow(10, 8), 'GBP');

        return response()->json(['wallet_id' => $walletId, 'balance' => $sum, 'fiat' => $fiat]);
    }
}
