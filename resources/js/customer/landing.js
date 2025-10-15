import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

// Tunggu sampai DOM sepenuhnya loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing Swipers...');

    // Swiper untuk Features - TIKET
    if (document.querySelector('.mySwiperFeatures')) {
        var swiperFeatures = new Swiper(".mySwiperFeatures", {
            slidesPerView: 1,
            spaceBetween: 20,
            speed: 600,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next-features",
                prevEl: ".swiper-button-prev-features",
            },
            pagination: {
                el: ".swiper-pagination-features",
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + '"></span>';
                },
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 24,
                },
                1024: {
                    slidesPerView: 1,
                    spaceBetween: 28,
                },
                1280: {
                    slidesPerView: 1,
                    spaceBetween: 32,
                }
            },
        });
    }

    // Swiper untuk Review
    if (document.querySelector(".mySwiperReview")) {
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
    }

    // Swiper untuk Promo
    if (document.querySelector(".mySwiperPromo")) {
        new Swiper(".mySwiperPromo", {
            slidesPerView: "auto",
            spaceBetween: 20,
            loop: true,
            speed: 800,
            navigation: {
                nextEl: ".swiper-button-next-promo",
                prevEl: ".swiper-button-prev-promo",
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            }
        });
    }

    // Swiper untuk Mitra
    if (document.querySelector(".mySwiperMitra")) {
        var swiperMitra = new Swiper(".mySwiperMitra", {
            slidesPerView: 2,
            spaceBetween: 30,
            loop: true,
            speed: 5000,
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
    }

    // Swiper untuk Highlight
    if (document.querySelector(".myHighlight")) {
        var highlight = new Swiper(".myHighlight", {
            spaceBetween: 10,
        });

        var thumb = new Swiper(".myThumb", {
            spaceBetween: 10,
            slidesPerView: 3,
            centeredSlides: true,
            slideToClickedSlide: true,
        });

        highlight.controller.control = thumb;
        thumb.controller.control = highlight;
    }

    // GSAP Animations

});

// Fungsi untuk promo (pastikan tersedia secara global)
window.copyPromoCode = function(code) {
    navigator.clipboard.writeText(code).then(function() {
        if (typeof showToast === 'function') {
            showToast('Kode promo berhasil disalin!', 'success');
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Kode promo berhasil disalin!',
                timer: 2000
            });
        }
    }, function() {
        // Fallback untuk browser lama
        const textArea = document.createElement('textarea');
        textArea.value = code;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        if (typeof showToast === 'function') {
            showToast('Kode promo berhasil disalin!', 'success');
        }
    });
};

window.sharePromo = function() {
    if (navigator.share) {
        navigator.share({
            title: 'Promo Spesial',
            text: 'Dapatkan promo menarik!',
            url: window.location.href,
        })
        .then(() => {
            if (typeof showToast === 'function') {
                showToast('Promo berhasil dibagikan!', 'success');
            }
        })
        .catch((error) => console.log('Error sharing:', error));
    } else {
        // Fallback untuk browser yang tidak support share
        copyPromoCode('PROMOCODE');
    }
};

document.addEventListener("DOMContentLoaded", () => {
    console.log("🟢 Inisialisasi panorama...");

    // Cek apakah PANOLENS sudah tersedia
    if (typeof PANOLENS === "undefined") {
        console.error("❌ PANOLENS belum ter-load. Pastikan urutan script benar.");
        return;
    }

    const imageContainer = document.querySelector(".image-container");
    if (!imageContainer) {
        console.error("❌ .image-container tidak ditemukan di DOM");
        return;
    }

    const imagePath = "/assets/360/ex4.jpeg";
    console.log("🖼️ Path panorama:", imagePath);

    const panorama = new PANOLENS.ImagePanorama(imagePath);
    const viewer = new PANOLENS.Viewer({
        container: imageContainer,
        autoRotate: true,
        autoRotateSpeed: 0.3,
        controlBar: true,
    });

    viewer.add(panorama);

    panorama.addEventListener("load", () => {
        console.log("✅ Panorama berhasil dimuat");
        document.getElementById("loading").style.display = "none";
    });

    panorama.addEventListener("error", (err) => {
        console.error("❌ Gagal memuat panorama:", err);
    });
});

