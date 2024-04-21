  {{-- similar --}}
  <div class="mt-12">
      <span class="ml-28 font-sans font-bold text-xl">May You Like This</span>
      <div class="w-auto flex flex-row overflow-x-auto pl-28 pt-6 pb-10">
          @foreach ($similar as $similarItem)
              @php
                  $original_date = $similarItem->first_air_date;
                  $timestamp = strtotime($original_date);
                  $similarYear = date('Y', $timestamp);

                  $similarId = $similarItem->id;
                  $similarTitle = $similarItem->name;
                  $similarRating = $similarItem->vote_average;
                  $similarImg = "{$imageBaseURL}/w500{$similarItem->backdrop_path}";

                  // Ambil genre yang sesuai dengan id genre film
                  $genres = [];
                  foreach ($showGenre as $showGenreItem) {
                      if (in_array($showGenreItem->id, $showItem->genre_ids)) {
                          $genres[] = $showGenreItem->name;
                      }
                  }
              @endphp
          @endforeach
          <a href="" class="group">
              <div
                  class="min-w--[232px] min-h-[428] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col md:mr-8 duration-100">
                  <div class="overflow-hidden rounded-[32px]">
                      <img src="" alt=""
                          class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200">
                  </div>
                  <span
                      class="font-sans font-bold text-xl mt-4 line-clamp-1 md:line-clamp-none group-hover:line-clamp-none">{{ $similarTitle }}</span>
                  <div class="flex justify-between mt-2">
                      <div class="flex flex-row items-center">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="yellow"
                              class="bi bi-star-fill" viewBox="0 0 16 16">
                              <path
                                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                          </svg>
                          <span class="font-sans ml-2">{{ $similarRating }}</span>
                      </div>
                      <span>|</span>
                      <span class="font-sans">{{ $similarYear }}</span>
                  </div>
                  <span class="font-sans text-sm mt-1">{{ implode(', ', $genres) }}</span>
              </div>
          </a>
      </div>
  </div>
