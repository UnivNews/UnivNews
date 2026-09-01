/**
 * Tour steps: Author — Boost Article (author.articles.boost)
 * Penjelasan mendetail untuk pemilihan durasi, pengecekan slot ketersediaan, dan pengajuan boost.
 */
const authorArticlesBoostSteps = [
  {
    popover: {
      title: '⚡ Halaman Promosi & Boost Artikel',
      description:
        'Fitur Boost memungkinkan artikel beritamu tampil menonjol di halaman depan (Home Featured Slot) portal UnivNews. Mari pelajari cara mengonfigurasinya!',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="boost-duration"]',
    popover: {
      title: '⏱️ Langkah 1: Pilih Kartu Durasi Boost',
      description:
        'Pilih salah satu opsi durasi penayangan yang tersedia (misalnya: 3 Hari, 7 Hari, atau 14 Hari). Rincian tarif dan durasi tertera jelas pada tiap kartu.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="boost-date"]',
    popover: {
      title: '📅 Langkah 2: Tentukan Tanggal Mulai Boost',
      description:
        'Pilih tanggal kapan penayangan boost dimulai. Perlu diingat bahwa slot terbatas (maksimal 5 artikel yang di-boost per hari) demi menjaga eksklusivitas penayangan.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="boost-availability"]',
    popover: {
      title: '✅ Kotak Pratinjau Ketersediaan Slot Real-Time',
      description:
        'Setelah kamu memilih tanggal dan durasi, sistem akan memeriksa otomatis ketersediaan slot. Jika slot masih tersedia, tombol pembayaran akan aktif secara otomatis.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="boost-submit"]',
    popover: {
      title: '💳 Tombol "Lanjut Pembayaran"',
      description:
        'Klik tombol merah ini untuk melanjutkan ke proses pembayaran resmi via Payment Gateway (Mayar.id). Setelah pembayaran terverifikasi, artikelmu akan langsung terjadwal di posisi Boost!',
      side: 'top',
      align: 'end',
    },
  },
];

export { authorArticlesBoostSteps };
