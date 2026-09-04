/**
 * Onboarding tour steps for AUTHOR role dashboard.
 * Penjelasan mendetail untuk setiap tombol dan komponen di Dashboard Author.
 */
const authorSteps = [
  {
    popover: {
      title: '👋 Selamat Datang di Author Workspace!',
      description:
        'Ini adalah <strong>Author Dashboard</strong> kamu — pusat kendali untuk menulis, mengelola, dan memantau seluruh artikel kampusmu. Yuk pelajari fungsi dari setiap tombol dan widget yang ada!',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="sidebar-nav"]',
    popover: {
      title: '🗂️ Menu Navigasi Utama (Sidebar)',
      description:
        'Sidebar ini adalah navigasi utama kamu:<br>' +
        '• <strong>Dashboard</strong>: Ringkasan statistik & artikel terbaru.<br>' +
        '• <strong>Articles</strong>: Daftar seluruh artikelmu (Draft, Review, Published).<br>' +
        '• <strong>Settings</strong>: Pengaturan profil, bio, dan password.',
      side: 'right',
      align: 'start',
    },
  },
  {
    element: '[data-tour="author-new-article"]',
    popover: {
      title: '✏️ Tombol "Write New Article"',
      description:
        'Klik tombol hitam <strong>+ Write New Article</strong> ini untuk membuat berita atau artikel baru. Kamu akan diarahkan ke form editor lengkap tempat mengisi judul, konten, gambar cover, dan kategori.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="author-stats"]',
    popover: {
      title: '📊 Kartu Statistik Performa',
      description:
        'Empat kartu ini menampilkan statistik real-time artikelmu:<br>' +
        '1. <strong>Total Stories</strong>: Jumlah keseluruhan artikel yang kamu buat.<br>' +
        '2. <strong>Total Readers</strong>: Akumulasi jumlah pembaca artikelmu.<br>' +
        '3. <strong>Under Review</strong>: Artikel yang sedang ditinjau oleh tim redaksi.<br>' +
        '4. <strong>Live Articles</strong>: Artikel yang sudah berhasil terbit di portal publik.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="author-recent-table"]',
    popover: {
      title: '📋 Tabel "My Recent Stories"',
      description:
        'Daftar artikel terbaru yang kamu buat. Di sini kamu bisa langsung melihat status tiap artikel:<br>' +
        '• <span style="color:#059669;font-weight:bold;">Published</span>: Artikel sudah tayang.<br>' +
        '• <span style="color:#d97706;font-weight:bold;">Pending Review</span>: Sedang dinilai redaksi.<br>' +
        '• <span style="color:#dc2626;font-weight:bold;">Rejected</span>: Butuh revisi (baca <em>Editor Feedback</em>).<br>' +
        '• <strong>Draft</strong>: Belum disubmit.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="author-articles-link"]',
    popover: {
      title: '💳 Alur Pembayaran & Boost Artikel',
      description:
        'Setelah artikelmu disetujui editor (status <em>Awaiting Payment</em>), buka menu <strong>Articles</strong> di sidebar untuk menyelesaikan pembayaran publikasi atau melakukan <strong>Boost Artikel</strong> agar tampil di halaman depan portal!',
      side: 'right',
      align: 'start',
    },
  },
  {
    element: '[data-tour="help-button"]',
    popover: {
      title: '❓ Tombol "Bantuan & Replay Tutorial"',
      description:
        'Kapan pun kamu lupa fungsi tombol di halaman ini, klik ikon <strong>❓ (Bantuan)</strong> di sudut kanan atas header ini untuk memutar ulang tutorial dashboard!',
      side: 'bottom',
      align: 'end',
    },
  },
  {
    popover: {
      title: '🎉 Kamu Siap Berkarya!',
      description:
        'Tutorial Dashboard selesai! Sekarang kamu bisa mulai menulis artikel kampus pertama kamu. Selamat berkarya!',
      side: 'over',
      align: 'center',
    },
  },
];

export { authorSteps };
