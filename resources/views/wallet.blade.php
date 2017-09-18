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
        <pin-board />
    </div>

</div>

<script src="/js/manifest.js"></script>
<script src="/js/vendor.js"></script>
<script src="/js/app.js"></script>

</body>

</html>