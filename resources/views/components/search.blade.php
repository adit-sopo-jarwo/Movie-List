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
    <div class="w-full h-auto min-h-screen">
        <!-- Navbar -->
        @include('components/navbar')
        <!-- End Navbar -->

        <!-- Content Section -->
        <div class='w-auto pl-28 pr-10 pt-6 pb-10 grid grid-cols-3 lg:grid-cols-5 gap-5' id='dataWrapper'>
            <!-- Wait from AJAX -->
        </div>

        <!-- Data Loader -->
        <div class='w-full pl-28 pr-10 flex justify-center mb-5' id='autoLoad'>
            <svg version='1.1' id='L9' xmlns='http://www.w3.org/2000/svg'
                xmlns:xlink='http://www.w3.org/1999/xlink'   x='0px' y='0px' height='60' viewBox='0 0 100 100'
                enable-background='new 0 0 0 0' xml:space='preserve'>
                <path fill='#000'
                    d='M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50'>

                    <animateTransform attributeName='transform' attributeType='XML' type='rotate' dur='1s'
                        from='0 50 50' to='360 50 50' repeatCount='indefinite' />

                </path>
            </svg>
        </div>

        <!-- Error Notification -->
        <div id='notification' style='display: none;'
            class='min-w-[250px] p-4 bg-red-700 text-white text-center rounded-lg fixed z-index-10 top-0 right-0 mr-10 mt-5 drop-shadow-lg'>
            <span id='notificationMessage'></span>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            let baseURL = '<?php echo $baseURL; ?>';
            let imageBaseURL = '<?php echo $imageBaseURL; ?>';
            let apiKey = '<?php echo $apiKey; ?>';

            // Function to extract the search query parameter from the URL
            function getSearchQueryFromURL() {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get('query') || '';
            }

            // Function to fetch movie genres
            function fetchMovieGenres() {
                $.ajax({
                    url: `${baseURL}/genre/movie/list?api_key=${apiKey}`,
                    type: 'get',
                    success: function(response) {
                        if (response.genres) {
                            // Menyimpan daftar genre film
                            movieGenres = response.genres;
                            // Panggil fungsi untuk mendapatkan daftar genre TV setelah mendapatkan daftar genre film
                            fetchTVGenres();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching movie genres:', errorThrown);
                    }
                });
            }

            // Function to fetch TV genres
            function fetchTVGenres() {
                $.ajax({
                    url: `${baseURL}/genre/tv/list?api_key=${apiKey}`,
                    type: 'get',
                    success: function(response) {
                        if (response.genres) {
                            // Menyimpan daftar genre TV
                            tvGenres = response.genres;
                            // Memanggil fungsi untuk memuat data film dan acara TV setelah mendapatkan daftar genre TV
                            search();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching TV genres:', errorThrown);
                    }
                });
            }

            // Panggil fungsi untuk mendapatkan daftar genre film saat halaman dimuat
            fetchMovieGenres();

            // Variabel untuk menyimpan daftar genre film dan TV
            let movieGenres = [];
            let tvGenres = [];

            // Hide loader
            $('#autoLoad').hide();

            // Hide notification
            $('#notification').hide();

            // Get search query from URL
            let searchKeyword = getSearchQueryFromURL();

            // Pre-fill search input with the search query
            $('#searchInput').val(searchKeyword);

            // Perform search when the page loads if there's a search query in the URL
            if (searchKeyword) {
                search();
            }

            // Get more data
            function search() {
                searchKeyword = $('#searchInput').val().trim();
                if (searchKeyword) {
                    $.ajax({
                            url: `${baseURL}/search/multi?page=1&api_key=${apiKey}&query=${searchKeyword}`,
                            type: 'get',
                            beforeSend: function() {
                                // Show loader
                                $('#autoLoad').show();

                                // Clear data
                                $('#dataWrapper').html('');
                            }
                        })
                        .done(function(response) {
                            // Hide loader
                            $('#autoLoad').hide();

                            if (response.results) {
                                var htmlData = [];
                                response.results.forEach(item => {
                                    if (item.media_type == 'movie' || item.media_type == 'tv') {
                                        let searchTitle = '';
                                        let originalDate = '';
                                        let detailsURL = '';

                                        if (item.media_type == 'movie') {
                                            detailsURL = `/movie/${item.id}`;
                                            original_date = item.release_date;
                                            searchTitle = item.title;
                                        } else {
                                            detailsURL = `/tv/${item.id}`;
                                            original_date = item.first_air_date;
                                            searchTitle = item.name;
                                        }

                                        let date = new Date(original_date);

                                        let searchYear = date.getFullYear();
                                        let searchImage = item.poster_path ?
                                            `${imageBaseURL}/w500${item.poster_path}` :
                                            'https://via.placeholder.com/300x400';
                                        let searchRating = item.vote_average;

                                        // Menampilkan genre di bawah tahun dan rating
                                        let genreList = item.genre_ids.map(genreId => {
                                            let genre = '';
                                            if (item.media_type == 'movie') {
                                                genre = movieGenres.find(genre => genre.id === genreId)?.name;
                                            } else {
                                                genre = tvGenres.find(genre => genre.id === genreId)?.name;
                                            }
                                            return genre;
                                        });

                                        let genreHTML = `<span class="font-sans text-sm mt-1">${genreList.join(', ')}</span>`;

                                        htmlData.push(`
                                    <a href='${detailsURL}' class='group'>
                                        <div class='min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col duration-100'>
                                            <div class='overflow-hidden rounded-[32px]'>
                                                <img class='w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200' src='${searchImage}'/>
                                            </div>
                                            <span class='font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none'>${searchTitle}</span>
                                            <div class="flex justify-between mt-2">
                                                <div class="flex flex-row items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="yellow" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <span class="font-sans ml-2">${searchRating}</span>
                                                </div>
                                                <span>|</span>
                                                <span class="font-sans">${searchYear}</span>
                                            </div>
                                            <span clas="font-sans text-sm mt-1">${genreHTML}</span>
                                        </div>
                                    </a>
                                `);
                                    }
                                });

                                // Show HTML
                                $('#dataWrapper').append(htmlData.join(''));

                                // Add click event handler to the detail links
                                $('.group').click(function(event) {
                                    // Prevent default link behavior
                                    event.preventDefault();
                                    // Navigate to the details URL
                                    window.location.href = $(this).attr('href');
                                });
                            }
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            // Hide loader
                            $('#autoLoad').hide();

                            // Show notification with proper message
                            $('#notificationMessage').text('Terjadi kendala, coba beberapa saat lagi');
                            $('#notification').show();

                            // Set notification timeout. 3 seconds
                            setTimeout(function() {
                                $('#notification').hide();
                            }, 3000);
                        });
                }
            }
        });
    </script>
</body>

</html>
