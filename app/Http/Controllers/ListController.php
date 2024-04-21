<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ListController extends Controller
{
    public function index()
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imageBaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');
        // max data
        $MAX_BANNER = 3;
        $MAX_MOVIE = 10;
        $MAX_SHOWS = 10;

        // hit api for banner
        $bannerResponse = Http::get("{$baseURL}/trending/movie/week", [
            'api_key' => $apiKey,
        ]);

        $bannerArray = [];

        // cek respon
        if ($bannerResponse->successful()) {
            // cek data
            $resultArray = $bannerResponse->object()->results;

            if (isset($resultArray)) {
                // looping data
                foreach ($resultArray as $item) {
                    array_push($bannerArray, $item);

                    // menampilkan max data
                    if (count($bannerArray) == $MAX_BANNER) {
                        break;
                    }
                }
            }
        }

        // hit api for movie list popular
        $popularResponse = Http::get("{$baseURL}/movie/popular", [
            'api_key' => $apiKey,
        ]);

        //menyiapkan variablenya
        $popularArray = [];

        //cek api
        if ($popularResponse->successful()) {
            $resultArray = $popularResponse->object()->results;

            if (isset($resultArray)) {
                foreach ($resultArray as $item) {
                    array_push($popularArray, $item);

                    if (count($popularArray) == $MAX_MOVIE) {
                        break;
                    }
                }
            }
        }

        // genre movie
        $genreResponse = Http::get("{$baseURL}/genre/movie/list", [
            'api_key' => $apiKey,
        ]);

        $genreArray = [];

        //cek api
        if ($genreResponse->successful()) {
            $genresArray = $genreResponse->object()->genres;

            if (isset($genresArray)) {
                foreach ($genresArray as $item) {
                    array_push($genreArray, $item);
                }
            }
        }

        // hit api for tv show 
        $showResponse = Http::get("{$baseURL}/trending/tv/week", [
            'api_key' => $apiKey,
        ]);

        $showArray = [];

        // cek respon
        if ($showResponse->successful()) {
            // cek data
            $resultArray = $showResponse->object()->results;

            if (isset($resultArray)) {
                // looping data
                foreach ($resultArray as $item) {
                    array_push($showArray, $item);

                    // menampilkan max data
                    if (count($showArray) == $MAX_SHOWS) {
                        break;
                    }
                }
            }
        }

        // genre show
        $showGenreResponse = Http::get("{$baseURL}/genre/tv/list", [
            'api_key' => $apiKey,
        ]);

        $showGenreArray = [];

        //cek api
        if ($showGenreResponse->successful()) {
            $showGenreArray = $showGenreResponse->object()->genres;

            if (isset($showGenresArray)) {
                foreach ($showGenresArray as $item) {
                    array_push($showGenreArray, $item);
                }
            }
        }

        return view(
            'layouts/main',
            [
                'baseURL' => $baseURL,
                'imageBaseURL' => $imageBaseURL,
                'apiKey' => $apiKey,
                'banner' => $bannerArray,
                'popular' => $popularArray,
                'genre' => $genreArray,
                'show' => $showArray,
                'showGenre' => $showGenreArray
            ]
        );
    }

    public function movie(Request $request)
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imageBaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');
        $sortBy = "popularity.desc";
        $page = $request->input('page', 1);

        $movieResponse = Http::get("{$baseURL}/discover/movie", [
            'api_key' => $apiKey,
            'sort_by' => $sortBy,
            'page' => $page
        ]);

        // Menyiapkan variabel
        $movieArray = [];
        $totalPages = 0;

        // Cek API
        if ($movieResponse->successful()) {
            $responseData = $movieResponse->object();

            // Memastikan responseData->results tersedia sebelum dilakukan foreach
            if (isset($responseData->results)) {
                // Menambahkan hasil pencarian film ke dalam $movieArray
                foreach ($responseData->results as $item) {
                    array_push($movieArray, $item);
                }
            }

            // Tidak perlu foreach untuk total_pages
            if (isset($responseData->total_pages)) {
                // Mengambil jumlah total halaman
                $totalPages = $responseData->total_pages;
            }
        }


        // genre movie
        $genreResponse = Http::get("{$baseURL}/genre/movie/list", [
            'api_key' => $apiKey,
        ]);

        $genreArray = [];

        //cek api
        if ($genreResponse->successful()) {
            $genresArray = $genreResponse->object()->genres;

            if (isset($genresArray)) {
                foreach ($genresArray as $item) {
                    array_push($genreArray, $item);
                }
            }
        }

        return view(
            'MovieList/movie',
            [
                'baseURL' => $baseURL,
                'imageBaseURL' => $imageBaseURL,
                'apiKey' => $apiKey,
                'movie' => $movieArray,
                'genre' => $genreArray,
                'sortBy' => $sortBy,
                'page' => $page,
                'totalPages' => $totalPages,
            ]
        );
    }

    public function movieDetails($id)
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imageBaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');

        $response = Http::get("{$baseURL}/movie/{$id}", [
            'api_key' => $apiKey,
            'append_to_response' => 'videos'
        ]);

        $movieData = null;

        if ($response->successful()) {
            $movieData = $response->object();
        }

        $response = Http::get("{$baseURL}/movie/{$id}/credits", [
            'api_key' => $apiKey
        ]);

        $creditsData = null;

        if ($response->successful()) {
            $creditsData = $response->object();
        }

        return view('MovieList/Movie-Details', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseURL,
            'apiKey' => $apiKey,
            'movieData' => $movieData,
            'creditsData' => $creditsData
        ]);
    }

    // public function movieSimilar($id)
    // {
    //     $baseURL = env('MOVIE_DB_BASE_URL');
    //     $imageBaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
    //     $apiKey = env('MOVIE_DB_API_KEY');
    //     $MAX_SIMILAR = 10;

    //     // hit api for banner
    //     $similarResponse = Http::get("{$baseURL}/movie/{$id}/similar", [
    //         'api_key' => $apiKey,
    //     ]);

    //     $similarArray = [];

    //     // cek respon
    //     if ($similarResponse->successful()) {
    //         // cek data
    //         $resultArray = $similarResponse->object()->results;

    //         dd(resultArray);

    //         if (isset($resultArray)) {
    //             // looping data
    //             foreach ($resultArray as $item) {
    //                 array_push($similarArray, $item);

    //                 // menampilkan max data
    //                 if (count($similarArray) == $MAX_SIMILAR) {
    //                     break;
    //                 }
    //             }
    //         }
    //     }

    //     // genre movie
    //     $genreResponse = Http::get("{$baseURL}/genre/movie/list", [
    //         'api_key' => $apiKey,
    //     ]);

    //     $genreArray = [];

    //     //cek api
    //     if ($genreResponse->successful()) {
    //         $genresArray = $genreResponse->object()->genres;

    //         if (isset($genresArray)) {
    //             foreach ($genresArray as $item) {
    //                 array_push($genreArray, $item);
    //             }
    //         }
    //     }

    //     return view(
    //         'MovieList/Movie-Similar',
    //         [
    //             'baseURL' => $baseURL,
    //             'imageBaseURL' => $imageBaseURL,
    //             'apiKey' => $apiKey,
    //             'similar' => $similarArray,
    //             'genre' => $genreArray
    //         ]
    //     );
    // }

    public function tvshow(Request $request)
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imageBaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');
        $sortBy = "popularity.desc";
        $page = $request->input('page', 1);

        $tvResponse = Http::get("{$baseURL}/discover/tv", [
            'api_key' => $apiKey,
            'sort_by' => $sortBy,
            'page' => $page
        ]);

        // Menyiapkan variabel
        $tvArray = [];
        $totalPages = 0;

        // Cek API
        if ($tvResponse->successful()) {
            $responseData = $tvResponse->object();

            // Memastikan responseData->results tersedia sebelum dilakukan foreach
            if (isset($responseData->results)) {
                // Menambahkan hasil pencarian film ke dalam $movieArray
                foreach ($responseData->results as $item) {
                    array_push($tvArray, $item);
                }
            }

            // Tidak perlu foreach untuk total_pages
            if (isset($responseData->total_pages)) {
                // Mengambil jumlah total halaman
                $totalPages = $responseData->total_pages;
            }
        }


        // genre tv
        $genreResponse = Http::get("{$baseURL}/genre/tv/list", [
            'api_key' => $apiKey,
        ]);

        $genreArray = [];

        //cek api
        if ($genreResponse->successful()) {
            $genresArray = $genreResponse->object()->genres;

            if (isset($genresArray)) {
                foreach ($genresArray as $item) {
                    array_push($genreArray, $item);
                }
            }
        }

        return view(
            'TvShowList/Tv-Show',
            [
                'baseURL' => $baseURL,
                'imageBaseURL' => $imageBaseURL,
                'apiKey' => $apiKey,
                'tv' => $tvArray,
                'genre' => $genreArray,
                'sortBy' => $sortBy,
                'page' => $page,
                'totalPages' => $totalPages,
            ]
        );
    }

    public function tvshowDetails($id)
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imageBaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');

        $response = Http::get("{$baseURL}/tv/{$id}", [
            'api_key' => $apiKey,
            'append_to_response' => 'videos'
        ]);

        $tvData = null;

        if ($response->successful()) {
            $tvData = $response->object();
            // dd($tvData);
        }

        $response = Http::get("{$baseURL}/tv/{$id}/credits", [
            'api_key' => $apiKey
        ]);

        $creditsData = null;

        if ($response->successful()) {
            $creditsData = $response->object();
        }


        return view('TvShowList/Tv-Show-Details', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseURL,
            'apiKey' => $apiKey,
            'tvData' => $tvData,
            'creditsData' => $creditsData
        ]);
    }

    // public function tvshowSimilar($id)
    // {
    //     $baseURL = env('MOVIE_DB_BASE_URL');
    //     $imageBaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
    //     $apiKey = env('MOVIE_DB_API_KEY');
    //     $MAX_SIMILAR = 10;

    //     // hit api for banner
    //     $similarResponse = Http::get("{$baseURL}/tv/{$id}/similar", [
    //         'api_key' => $apiKey,
    //     ]);

    //     $similarArray = [];

    //     // cek respon
    //     if ($similarResponse->successful()) {
    //         // cek data
    //         $resultArray = $similarResponse->object()->results;

    //         if (isset($resultArray)) {
    //             // looping data
    //             foreach ($resultArray as $item) {
    //                 array_push($similarArray, $item);

    //                 // menampilkan max data
    //                 if (count($similarArray) == $MAX_SIMILAR) {
    //                     break;
    //                 }
    //             }
    //         }
    //     }

    //     // genre show
    //     $showGenreResponse = Http::get("{$baseURL}/genre/tv/list", [
    //         'api_key' => $apiKey,
    //     ]);

    //     $showGenreArray = [];

    //     //cek api
    //     if ($showGenreResponse->successful()) {
    //         $showGenreArray = $showGenreResponse->object()->genres;

    //         if (isset($showGenresArray)) {
    //             foreach ($showGenresArray as $item) {
    //                 array_push($showGenreArray, $item);
    //             }
    //         }
    //     }

    //     return view('TvShowList/Tv-Show-Similar', [
    //         'baseURL' => $baseURL,
    //         'imageBaseURL' => $imageBaseURL,
    //         'apiKey' => $apiKey,
    //         'similar' => $similarArray,
    //         'showGenre' => $showGenreArray
    //     ]);
    // }

    public function search()
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imageBaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');

        return view('components/search', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imageBaseURL,
            'apiKey' => $apiKey
        ]);
    }
}
