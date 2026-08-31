/**
 * Tour steps: Admin — Authors Management (admin.authors.index)
 * Penjelasan mendetail untuk manajemen penulis: verifikasi pendaftaran, modal detail, approve, dan suspend.
 */
const adminAuthorsIndexSteps = [
  {
    popover: {
      title: '👥 Halaman Manajemen Author & Penulis Kampus',
      description:
        'Halaman ini digunakan untuk mengelola hak akses seluruh kontributor dan penulis berita kampus di UnivNews.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="authors-pending-section"]',
    popover: {
      title: '🟡 Kartu "Pending Author Applications"',
      description:
        'Seksi ini menampilkan calon penulis yang baru mendaftar dan menunggu verifikasi Admin. Badge kuning berkedip menandakan adanya pengajuan baru.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="authors-approve-btn"]',
    popover: {
      title: '✅ Tombol "Approve" & "Detail"',
      description:
        '• <strong>Detail</strong>: Membuka jendela pop-up untuk membaca biodata lengkap, fakultas, dan alasan pendaftaran calon author.<br>' +
        '• <strong>Approve</strong>: Menyetujui pendaftaran. Calon author akan mendapatkan hak akses penuh ke Author Dashboard dan notifikasi email.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="authors-active-section"]',
    popover: {
      title: '✍️ Tabel "Active Authors & Contributors"',
      description:
        'Tabel ini mencantumkan seluruh penulis terverifikasi beserta asal universitas, departemen, serta jumlah artikel yang pernah mereka buat.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="authors-suspend-btn"]',
    popover: {
      title: '⚠️ Tombol Aksi "Suspend" / "Unsuspend"',
      description:
        '• <strong>Suspend</strong>: Membekukan akun author yang melanggar aturan etik jurnalistik sehingga tidak dapat menulis berita baru.<br>' +
        '• <strong>Unsuspend</strong>: Memulihkan kembali hak akses penulis yang telah dibekukan.',
      side: 'left',
      align: 'start',
    },
  },
];

export { adminAuthorsIndexSteps };
