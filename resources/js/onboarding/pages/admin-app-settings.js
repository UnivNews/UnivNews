/**
 * Tour steps: Admin — App Settings (admin.app-settings)
 * Penjelasan mendetail untuk tarif publikasi, paket boost, penambahan varian, toggle sakelar aktif, dan proteksi hapus.
 */
const adminAppSettingsSteps = [
  {
    popover: {
      title: '⚙️ Halaman Pengaturan Sistem & Tarif (App Settings)',
      description:
        'Di halaman ini Administrator mengatur parameter finansial portal: biaya penayangan artikel resmi via invoice Mayar.id dan daftar paket promosi Boost Artikel untuk para Author.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="appsettings-publication-fee"]',
    popover: {
      title: '💳 Seksi "Konfigurasi Biaya Publish Artikel"',
      description:
        'Ketikkan nominal biaya tayang artikel pada kolom ini (minimal Rp 1.000). Nominal ini otomatis menjadi tagihan invoice Mayar.id saat artikel seorang Author telah disetujui (<em>Approved</em>).',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="appsettings-fee-status"]',
    popover: {
      title: '📋 Status Konfigurasi Aktif & Pratinjau',
      description:
        'Kotak status ini menampilkan tarif yang sedang aktif saat ini, waktu perubahan terakhir, dan status integrasi payment gateway Mayar.id secara langsung.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="appsettings-boost-prices"]',
    popover: {
      title: '⚡ Tabel Paket Tarif Boost Artikel',
      description:
        'Tabel ini mengatur seluruh varian durasi promosi berita kampus di halaman depan (misal: 3 Hari, 7 Hari, 14 Hari) beserta harganya masing-masing.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="appsettings-add-boost-btn"]',
    popover: {
      title: '➕ Tombol "+ Add" Varian Baru',
      description:
        'Ingin menambah paket baru? Klik tombol <strong>+ Add</strong> di sudut kanan atas tabel. Baris baru akan muncul seketika untuk memasukkan nama durasi, total hari, dan harga.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="appsettings-toggle-switch"]',
    popover: {
      title: '🔘 Sakelar Status Aktif (Toggle Switch)',
      description:
        'Gunakan sakelar tombol geser ini untuk mengaktifkan atau menonaktifkan paket tertentu. Paket yang dinonaktifkan tidak akan terlihat oleh Author di layar pemilihan boost, namun data riwayat transaksi lama tetap aman.',
      side: 'left',
      align: 'center',
    },
  },
  {
    element: '[data-tour="appsettings-delete-boost-btn"]',
    popover: {
      title: '🗑️ Tombol Hapus Varian & Proteksi Keamanan',
      description:
        'Klik ikon tong sampah merah untuk menghapus paket yang tidak lagi digunakan. Sistem dilengkapi modal dialog konfirmasi keamanan: paket yang sedang atau pernah digunakan oleh transaksi boost author tidak dapat dihapus sembarangan.',
      side: 'left',
      align: 'center',
    },
  },
  {
    element: '[data-tour="appsettings-note"]',
    popover: {
      title: '⚠️ Catatan Perubahan Tarif',
      description:
        'Perubahan harga yang disimpan hanya berlaku untuk invoice baru yang dibuat setelah penyimpanan. Tagihan author yang sedang berjalan tidak akan terganggu.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="appsettings-save-btn"]',
    popover: {
      title: '💾 Tombol "Save Settings"',
      description:
        'Setelah menyesuaikan nominal biaya dan paket boost, klik tombol <strong>Save Settings</strong> untuk menyimpan seluruh konfigurasi ke sistem secara permanen.',
      side: 'top',
      align: 'end',
    },
  },
];

export { adminAppSettingsSteps };
