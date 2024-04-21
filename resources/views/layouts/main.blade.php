<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Kumov</title>

</head>

<body>
    <div class="w-full h-auto min-h-screen flex flex-col">
        {{-- navbar  --}}
        @include('components/navbar')

        {{-- banner  --}}
        @include('MovieList/banner')

        {{-- list movie --}}
        @include('MovieList/list')

        {{-- tv show --}}
        @include('TvShowList/Show-List')

        
    </div>

  

</body>

</html>
