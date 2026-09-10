/**
 * Tour steps: Admin — Settings (admin.settings)
 * Penjelasan mendetail untuk profil admin, tautan jejaring sosial, perbaruan data, tombol replay panduan, dan kata sandi.
 */
const adminSettingsSteps = [
  {
    popover: {
      title: '⚙️ Halaman Pengaturan Akun Administrator',
      description:
        'Halaman ini memuat konfigurasi profil pribadi akun Administrator, foto avatar, kontak resmi, tautan jejaring sosial kampus, pemutaran ulang panduan, serta manajemen kata sandi.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="settings-profile-card"]',
    popover: {
      title: '👤 Kartu Ringkasan Akun Administrator',
      description:
        'Menampilkan foto identitas, nama lengkap, lencana peran Level 4 (Admin), serta ikon jejaring sosial resmi (Instagram, X/Twitter, Threads, LinkedIn).',
      side: 'right',
      align: 'start',
    },
  },
  {
    element: '[data-tour="settings-tutorial-replay"]',
    popover: {
      title: '▶️ Tombol "Lihat Tutorial Dashboard"',
      description:
        'Jika sewaktu-waktu ingin mengingat kembali fungsi-fungsi sistem UnivNews, klik tombol ini untuk memutar kembali seluruh rangkaian panduan antarmuka secara interaktif.',
      side: 'top',
      align: 'center',
    },
  },
  {
    element: '[data-tour="settings-edit-form"]',
    popover: {
      title: '✏️ Form Perbarui Data Admin',
      description:
        'Sesuaikan nama lengkap, nama panggilan, nomor telepon dinas, serta username akun media sosialmu. Klik <strong>Save Changes</strong> untuk menyimpan pembaruan profil.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="settings-password"]',
    popover: {
      title: '🔐 Form Keamanan & Kata Sandi',
      description:
        'Perbarui password secara berkala untuk menjaga keamanan portal redaksi kampus. Masukkan password saat ini diikuti password baru yang kuat, lalu tekan <strong>Update Password</strong>.',
      side: 'left',
      align: 'start',
    },
  },
];

export { adminSettingsSteps };
