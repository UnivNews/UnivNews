/**
 * Tour steps: Author — Settings (author.settings)
 * Penjelasan mendetail untuk kartu profil, form edit biodata, dan reset password.
 */
const authorSettingsSteps = [
  {
    popover: {
      title: '⚙️ Halaman Pengaturan Profil & Akun Author',
      description:
        'Halaman ini berisi identitas akunmu, data profil penulisan publik, serta opsi keamanan akun.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="settings-profile-card"]',
    popover: {
      title: '👤 Kartu Ringkasan Status Akun',
      description:
        'Kartu di sisi kiri ini menampilkan tingkatan peran (Level 2 Author), statistik total artikel dipublikasikan, serta label status verifikasi akunmu.<br><br>' +
        'Di bagian bawah kartu ini juga terdapat tombol <strong>Lihat Tutorial Dashboard</strong> untuk memutar ulang tutorial ini kapan saja!',
      side: 'right',
      align: 'start',
    },
  },
  {
    element: '[data-tour="settings-edit-form"]',
    popover: {
      title: '✏️ Form Edit Informasi Profil & Biografi',
      description:
        'Di kolom ini kamu dapat memperbarui Nama Lengkap, Nama Panggilan (Preferred Name), Nomor Telepon, Departemen/Fakultas, serta menuliskan <strong>Author Bio</strong>. Bio ini akan muncul di kartu profil penulis di bawah setiap berita yang kamu terbitkan.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="settings-password"]',
    popover: {
      title: '🔒 Opsi Keamanan & Reset Password',
      description:
        'Jika kamu ingin mengubah kata sandi akunmu, klik tombol <strong>Reset Password</strong>. Sistem akan mengirimkan link instruksi penggantian password langsung ke email terdaftarmu.',
      side: 'left',
      align: 'start',
    },
  },
];

export { authorSettingsSteps };
