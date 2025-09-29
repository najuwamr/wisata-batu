import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);


document.addEventListener("DOMContentLoaded", () => {
  const marquee = document.querySelector(".marquee");

  // Ambil lebar dari anak pertama (satu grup logo)
  const trackWidth = marquee.children[0].scrollWidth;

  gsap.to(marquee, {
    x: -trackWidth, // Geser ke kiri sejauh lebar satu grup logo
    duration: 20,
    ease: "linear",
    repeat: -1, // Ulangi tanpa henti
  });
});

document.addEventListener("DOMContentLoaded", function() {
        const revealElements = document.querySelectorAll(".reveal-on-scroll, .reveal-item");

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("is-visible");
                    // Opsional: Hentikan pengamatan setelah elemen terlihat
                    // observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1 // Elemen dianggap terlihat jika 10% areanya masuk viewport
        });

        revealElements.forEach(element => {
            observer.observe(element);
        });
    });

      var swiper = new Swiper(".mySwiperFeatures", {
            slidesPerView: "auto", // Mengizinkan lebar kartu ditentukan oleh CSS
            spaceBetween: 20,
            speed:700,
            loop:true,
            autoplay: {
            delay: 3000, // jeda antar slide (ms)
            disableOnInteraction: false,
           // tetap jalan meskipun user swipe
            },
            navigation: {
                nextEl: ".swiper-button-next-features",
                prevEl: ".swiper-button-prev-features",
            },
        });

 new Swiper(".mySwiperReview", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        speed: 700,
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });

new Swiper(".mySwiperPromo", {
        slidesPerView: "auto",
        spaceBetween: 20,
        loop: true,
        speed: 800, // biar smooth
        navigation: {
            nextEl: ".swiper-button-next-promo",
            prevEl: ".swiper-button-prev-promo",
        },
        autoplay: {
            delay: 3000, // jeda antar slide (ms)
            disableOnInteraction: false,}
    });

 var swiperMitra = new Swiper(".mySwiperMitra", {
    slidesPerView: 2,  // default mobile
    spaceBetween: 30,
    loop: true,
    speed: 5000, // makin besar makin halus
    autoplay: {
        delay: 0,
        disableOnInteraction: false,
    },
    freeMode: true,
    freeModeMomentum: false,
    breakpoints: {
        640: { slidesPerView: 3 },
        768: { slidesPerView: 4 },
        1024: { slidesPerView: 6 },
    },
});

