<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="d-flex">
        @include('admin.partials.sidebar')

        <div class="w-100">

                @include('admin.partials.navbar')

                <main class="p-4">

                        @yield('content')


                </main>


        </div>




    </div>
</body>
</html>