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
        <div id='notification'
            class='min-w-[250px] p-4 bg-red-700 text-white text-center rounded-lg fixed z-index-10 top-0 right-0 mr-10 mt-5 drop-shadow-lg'>
            <span id='notificationMessage'></span>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        let baseURL = '<?php echo $baseURL; ?>';
        let imageBaseURL = '<?php echo $imageBaseURL; ?>';
        let apiKey = '<?php echo $apiKey; ?>';
        let searchKeyword = '';

        // Hide loader
        $('#autoLoad').hide();

        // Hide notification
        $('#notification').hide();

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
                                    let searchRating = item.vote_average * 10;

                                    htmlData.push(`
                                    <a href='${detailsURL}' class='group'>
                                        <div class='min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col duration-100'>
                                            <div class='overflow-hidden rounded-[32px]'>
                                                <img class='w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200' src='${searchImage}'/>
                                            </div>
                                            <span class='font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none'>${searchTitle}</span>
                                            <span class='font-inter text-sm mt-1'>${searchYear}</span>
                                            <div class='flex flex-row mt-1 items-center'>
                                                <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                    <path d='M18 21H8V8L15 1L16.25 2.25C16.3667 2.36667 16.4627 2.525 16.538 2.725C16.6127 2.925 16.65 3.11667 16.65 3.3V3.65L15.55 8H21C21.5333 8 22 8.2 22.4 8.6C22.8 9 23 9.46667 23 10V12C23 12.1167 22.9873 12.2417 22.962 12.375C22.9373 12.5083 22.9 12.6333 22.85 12.75L19.85 19.8C19.7 20.1333 19.45 20.4167 19.1 20.65C18.75 20.8833 18.3833 21 18 21ZM6 8V21H2V8H6Z' fill='#38B6FF'/>
                                                </svg>
                                                <span class='font-inter text-sm ml-1'>${searchRating}%</span>
                                            </div>
                                        </div>
                                    </a>
                                `);
                                }
                            });

                            // Show HTML
                            $('#dataWrapper').append(htmlData.join(''));
                        }
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        // Hide loader
                        $('#autoLoad').hide();

                        // Show notification
                        $('#notificationMessage').text('Terjadi kendala, coba beberapa saat lagi');
                        $('#notification').show();

                        // Set notification timeout. 3 seconds
                        setTimeout(function() {
                            $('#notification').hide();
                        }, 3000);
                    });
            }
        }
    </script>
</body>

</html>
