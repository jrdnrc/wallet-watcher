<?php declare(strict_types = 1);

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers;
use Illuminate\Routing\Router;

$router->group(
    [
        'prefix' => 'wallet',
    ],
    function (Router $router) : void {
        $router->get('/', Controllers\Api\Wallet\GetWalletsController::class);
        $router->post('/', Controllers\Api\Wallet\NewWalletController::class);
        $router->post('/{walletId}/address', Controllers\Api\Wallet\AddAddressToWalletController::class);
        $router->delete('/{walletId}', Controllers\Api\Wallet\DeleteWalletController::class);
    }
);

$router->group(
    [
        'prefix' => 'btc',
    ],
    function (Router $router) : void {
        $router->get('multiaddr', Controllers\Api\Blockchain\AddressBalanceController::class);
    }
);


$router->get('/', function () {
    return view('wallet');
});