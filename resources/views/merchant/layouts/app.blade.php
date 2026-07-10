<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Ally Pay Merchant</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>
<div class="d-flex">

    @include('merchant.partials.sidebar')

    <div class="w-100">
        @include('merchant.partials.navbar')

        <main class="p-4">
            @yield('content')
        </main>
    </div>

</div>
</body>
</html>