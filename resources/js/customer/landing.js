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



