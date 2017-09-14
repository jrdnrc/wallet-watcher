<?php declare(strict_types=1);

namespace App\Http\Controllers\Api\Blockchain;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blockchain\AddressBalanceRequest;
use Blockchain\Blockchain;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AddressBalanceController
 *
 * @author jrdn rc <jordan@jcrocker.uk>
 */
final class AddressBalanceController extends Controller
{
    /** @var Blockchain */
    private $blockchain;

    /**
     * AddressBalanceController constructor.
     *
     * @param Blockchain $blockchain
     */
    public function __construct(Blockchain $blockchain)
    {
        $this->blockchain = $blockchain;
    }

    /**
     * @param AddressBalanceRequest $request
     * @return Response
     */
    public function __invoke(AddressBalanceRequest $request) : Response
    {
        $balance = collect($request->query->get('addresses'))->reduce(
            function (float $carry, string $address) : float {
                return $carry + (double) $this->blockchain->Explorer->getAddress($address)->final_balance;
            },
            0.00
        );

        $fiat = $this->blockchain->Rates->fromBTC($balance * (10 ** 8), 'GBP');

        return response()->json(['balance' => number_format($balance, 8), 'fiat' => number_format($fiat, 2)]);
    }
}