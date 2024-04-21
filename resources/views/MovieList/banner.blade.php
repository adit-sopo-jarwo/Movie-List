<div class="w-full h-[512px] flex flex-col relative bg-black">

    @foreach ($banner as $bannerItem)
        @php
            $bannerImage = "{$imageBaseURL}/original{$bannerItem->backdrop_path}";
        @endphp
        <div class="slide flex flex-row items-center w-full h-full relative">
            <img src="{{ $bannerImage }}" alt="" class="absolute w-full h-full object-cover" />

            <div class="w-full h-full absolute bg-black bg-opacity-40"></div>

            <div class="w-10/12 flex flex-col ml-36 z-10">
                <span class="font-bold font-sans text-4xl text-white">{{ $bannerItem->title }}</span>
                <span class="font-sans text-xl text-white w-1/2 line-clamp-2">{{ $bannerItem->overview }}</span>
                <a href="MovieList/movie/{{ $bannerItem->id }}"
                    class="w-fit bg-blue-500 text-white pl-2 py-2 pr-4 mt-5 font-sans text-sm flex flex-row rounded-full items-center hover:drop-shadow-xl duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-play-fill" viewBox="0 0 16 16">
                        <path
                            d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393" />
                    </svg>
                    <span>Detail</span>
                </a>
            </div>
        </div>
    @endforeach

    <div class="absolute left-3 top-1/2 -translate-y-1/2 w-1/12 flex justify-center">
        <button onclick="moveSlide(-1)" class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5" />
            </svg>
        </button>
    </div>

    <div class="absolute right-3 top-1/2 -translate-y-1/2 w-1/12 flex justify-center items-center z-10">
        <button onclick="moveSlide(1)" class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
            </svg>
        </button>
    </div>


    <div class="absolute bottom-0 w-full mb-8">
        <div class="w-ful flex flex-row items-center justify-center">
            @for ($pos = 1; $pos <= count($banner); $pos++)
                <div class="w-2.5 h-2.5 rounded-full mx-1 cursor-pointer dot"
                    onclick="currentSlide({{ $pos }})"></div>
            @endfor
        </div>
    </div>
</div>


<script>
    let slideIndex = 1;
    showSlide(slideIndex);

    function showSlide(position) {
        let index;
        const slides = document.getElementsByClassName("slide");
        const dots = document.getElementsByClassName("dot");

        if (position > slides.length) {
            slideIndex = 1;
        }

        if (position < 1) {
            slideIndex = slides.length;
        }

        for (index = 0; index < slides.length; index++) {
            slides[index].classList.add('hidden');
        }

        slides[slideIndex - 1].classList.remove('hidden');

        for (index = 0; index < dots.length; index++) {
            dots[index].classList.remove('bg-blue-400');
            dots[index].classList.add('bg-white');
        }
        dots[slideIndex - 1].classList.remove('bg-white');
        dots[slideIndex - 1].classList.add('bg-blue-400');
    }

    function moveSlide(moveStep) {
        showSlide(slideIndex += moveStep)
    }

    function currentSlide(position) {
        showSlide(slideIndex = position);
    }
</script>
