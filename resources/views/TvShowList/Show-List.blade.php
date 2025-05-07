<div class="mt-12">
    <div class="flex justify-between">
        <span class="ml-4 md:ml-14 font-sans font-bold text-2xl">TV Show Popular</span>
        <a href="{{ route('Tv-Show') }}"
            class="flex justify-center items-center mr-4 md:mr-14 w-32 h-12 bg-blue-500 hover:bg-blue-600 text-xl rounded-xl">See
            All</a>
    </div>
    <div class="grid xl:grid-cols-5 sm:grid-cols-3 grid-cols-2 gap-4 xl:ml-14 pt-6 pb-10 sm:mx-6 mx-4">
        @foreach ($show as $showItem)
            @php
                $original_date = $showItem->first_air_date;
                $timestamp = strtotime($original_date);
                $showYear = date('Y', $timestamp);

                $showId = $showItem->id;
                $showTitle = $showItem->name;
                $showRating = $showItem->vote_average;
                $showImg = "{$imageBaseURL}/w500{$showItem->poster_path}";

                // Ambil genre yang sesuai dengan id genre film
                $genres = [];
                foreach ($showGenre as $showGenreItem) {
                    if (in_array($showGenreItem->id, $showItem->genre_ids)) {
                        $genres[] = $showGenreItem->name;
                    }
                }
            @endphp

            <a href="{{ route('Tv-Show-Details', ['id' => $showId]) }}" class="group">
                <div
                    class="min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col md:mr-8 duration-100">
                    <div class="overflow-hidden rounded-[32px]">
                        <img src="{{ $showImg }}" alt=""
                            class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200">
                    </div>
                    <span
                        class="font-sans font-bold text-xl mt-4 line-clamp-1 md:line-clamp-none group-hover:line-clamp-none">{{ $showTitle }}</span>
                    <div class="flex justify-between mt-2">
                        <div class="flex flex-row items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="yellow"
                                class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            <span class="font-sans ml-2">{{ $showRating }}</span>
                        </div>
                        <span>|</span>
                        <span class="font-sans">{{ $showYear }}</span>
                    </div>
                    <span class="font-sans text-sm mt-1">{{ implode(', ', $genres) }}</span>
                </div>
            </a>
        @endforeach
    </div>
</div>
