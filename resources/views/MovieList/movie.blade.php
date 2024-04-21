<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Movie Popular</title>
</head>

<body>

    <div class="w-full h-auto min-h-screen flex flex-col">
        {{-- navbar  --}}
        @include('components/navbar')

        <div class="mt-12">
            <div class="flex justify-between">
                <span class="ml-4 md:ml-14 font-sans font-bold text-2xl">Movie Popular</span>
                <a href="{{ route('layouts/main') }}"
                    class="flex justify-center items-center mr-4 md:mr-14 text-xl bg-blue-600 hover:bg-blue-700 rounded-xl w-24 h-12">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                        class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                    </svg>
                    BACK
                </a>
            </div>
            <div class="grid xl:grid-cols-5 sm:grid-cols-3 grid-cols-2 gap-4 xl:ml-14 pt-6 pb-10 sm:mx-6 mx-4">
                @foreach ($movie as $movieItem)
                    @php
                        $original_date = $movieItem->release_date;
                        $timestamp = strtotime($original_date);
                        $movieYear = date('Y', $timestamp);

                        $movieId = $movieItem->id;
                        $movieTitle = $movieItem->title;
                        $movieRating = $movieItem->vote_average;
                        $movieImg = "{$imageBaseURL}/w500{$movieItem->poster_path}";

                        // Ambil genre yang sesuai dengan id genre film
                        $genres = [];
                        foreach ($genre as $genreItem) {
                            if (in_array($genreItem->id, $movieItem->genre_ids)) {
                                $genres[] = $genreItem->name;
                            }
                        }
                    @endphp

                    <a href="{{ route('Movie-Details', ['id' => $movieId]) }}" class="group">
                        <div
                            class="min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col md:mr-8 duration-100">
                            <div class="overflow-hidden rounded-[32px]">
                                <img src="{{ $movieImg }}" alt=""
                                    class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200">
                            </div>
                            <span
                                class="font-sans font-bold text-xl mt-4 line-clamp-1 md:line-clamp-none group-hover:line-clamp-none">{{ $movieTitle }}</span>
                            <div class="flex justify-between mt-2">
                                <div class="flex flex-row items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="yellow"
                                        class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                    <span class="font-sans ml-2">{{ $movieRating }}</span>
                                </div>
                                <span class="font-sans">|</span>
                                <span class="font-sans">{{ $movieYear }}</span>
                            </div>
                            <span class="font-sans text-sm mt-1">{{ implode(', ', $genres) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mb-10">
            <!-- Pagination -->
            <div class="flex justify-center items-center gap-x-6">
                <button type="button"
                    class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-black dark:hover:bg-white/10 dark:focus:bg-white/10">
                    <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                    <a href="{{ $page > 1 ? route('movie', ['page' => $page - 1]) : '#' }}" aria-hidden="true"
                        class="hidden sm:block">Previous</a>
                </button>

                <div class="flex items-center gap-x-1">
                    <span
                        class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:border-gray-700 dark:text-black dark:focus:bg-white/10">{{ $page }}</span>
                    <span
                        class="min-h-[38px] flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm dark:text-gray-500">of</span>
                    <span
                        class="min-h-[38px] flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm dark:text-gray-500">{{ $totalPages }}</span>
                </div>

                <button type="button"
                    class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-black dark:hover:bg-white/10 dark:focus:bg-white/10">
                    <a href="{{ $page < $totalPages ? route('movie', ['page' => $page + 1]) : '#' }}"
                        aria-hidden="true" class="hidden sm:block">Next</a>
                    <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            </div>
            <!-- End Pagination -->
        </div>

    </div>

</body>

</html>
