/**
 * Tour steps: Admin — Universities (admin.universities.index)
 * Penjelasan mendetail untuk pengelolaan direktori institusi universitas.
 */
const adminUniversitiesIndexSteps = [
  {
    popover: {
      title: '🏫 Halaman Direktori Universitas',
      description:
        'Halaman ini berisi daftar institusi perguruan tinggi yang terdaftar di portal UnivNews. Nama-nama universitas ini menjadi pilihan wajib saat calon Author mendaftar.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="universities-add-btn"]',
    popover: {
      title: '➕ Tombol "+ Add University"',
      description:
        'Klik tombol merah ini untuk membuka modal penambahan universitas baru. Kamu dapat memasukkan Nama Lengkap Institusi (misal: <em>Universitas Gadjah Mada</em>) dan Singkatan Kode (misal: <em>UGM</em>).',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="universities-list"]',
    popover: {
      title: '📋 Tabel Daftar Universitas',
      description:
        'Menampilkan nama universitas, kode singkatan, jumlah pengguna terdaftar dari kampus tersebut, serta tanggal didaftarkan.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="universities-delete-btn"]',
    popover: {
      title: '🗑️ Tombol Aksi "Delete"',
      description:
        'Klik tombol merah <strong>Delete</strong> untuk menghapus institusi dari direktori jika sudah tidak bermitra. Catatan: Universitas yang telah memiliki author terdaftar tidak dapat dihapus.',
      side: 'left',
      align: 'start',
    },
  },
];

export { adminUniversitiesIndexSteps };
