/**
 * Tour steps: Author — Articles List (author.articles.index)
 * Penjelasan mendetail untuk setiap tombol dan aksi pada halaman Daftar Artikel Author.
 */
const authorArticlesIndexSteps = [
  {
    popover: {
      title: '📋 Halaman Kelola Artikel (Author Desk)',
      description:
        'Halaman ini berisi daftar seluruh berita dan artikel yang pernah kamu buat. Di sini kamu bisa menyaring status, mencari judul, mengedit draft, melakukan pembayarannya, atau mengaktifkan fitur Boost.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="articles-write-btn"]',
    popover: {
      title: '✏️ Tombol "+ Write New Article"',
      description:
        'Klik tombol merah ini untuk membuka form pembuatan artikel baru. Kamu bisa mengunggah cover, memilih kategori (seperti Events, Research, Campus Life), dan menyusun naskah.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="articles-status-tabs"]',
    popover: {
      title: '🗂️ Tab Filter Status Artikel',
      description:
        'Klik tab-tab ini untuk memfilter daftar artikel:<br>' +
        '• <strong>All Stories</strong>: Semua artikel milikmu.<br>' +
        '• <strong>Under Review</strong>: Menunggu persetujuan editor.<br>' +
        '• <strong>Published</strong>: Artikel yang sudah tayang di publik.<br>' +
        '• <strong>Drafts</strong>: Artikel yang belum kamu kirim.<br>' +
        '• <strong>Requires Revision</strong>: Artikel yang ditolak editor dan perlu kamu perbaiki.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="articles-search-bar"]',
    popover: {
      title: '🔍 Bar Pencarian & Tombol Reset',
      description:
        'Ketik kata kunci judul artikel pada kotak pencarian ini lalu tekan Enter. Jika ingin mengembalikan tampilan awal, klik tombol <strong>Reset</strong>.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="articles-table"]',
    popover: {
      title: '📊 Tabel Artikel & Tombol Aksi (Actions)',
      description:
        'Setiap baris artikel memiliki tombol aksi di sebelah kanan:<br>' +
        '• <strong>Edit</strong>: Buka form untuk memperbarui isi naskah / merespon feedback.<br>' +
        '• <strong>Pay Now</strong>: Lakukan pembayaran publikasi jika artikel sudah disetujui.<br>' +
        '• <strong>⚡ Boost</strong>: Promosikan artikel published kamu ke halaman utama portal.<br>' +
        '• <strong>View Live</strong>: Buka tampilan publik artikel di tab baru.',
      side: 'top',
      align: 'start',
    },
  },
];

export { authorArticlesIndexSteps };
