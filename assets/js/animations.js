document.addEventListener("DOMContentLoaded", function () {
    // Animation du header au chargement
    gsap.from("header", { 
        y: -100, 
        opacity: 0, 
        duration: 1, 
        ease: "power3.out" 
    });

    // Animation de la bannière héro (zoom-in progressif)
    gsap.from(".hero-bg", {
        scale: 1.2,
        opacity: 0,
        duration: 1.5,
        ease: "power3.out"
    });

    gsap.from(".hero-content h1", { 
        x: -100, 
        opacity: 0, 
        duration: 1, 
        delay: 0.5 
    });

    gsap.from(".hero-content p", { 
        x: -100, 
        opacity: 0, 
        duration: 1, 
        delay: 0.8 
    });

    gsap.from(".hero-content .btn", { 
        scale: 0, 
        opacity: 0, 
        duration: 0.5, 
        delay: 1 
    });

    // Animation de l'apparition des sections au scroll
    gsap.utils.toArray(".category").forEach((section, index) => {
        gsap.from(section, {
            opacity: 0,
            y: 100,
            duration: 1,
            delay: index * 0.2,
            scrollTrigger: {
                trigger: section,
                start: "top 100%",
                end: "top 30%",
                scrub: 1,
                markers: false
            }
        });
    });

    // Animation du bouton de changement de thème
    gsap.from("#theme-toggle", {
        scale: 0,
        opacity: 0,
        duration: 0.8,
        ease: "power2.out"
    });

    // Animation des boutons au survol
    gsap.utils.toArray(".btn").forEach((button) => {
        button.addEventListener("mouseenter", () => {
            gsap.to(button, { scale: 1.05, duration: 0.3, ease: "power2.out" });
        });
        button.addEventListener("mouseleave", () => {
            gsap.to(button, { scale: 1, duration: 0.3, ease: "power2.out" });
        });
    });

    // Animation de la barre de recherche
    const searchInput = document.getElementById('search-input');
    const searchIcon = document.getElementById('search-icon');

    // Animation pour élargir la barre de recherche au focus
    searchInput.addEventListener('focus', () => {
        gsap.to(searchInput, { width: '250px', duration: 0.3 });
        gsap.to(searchIcon, { scale: 1.2, duration: 0.3 });
    });

    // Réduit la barre de recherche quand on sort du focus
    searchInput.addEventListener('blur', () => {
        if (searchInput.value === "") {
            gsap.to(searchInput, { width: '0', duration: 0.3 });
            gsap.to(searchIcon, { scale: 1, duration: 0.3 });
        }
    });
});
