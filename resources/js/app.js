import './bootstrap';
import Lenis from 'lenis';

/**
 * 1. INISIALISASI LENIS (SMOOTH SCROLL)
 */
const lenis = new Lenis({
    duration: 1.2,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    smoothWheel: true,
    orientation: 'vertical',
    gestureOrientation: 'vertical',
});

function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
}

requestAnimationFrame(raf);
window.lenis = lenis;

/**
 * 2. GLOBAL UI LOGIC (Kursor & Animasi Reveal)
 * Kita membungkusnya dalam DOMContentLoaded agar dieksekusi setelah HTML selesai dimuat.
 */
document.addEventListener('DOMContentLoaded', () => {

    // --- A. Minecraft Cursor & Glow Logic ---
    const cursor = document.getElementById('minecraft-cursor');
    const glow = document.getElementById('cursor-glow');
    
    // Pastikan elemen kursor ada di halaman sebelum menjalankan animasi
    if (cursor && glow) {
        let targetX = 0, targetY = 0, currentX = 0, currentY = 0, glowX = 0, glowY = 0;

        document.addEventListener('mousemove', (e) => {
            targetX = e.clientX; 
            targetY = e.clientY;
            createParticle(e.clientX, e.clientY);
        });

        function createParticle(x, y) {
            // Mengurangi partikel di mobile untuk menghemat performa
            if(window.innerWidth < 768 && Math.random() > 0.3) return; 

            const particle = document.createElement('div');
            particle.classList.add('particle');
            const size = Math.random() * 8 + 4;
            particle.style.width = `${size}px`; 
            particle.style.height = `${size}px`;
            
            // Random warna biru atau ungu
            particle.style.background = Math.random() > 0.5 
                ? 'radial-gradient(circle, #fff 0%, rgba(59, 130, 246, 0.8) 60%, transparent 100%)' 
                : 'radial-gradient(circle, #fff 0%, rgba(139, 92, 246, 0.8) 60%, transparent 100%)';
                
            particle.style.left = (x + (Math.random() - 0.5) * 12) + 'px'; 
            particle.style.top = (y + (Math.random() - 0.5) * 12) + 'px';
            document.body.appendChild(particle);
            
            setTimeout(() => particle.remove(), 800);
        }

        const animateCursor = () => {
            currentX += (targetX - currentX) * 0.2; 
            currentY += (targetY - currentY) * 0.2;
            glowX += (targetX - glowX) * 0.1; 
            glowY += (targetY - glowY) * 0.1;
            
            cursor.style.left = `${currentX}px`; 
            cursor.style.top = `${currentY}px`;
            glow.style.left = `${glowX}px`; 
            glow.style.top = `${glowY}px`;
            
            requestAnimationFrame(animateCursor);
        };
        animateCursor();
    }

    // --- B. Reveal Observer Logic (Animasi Scroll) ---
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => { 
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            } 
        });
    }, { 
        threshold: 0.1, 
        rootMargin: '0px 0px -50px 0px' 
    });

    // Cari semua elemen dengan class 'reveal' dan pantau saat di-scroll
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

});

console.log('Sweety Portfolio: JS Global Berhasil Dimuat');