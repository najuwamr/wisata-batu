import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

document.addEventListener("DOMContentLoaded", () => {
    gsap.from(".sejarah", {
        scrollTrigger: {
            trigger: ".sejarah",
            start: "top 80%",   // mulai animasi saat elemen 80% masuk viewport
        },
        y: 50,
        opacity: 0,
        duration: 1.5,
        stagger: 1
    });
});
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

