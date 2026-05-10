/* ══════════════════════════════════════════════════════════
   StudentSys — Landing Page Scripts
   Terminal Assessment 2 · CodeIgniter 4
   Requires: GSAP 3.12.2 + ScrollTrigger (loaded in HTML)
   ══════════════════════════════════════════════════════════ */

gsap.registerPlugin(ScrollTrigger);

/* ──────────────────────────────────────────
   Custom Cursor
   ────────────────────────────────────────── */
const cursor = document.getElementById('cursor');

document.addEventListener('mousemove', e => {
    cursor.style.left = e.clientX + 'px';
    cursor.style.top  = e.clientY + 'px';
});

document.querySelectorAll('a, button').forEach(el => {
    el.addEventListener('mouseenter', () => cursor.classList.add('grow'));
    el.addEventListener('mouseleave', () => cursor.classList.remove('grow'));
});

/* ──────────────────────────────────────────
   Navbar — toggle classes on scroll
   ────────────────────────────────────────── */
const nav = document.getElementById('mainNav');

window.addEventListener('scroll', () => {
    const pastHero = window.scrollY > window.innerHeight * 0.9;
    nav.classList.toggle('scrolled', pastHero);
    nav.classList.toggle('on-hero',  !pastHero);
});

/* ══════════════════════════════════════════════════════════
   GSAP SCROLL SEQUENCE
   Scrubs 0 → 1 over the full 600vh .master container.
   Ported from CIAuth; adapted to StudentSys editorial style.
   ══════════════════════════════════════════════════════════ */
const tl = gsap.timeline({
    scrollTrigger: {
        trigger: '.master',
        start:   'top top',
        end:     'bottom bottom',
        scrub:   1.5,
    }
});

// Step 0 — Subtle image zoom as scroll begins
tl.to('#mainImg', {
    scale:    1.1,
    duration: 0.3,
    ease:     'none'
})

// Step 1 — Fade in cinematic overlays; fade out hero text
.to('#imgOverlay',   { opacity: 1, duration: 0.4 }, 0.1)
.to('#imgGrid',      { opacity: 1, duration: 0.4 }, 0.1)
.to('#imgScanlines', { opacity: 1, duration: 0.3 }, 0.2)
.to('#phase1',       { opacity: 0, y: -50, duration: 0.5, ease: 'power2.in' }, 0.2)

// Step 2 — THE MAGIC: fullscreen image collapses to a portrait card
//           Square corners kept for editorial/brutalist feel
.to('#imgWrap', {
    borderRadius: '0px',
    width:        '340px',
    height:       '480px',
    top:          '50%',
    left:         '50%',
    xPercent:     -50,
    yPercent:     -50,
    duration:     1.8,
    ease:         'expo.inOut',
    boxShadow:    '0 60px 120px rgba(0,0,0,0.95), 0 0 0 2px rgba(200,64,42,0.4)'
}, 0.5)

// Step 3 — Background word swells
.to('#bgWord', {
    scale:    1.18,
    opacity:  0.12,
    duration: 1
}, 0.8)

// Step 4 — Slide card to the left; reveal stats panel as it settles
.to('#imgWrap', {
    left:     '8%',
    xPercent: 0,
    duration: 1.2,
    ease:     'expo.inOut',
    onUpdate: function () {
        const prog = this.progress();
        document.getElementById('cardStats').style.opacity =
            prog > 0.5 ? (prog - 0.5) * 2 : 0;
    }
}, 1.5)

// Step 5 — Reveal card-phase container
.to('#phase2', {
    opacity:  1,
    y:        0,
    duration: 0.8,
    ease:     'power3.out'
}, 2.0)

// Step 6 — Slide in the description text from the right
.to('#cardText', {
    opacity:  1,
    x:        0,
    duration: 0.9,
    ease:     'power3.out'
}, 2.3);

/* ──────────────────────────────────────────
   Intersection Observer — scroll reveal
   for features, roles, and security items
   ────────────────────────────────────────── */
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

document.querySelectorAll('.feature-col, .role-card, .sec-item')
        .forEach(el => revealObserver.observe(el));

/* ──────────────────────────────────────────
   Marquee — pause on hover
   ────────────────────────────────────────── */
const marqueeTrack = document.getElementById('marqueeTrack');
if (marqueeTrack) {
    marqueeTrack.addEventListener('mouseenter', () => {
        marqueeTrack.style.animationPlayState = 'paused';
    });
    marqueeTrack.addEventListener('mouseleave', () => {
        marqueeTrack.style.animationPlayState = 'running';
    });
}

/* ──────────────────────────────────────────
   Role cards — 3D perspective tilt on hover
   ────────────────────────────────────────── */
document.querySelectorAll('.role-card').forEach(card => {
    card.addEventListener('mousemove', e => {
        const r = card.getBoundingClientRect();
        const x = ((e.clientX - r.left)  / r.width  - 0.5) * 6;
        const y = ((e.clientY - r.top)   / r.height - 0.5) * 6;
        card.style.transform  = `perspective(600px) rotateY(${x}deg) rotateX(${-y}deg)`;
        card.style.transition = 'transform .1s ease';
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform  = 'perspective(600px) rotateY(0) rotateX(0)';
        card.style.transition = 'transform .4s ease';
    });
});

/* ──────────────────────────────────────────
   Smooth scroll for anchor links
   ────────────────────────────────────────── */
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});