<?php declare(strict_types = 1);

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers;
use Illuminate\Routing\Router;

$router->group(
    [
        'prefix' => 'wallet',
    ],
    function (Router $router) {
        $router->get('/', Controllers\Api\Wallet\GetWalletsController::class);
        $router->post('/', Controllers\Api\Wallet\NewWalletController::class);
        $router->get('/{walletId}', Controllers\Api\Wallet\GetBalanceOfWalletController::class);
        $router->post('/{walletId}/address', Controllers\Api\Wallet\AddAddressToWalletController::class);
    }
);

$router->group(
    [
        'prefix' => 'app',
    ],
    function (Router $router) {
        $router->get('/', function () {
            return view('wallet');
        });
    }
);