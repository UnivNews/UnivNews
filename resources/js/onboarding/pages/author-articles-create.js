/**
 * Tour steps: Author — Create New Article (author.articles.create)
 * Penjelasan mendetail untuk setiap field, toolbar, tombol submit, dan uploader gambar.
 */
const authorArticlesCreateSteps = [
  {
    popover: {
      title: '✍️ Form Penulisan Artikel Baru',
      description:
        'Di halaman ini kamu dapat menyusun naskah artikel berita kampusmu secara lengkap. Mari kita bedah setiap tombol dan kolom yang tersedia!',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="create-title"]',
    popover: {
      title: '📝 Input Judul Artikel (Title)',
      description:
        'Ketik judul artikel yang menarik di kolom ini (Wajib/Required). Gunakan judul yang singkat, padat, dan mencerminkan isi berita kampusmu.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-excerpt"]',
    popover: {
      title: '📄 Input Ringkasan (Excerpt)',
      description:
        'Ketik ringkasan singkat artikel (1–2 kalimat). Teks ringkasan ini akan ditampilkan di kartu berita pada halaman utama portal berita. Jika dikosongkan, sistem akan mengambilnya otomatis dari paragraf pertama naskahmu.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-content-editor"]',
    popover: {
      title: '📖 Editor Naskah & Toolbar Format Text',
      description:
        'Tuliskan seluruh isi beritamu di kotak ini. Gunakan tombol toolbar di bagian atas:<br>' +
        '• <strong>B</strong>: Menebalkan teks (Bold).<br>' +
        '• <em>I</em>: Memiringkan teks (Italic).<br>' +
        '• <u>U</u>: Garis bawah teks (Underline).<br>' +
        '• <strong>""</strong>: Format kutipan / rujukan (Blockquote).<br>' +
        '• <strong>H3</strong>: Menjadikan sub-judul bab (Heading 3).',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-publish-box"]',
    popover: {
      title: '🚀 Panel Aksi: Submit vs Save Draft',
      description:
        'Tersedia dua tombol aksi utama:<br>' +
        '1. <strong>Submit for Review</strong>: Mengirimkan artikel ke Editor Admin untuk diperiksa dan disetujui.<br>' +
        '2. <strong>Save Draft</strong>: Menyimpan naskah sebagai draf pribadi tanpa mengirimkannya dulu, sehingga bisa dilanjutkan kapan saja.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-categories"]',
    popover: {
      title: '🏷️ Tombol Pilihan Kategori Berita',
      description:
        'Pilih salah satu tombol kategori yang sesuai (misal: <em>Campus Events, Academic, Sports, Science</em>). Khusus jika memilih <strong>Events</strong>, akan muncul form isian tanggal dan lokasi acara!',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-tags"]',
    popover: {
      title: '🔖 Kolom Input Tag & Sugesti Tag',
      description:
        'Ketik kata kunci tag lalu tekan tombol <strong>Add</strong> atau Enter untuk menambahkan tag artikel. Kamu juga bisa mengklik rekomendasi tag yang muncul di bawahnya untuk kemudahan pencarian.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-cover-image"]',
    popover: {
      title: '🖼️ Pengunggah Gambar Utama (Featured Image)',
      description:
        'Klik area ini untuk mengunggah foto utama artikel dari perangkatmu. Foto ini akan menjadi header utama artikel berita dan pratinjau di portal publik.',
      side: 'left',
      align: 'start',
    },
  },
  {
    popover: {
      title: '✅ Siap Menulis Berita!',
      description:
        'Setelah semua kolom terisi, pastikan memeriksa kembali naskahmu lalu tekan tombol <strong>Submit for Review</strong>!',
      side: 'over',
      align: 'center',
    },
  },
];

export { authorArticlesCreateSteps };
