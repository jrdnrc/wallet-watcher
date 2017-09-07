<?php declare(strict_types=1);

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Wallet;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetWalletsController
 * @package App\Http\Controllers\Api\Wallet
 * @author Jordan Crocker <jordan@hotsnapper.com>
 */
final class GetWalletsController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke() : Response
    {
        return response()->json(Wallet::with('addresses')->get(['wallet_id', 'name']));
    }
}
