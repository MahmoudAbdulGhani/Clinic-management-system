document.addEventListener("DOMContentLoaded", function () {
    // Smooth scrolling
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId.startsWith("#")) {
                e.preventDefault();
                const target = document.querySelector(targetId);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });

    // Active link on scroll
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav-link');

    window.addEventListener("scroll", () => {
        const scrollPos = window.scrollY + 200;

        let currentId = "";
        sections.forEach(section => {
            if (
                scrollPos >= section.offsetTop &&
                scrollPos < section.offsetTop + section.offsetHeight
            ) {
                currentId = section.id;
            }
        });

        navLinks.forEach(link => {
            link.classList.remove("active");
            if (link.getAttribute("href") === `#${currentId}`) {
                link.classList.add("active");
            }
        });

        if (window.scrollY === 0) {
            navLinks.forEach(link => link.classList.remove('active'));
            document.querySelector('.nav-link[href="#welcome"]')?.classList.add('active');
        }
    });
});