<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kumov</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    @include('components/navbar')

    <div class="w-full h-screen">
        @php
            $backdropPath = $tvData ? "{$imageBaseURL}/original{$tvData->backdrop_path}" : '';
            $title = '';
            $rating = 0;
            $year = '';
            $overview = '';
            if ($tvData) {
                $title = $tvData->name;
                $rating = $tvData->vote_average;
                $original_date = $tvData->first_air_date;
                $timestamp = strtotime($original_date);
                $year = date('Y', $timestamp);
                $overview = $tvData->overview;
            }

            $genre = '';
            if (isset($tvData->genres)) {
                foreach ($tvData->genres as $item) {
                    $genre .= $item->name . ', ';
                }
                $genre = rtrim($genre, ', ');
            }

            $duration = '';
            if ($tvData->episode_run_time) {
                $runtime = $tvData->episode_run_time[0];
                $duration = "{$runtime}m / episode";
            }

            $seasons = count($tvData->seasons);

            $trailerID = '';
            if (isset($tvData->videos->results)) {
                foreach ($tvData->videos->results as $item) {
                    if (strtolower($item->type) == 'trailer') {
                        $trailerID = $item->key;
                        break;
                    }
                }
            }

            $cast = '';
            if (isset($creditsData->cast)) {
                foreach ($creditsData->cast as $item) {
                    $cast .= $item->name . ', ';
                }
                $cast = rtrim($cast, ', ');
            }

        @endphp
        <div class="mx-44 m-4 px-4 py-16 flex flex-col md:flex-row">
            <div class="flex-none mt-12">
                <img src="{{ $backdropPath }}" alt="" class="w-64 lg:w-96 rounded-lg">
            </div>
            <div class="pl-4 md:pl-8">
                <h2 class="font-sans font-bold text-4xl">{{ $title }}</h2>
                <div class="flex mt-3 gap-4">
                    <div class="flex flex-row items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="yellow"
                            class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path
                                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                        </svg>
                        <span class="font-sans ml-2">{{ $rating }}</span>
                    </div>
                    <p>|</p>
                    <span clas="ml-4">{{ $year }}</span>
                    <p>|</p>
                    <span clas="ml-4">{{ $duration }}</span>
                    <p>|</p>
                    <span clas="ml-4">Seasons {{ $seasons }}</span>
                    <p>|</p>
                    <span clas="ml-4">{{ $genre }}</span>
                </div>
                <p class="mt-10 font-sans">{{ $overview }}</s>
                <div class="mt-10">
                    <span class="font-xl font-bold">Cast : </span>
                    <span class="font-sans">{{ $cast }}</span>
                    <!-- Button to play trailer -->
                    @if ($trailerID)
                        <button
                            class="mt-8 bg-blue-500 hover:bg-blue-600 text-white px-2 py-3 mb-4 font-sans text-xl flex flex-row rounded-lg items-center hover:drop-shadow-lg duration-200"
                            onclick="showTrailer(true)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-play-fill" viewBox="0 0 16 16">
                                <path
                                    d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393" />
                            </svg>
                            <span>Play Trailer</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- similar tv show --}}
        {{-- @include('TvShowList/Tv-Show-Similar') --}}
    </div>

    <!-- Trailer wrapper -->
    <div class="absolute top-0 right-0 m-4 w-250 h-350" id="trailerWrapper">
        <button class="group" onclick="showTrailer(false)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-x-square" viewBox="0 0 16 16">
                <path
                    d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
        </button>

        <iframe id="youtubeVideo" class="w-full h-full"
            src="https://www.youtube.com/embed/{{ $trailerID }}?enablejsapi=1" title="{{ $title }}"
            frameborder="0"
            allow="accelerometer; autoplay; clipbiard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen>
        </iframe>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        // hide trailer
        $("#trailerWrapper").hide();

        function showTrailer(isVisible) {
            if (isVisible) {
                $("#trailerWrapper").show();
            } else {
                // stop video 
                $("#youtubeVideo")[0].contentWindow.postMessage('{"event":"command", "func":"' + 'stopVideo' +
                    '","args":""}', '*');

                $("#trailerWrapper").hide();
            }
        }
    </script>
</body>

</html>
