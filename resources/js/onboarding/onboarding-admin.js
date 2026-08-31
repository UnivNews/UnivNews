/**
 * Onboarding tour steps for ADMIN role dashboard.
 * Penjelasan mendetail untuk setiap tombol dan komponen di Command Center Admin.
 */
const adminSteps = [
  {
    popover: {
      title: '👋 Selamat Datang di Admin Command Center!',
      description:
        'Ini adalah <strong>Admin Dashboard</strong> UnivNews — tempat kamu mengontrol seluruh alur publikasi berita, pengajuan author, transaksi pembayaran, dan manajemen universitas. Mari kita pelajari fungsi tiap tombolnya!',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="sidebar-nav"]',
    popover: {
      title: '🗂️ Menu Navigasi Utama Admin (Sidebar)',
      description:
        'Sidebar ini memberikan akses penuh ke seluruh modul aplikasi:<br>' +
        '• <strong>Dashboard</strong>: Metrik platform & antrean artikel.<br>' +
        '• <strong>Articles</strong>: Review, edit, dan publikasi semua berita.<br>' +
        '• <strong>Users / Authors</strong>: Persetujuan dan sanksi penulis.<br>' +
        '• <strong>Universities</strong>: Manajemen direktori universitas.<br>' +
        '• <strong>Payment Settings</strong>: Tarif publikasi & paket boost.<br>' +
        '• <strong>Settings</strong>: Profil & akun administrator.',
      side: 'right',
      align: 'start',
    },
  },
  {
    element: '[data-tour="admin-pending-alert"]',
    popover: {
      title: '🟡 Tombol Badge "Articles Pending Review"',
      description:
        'Badge kuning berkedip ini memberikan notifikasi jumlah artikel yang sedang mengantre untuk ditinjau. Klik tombol ini untuk langsung melompat ke daftar artikel berstatus <strong>Pending Review</strong>!',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="admin-stats"]',
    popover: {
      title: '📊 Ringkasan Metrik Sistem',
      description:
        'Empat indikator utama ini menampilkan performa situs secara menyeluruh:<br>' +
        '1. <strong>Total Articles</strong>: Jumlah artikel yang sudah rilis.<br>' +
        '2. <strong>Total Views</strong>: Total akumulasi pembaca portal.<br>' +
        '3. <strong>Pending Review</strong>: Naskah menanti tindakan persetujuan.<br>' +
        '4. <strong>Active Authors</strong>: Penulis terverifikasi yang aktif.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="admin-chart"]',
    popover: {
      title: '📈 Grafik Tren Publikasi (Publishing Trends)',
      description:
        'Grafik batang ini menyajikan data statistik artikel yang berhasil dipublikasikan tiap bulan dalam 12 bulan terakhir. Arahkan kursor ke tiap batang untuk melihat detail angka persisnya.',
      side: 'top',
      align: 'center',
    },
  },
  {
    element: '[data-tour="admin-articles-table"]',
    popover: {
      title: '📋 Tabel "Recently Added Articles" & Tombol Review',
      description:
        'Daftar artikel yang baru diajukan oleh para author. Untuk artikel yang berstatus <strong>Pending Review</strong>, klik tombol merah <strong>Review</strong> untuk membaca naskah, menyetujui, atau memberikan catatan revisi.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="help-button"]',
    popover: {
      title: '❓ Tombol Bantuan & Replay Tutorial',
      description:
        'Kapan saja kamu butuh memutar kembali panduan antarmuka ini, cukup klik ikon <strong>❓ (Bantuan)</strong> di header atas ini!',
      side: 'bottom',
      align: 'end',
    },
  },
  {
    popover: {
      title: '🎉 Admin Workspace Siap Gunakan!',
      description:
        'Tur ringkas selesai! Selamat bertugas mengelola platform berita kampus UnivNews!',
      side: 'over',
      align: 'center',
    },
  },
];

export { adminSteps };
