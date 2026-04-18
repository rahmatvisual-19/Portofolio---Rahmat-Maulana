import './bootstrap';
import Lenis from 'lenis';

/**
 * Inisialisasi Lenis (Smooth Scroll)
 * Ini akan memberikan efek scrolling yang halus seperti pada website Perry Wang.
 */
const lenis = new Lenis({
    duration: 1.2,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    smoothWheel: true,
    orientation: 'vertical',
    gestureOrientation: 'vertical',
});

// Loop animasi untuk Lenis
function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
}

requestAnimationFrame(raf);

// Export lenis agar bisa diakses secara global jika diperlukan di file Blade
window.lenis = lenis;

console.log('Sweety Portfolio: JS Global Berhasil Dimuat');