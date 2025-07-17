<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 'auto', // keep 'auto' so card width determines layout
        spaceBetween: 10.5,
        freeMode: true,
        grabCursor: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 3,
                spaceBetween: 6
            },
            768: {
                slidesPerView: '10',
                spaceBetween: 10
            }
        }
    });


</script>