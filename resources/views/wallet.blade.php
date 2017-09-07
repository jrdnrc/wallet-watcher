<!DOCTYPE html>

<html>
<head>
    <title>App</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
<div class="container">

    <div id="app">
        <div class="row">
            <div class="col-xs-3 pull-right">
                <span class="btn btn-primary" data-toggle="modal" data-target="#new-wallet-modal">New Wallet</span>
            </div>

            <div class="col-xs-7 col-md-4" v-for="w in wallets">
                <wallet :wallet_id="w.wallet_id"
                        :name="w.name"
                        :balance="w.balance"
                        :addresses="w.addresses" />
            </div>
        </div>

        <add-wallet v-on:wallet-added="fetchWallets" />
    </div>

</div>

<script src="/js/manifest.js"></script>
<script src="/js/vendor.js"></script>
<script src="/js/app.js"></script>

</body>

</html>