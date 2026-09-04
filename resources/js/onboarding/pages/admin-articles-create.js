/**
 * Tour steps: Admin — Create Article (admin.articles.create)
 * Penjelasan mendetail untuk form penulisan artikel versi admin.
 */
const adminArticlesCreateSteps = [
  {
    popover: {
      title: '✍️ Form Pembuatan Artikel Redaksi (Admin)',
      description:
        'Halaman ini memungkinkan Administrator menerbitkan berita atau pengumuman resmi kampus secara langsung tanpa melalui tahapan pembayaran atau persetujuan.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="create-title"]',
    popover: {
      title: '📝 Input Judul Berita',
      description:
        'Tuliskan judul berita utama yang menarik dan sesuai pedoman jurnalistik.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-excerpt"]',
    popover: {
      title: '📄 Input Ringkasan (Excerpt)',
      description:
        'Ringkasan naskah yang akan menjadi deskripsi pratinjau berita di portal publik dan mesin pencari (SEO).',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-content-editor"]',
    popover: {
      title: '📖 Editor Konten & Toolbar Formatting',
      description:
        'Susun naskah beritamu di sini. Manfaatkan toolbar di bagian atas untuk mengatur penekanan teks (Bold, Italic, Underline), kutipan narasumber, dan sub-judul.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-publish-box"]',
    popover: {
      title: '🚀 Opsi Publikasi Langsung',
      description:
        '• <strong>Publish Now</strong>: Langsung menerbitkan artikel ke portal publik secara instan.<br>' +
        '• <strong>Save Draft</strong>: Menyimpan naskah di draf internal redaksi.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-categories"]',
    popover: {
      title: '🏷️ Pemilihan Kategori',
      description:
        'Tentukan kategori artikel. Jika memilih <em>Events</em>, kamu dapat mengisi tanggal penyelenggaraan dan sub-tipe acara.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-cover-image"]',
    popover: {
      title: '🖼️ Pengunggah Foto Header (Cover Image)',
      description:
        'Unggah foto berita berkualitas tinggi. Resolusi yang direkomendasikan adalah 1200×630 pixel.',
      side: 'left',
      align: 'start',
    },
  },
];

export { adminArticlesCreateSteps };
