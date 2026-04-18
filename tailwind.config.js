export default {
  theme: {
    extend: {
      colors: {
        'perry-dark': '#0b0b0b', // Latar belakang hitam pekat
        'perry-gray': '#a1a1a1', // Untuk teks sekunder
      },
      fontFamily: {
        'display': ['Inter', 'sans-serif'], // Atau pakai 'Satoshi' jika ada
      },
      fontSize: {
        'huge': 'clamp(2rem, 10vw, 8rem)', // Untuk teks judul yang sangat besar
      }
    },
  },
}