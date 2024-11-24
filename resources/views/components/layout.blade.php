<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>
    <x-navbar></x-navbar>
    <div class="mb-3">
        {{ $herosection ?? '' }}
    </div>
    <div class="container">
        <main class="main-content" id="main">
            <div class="my-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        {{ $breadcrumb ?? '' }}
                    </ol>
                </nav>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <div class="poppins-bold fs-2">{{ $title ?? '' }}</div>
                <div>
                    {{ $action ?? '' }}
                </div>
            </div>
            <div class="mt-3">
                {{ $slot ?? '' }}
            </div>
        </main>
    </div>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
