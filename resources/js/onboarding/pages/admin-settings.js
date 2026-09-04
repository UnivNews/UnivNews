/**
 * Tour steps: Admin — Settings (admin.settings)
 * Penjelasan mendetail untuk profil admin, tautan jejaring sosial, perbaruan data, dan kata sandi.
 */
const adminSettingsSteps = [
  {
    popover: {
      title: '⚙️ Halaman Pengaturan Akun Administrator',
      description:
        'Halaman ini berisi konfigurasi identitas pribadi akun Admin, foto profil, jejaring sosial, dan penggantian password.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="settings-profile-card"]',
    popover: {
      title: '👤 Kartu Ringkasan Admin & Jejaring Sosial',
      description:
        'Kartu ini menyajikan foto avatar, nama, email, peranan (Administrator Level 4), serta tautan jejaring sosial (Instagram, X/Twitter, Threads, LinkedIn).<br><br>' +
        'Gunakan tombol <strong>Lihat Tutorial Dashboard</strong> di bagian bawah kartu untuk memutar ulang panduan antarmuka ini!',
      side: 'right',
      align: 'start',
    },
  },
  {
    element: '[data-tour="settings-edit-form"]',
    popover: {
      title: '✏️ Form Perbarui Data Admin',
      description:
        'Lengkapi nama lengkap, nama panggilan, email resmi, nomor WhatsApp, serta tautan jejaring sosial di kolom ini. Jangan lupa menekan tombol <strong>Save Changes</strong> untuk menyimpan.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="settings-password"]',
    popover: {
      title: '🔐 Form Penggantian Password Admin',
      description:
        'Untuk menjaga keamanan akun administrator, isi password lama dan password baru pada form ini lalu tekan tombol <strong>Update Password</strong>.',
      side: 'left',
      align: 'start',
    },
  },
];

export { adminSettingsSteps };
