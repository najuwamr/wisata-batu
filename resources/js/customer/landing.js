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


