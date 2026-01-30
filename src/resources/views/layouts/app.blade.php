<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>もぎたて</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400&display=swap">
    <link rel="stylesheet" href="{{ asset('css/utility.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('css')
</head>

<body class="product__body">

    <header class="product__header">
        <div class="product__header-inner">
            <h1 class="product__logo u-font-weight-bold">mogitate</h1>
        </div>
    </header>

    <main class="product__main">
        @yield('content')
    </main>

</body>

</html>