/**
 * Tour steps: Admin — App Settings (admin.app-settings)
 * Penjelasan mendetail untuk tarif publikasi, paket boost, penambahan opsi boost, dan tombol simpan.
 */
const adminAppSettingsSteps = [
  {
    popover: {
      title: '⚙️ Halaman Pengaturan Sistem & Tarif (App Settings)',
      description:
        'Di halaman ini Administrator mengatur parameter finansial portal: besaran biaya penayangan artikel berita dan daftar paket tarif Boost Artikel.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="appsettings-publication-fee"]',
    popover: {
      title: '💳 Seksi "Konfigurasi Pembayaran & Biaya Publish"',
      description:
        'Ketikkan nominal rupiah biaya publish artikel pada kolom input angka. Nominal ini merupakan tarif resmi per artikel yang ditagihkan ke Author via invoice Mayar.id setelah naskah mereka disetujui.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="appsettings-boost-prices"]',
    popover: {
      title: '⚡ Seksi "Paket Tarif Boost Artikel"',
      description:
        'Tabel ini mengatur durasi dan biaya paket promosi boost (misalnya: 3 Hari = Rp 50.000, 7 Hari = Rp 100.000). Kamu dapat menambah varian durasi baru dengan mengklik tombol <strong>+ Tambah Varian Boost</strong> di kanan atas tabel.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="appsettings-save-btn"]',
    popover: {
      title: '💾 Tombol "Simpan Pengaturan"',
      description:
        'Setelah melakukan penyesuaian biaya, klik tombol <strong>Simpan Pengaturan</strong>. Perubahan biaya akan langsung berlaku untuk transaksi invoice baru.',
      side: 'top',
      align: 'end',
    },
  },
];

export { adminAppSettingsSteps };
