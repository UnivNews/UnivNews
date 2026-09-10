/**
 * Onboarding tour steps for ADMIN role dashboard.
 * Penjelasan komprehensif untuk seluruh fitur, menu navigasi, dan komponen di Command Center Admin.
 */
const adminSteps = [
  {
    popover: {
      title: '👋 Selamat Datang di Admin Command Center!',
      description:
        'Ini adalah <strong>Admin Dashboard</strong> UnivNews — pusat kendali utama untuk mengelola penerbitan berita, pengajuan penulis (author), konfigurasi pembayaran Mayar, keamanan sesi perangkat, serta konten situs portal. Mari kita pelajari seluruh fitur barunya!',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="sidebar-nav"]',
    popover: {
      title: '🗂️ Menu Navigasi Utama Admin (Sidebar)',
      description:
        'Sidebar ini memberikan akses penuh ke semua modul sistem UnivNews:<br>' +
        '• <strong>Dashboard</strong>: Ringkasan metrik analitik & artikel terbaru.<br>' +
        '• <strong>Articles</strong>: Kelola arsip berita, peninjauan naskah, dan persetujuan.<br>' +
        '• <strong>Users / Authors</strong>: Verifikasi calon penulis kampus & sanksi suspend.<br>' +
        '• <strong>Universities</strong>: Direktori institusi universitas mitra.<br>' +
        '• <strong>Site Content</strong>: Kelola halaman publik (About Us, FAQ, Contact, Privacy).<br>' +
        '• <strong>Settings</strong>:<br>' +
        '&nbsp;&nbsp;&bull; <em>Profile</em>: Data identitas, tautan medsos, dan sandi.<br>' +
        '&nbsp;&nbsp;&bull; <em>Payment Settings</em>: Tarif publikasi artikel & konfigurasi paket boost.<br>' +
        '&nbsp;&nbsp;&bull; <em>Active Sessions Settings</em>: Pemantauan login perangkat & GPS live.',
      side: 'right',
      align: 'start',
    },
  },
  {
    element: '[data-tour="admin-create-article-btn"]',
    popover: {
      title: '✍️ Tombol "+ Create New Article"',
      description:
        'Administrator dapat langsung menulis dan menerbitkan berita resmi redaksi kampus secara instan tanpa perlu melewati antrean peninjauan atau proses pembayaran.',
      side: 'bottom',
      align: 'end',
    },
  },
  {
    element: '[data-tour="admin-pending-alert"]',
    popover: {
      title: '🟡 Notifikasi "Articles Pending Review"',
      description:
        'Badge kuning berkedip ini menandakan adanya naskah berita dari Author yang sedang mengantre untuk dinilai. Klik tombol ini untuk langsung menuju daftar naskah <strong>Pending Review</strong>.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="admin-stats"]',
    popover: {
      title: '📊 Ringkasan Metrik Sistem Real-Time',
      description:
        'Empat kartu statistik utama ini memperlihatkan performa platform secara langsung:<br>' +
        '1. <strong>Total Articles</strong>: Akumulasi seluruh berita yang aktif terbit.<br>' +
        '2. <strong>Total Views</strong>: Total pembaca portal dari seluruh berita.<br>' +
        '3. <strong>Pending</strong>: Naskah yang menunggu evaluasi dan persetujuanmu.<br>' +
        '4. <strong>Active Authors</strong>: Jumlah kontributor penulis kampus yang terverifikasi.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="admin-chart"]',
    popover: {
      title: '📈 Grafik Tren Publikasi (Publishing Trends)',
      description:
        'Grafik batang interaktif ini memvisualisasikan volume berita yang terbit per bulan dalam 12 bulan terakhir. Arahkan kursor ke tiap batang untuk melihat angka persisnya.',
      side: 'top',
      align: 'center',
    },
  },
  {
    element: '[data-tour="admin-articles-table"]',
    popover: {
      title: '📋 Antrean Artikel Terbaru & Tombol Review',
      description:
        'Tabel ini memuat pengajuan naskah berita terkini. Untuk artikel berstatus <strong>Pending Review</strong>, klik tombol <strong>Review</strong> untuk masuk ke ruang evaluasi: membaca isi naskah, menyetujui jadwal terbit, atau menolak dengan catatan revisi.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="help-button"]',
    popover: {
      title: '❓ Tombol Bantuan & Replay Tutorial',
      description:
        'Kapan saja kamu butuh memutar kembali panduan ini di halaman manapun, cukup klik ikon <strong>❓ (Bantuan)</strong> di sudut kanan atas header!',
      side: 'bottom',
      align: 'end',
    },
  },
  {
    popover: {
      title: '🎉 Admin Workspace Siap Digunakan!',
      description:
        'Tur panduan dashboard telah selesai! Selamat bertugas mengawal kualitas informasi kampus di UnivNews!',
      side: 'over',
      align: 'center',
    },
  },
];

export { adminSteps };
