/**
 * Tour steps: Admin — Articles List (admin.articles.index)
 * Penjelasan mendetail untuk filter status, pencarian, dan tombol aksi (Review vs Edit).
 */
const adminArticlesIndexSteps = [
  {
    popover: {
      title: '📰 Halaman Manajemen Berita & Artikel (Admin)',
      description:
        'Halaman ini berisi daftar seluruh berita dari semua author di seluruh universitas. Admin dapat memantau status publikasi, memeriksa pengajuan, dan mengedit konten.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="admin-articles-new-btn"]',
    popover: {
      title: '➕ Tombol "+ New Article"',
      description:
        'Sebagai admin, kamu juga dapat menulis dan menerbitkan artikel redaksi secara langsung tanpa melalui alur pengajuan author.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="admin-articles-tabs"]',
    popover: {
      title: '🗂️ Tab Filter Status Artikel Redaksi',
      description:
        'Gunakan tab ini untuk menyaring artikel:<br>' +
        '• <strong>All Articles</strong>: Seluruh arsip berita.<br>' +
        '• <span style="color:#b45309;font-weight:bold;">Pending Review</span>: Prioritas utama! Naskah menunggu persetujuanmu.<br>' +
        '• <strong>Published</strong>: Artikel yang sedang tayang.<br>' +
        '• <strong>Awaiting Payment</strong>: Artikel disetujui yang menunggu pembayaran author.<br>' +
        '• <strong>Drafts & Rejected</strong>: Naskah draf atau yang dikembalikan.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="admin-articles-search"]',
    popover: {
      title: '🔍 Pencarian Kata Kunci & Filter Kategori',
      description:
        'Ketik kata kunci judul atau nama penulis di bar pencarian, atau pilih kategori dari dropdown untuk mempersempit hasil pencarian.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="admin-articles-table"]',
    popover: {
      title: '📋 Tabel Artikel & Tombol Aksi (Actions)',
      description:
        'Perhatikan tombol pada kolom paling kanan (Actions):<br>' +
        '• <strong>Review</strong> (Warna Merah): Tombol khusus pada naskah <em>Pending Review</em> untuk masuk ke layar penilaian artikel.<br>' +
        '• <strong>Edit</strong>: Mengubah naskah atau metadata artikel yang sudah terbit.<br>' +
        '• <strong>Delete</strong>: Menghapus artikel dari sistem.',
      side: 'top',
      align: 'start',
    },
  },
];

export { adminArticlesIndexSteps };
