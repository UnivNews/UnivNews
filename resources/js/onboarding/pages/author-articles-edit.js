/**
 * Tour steps: Author — Edit Article (author.articles.edit)
 * Penjelasan mendetail untuk proses pengeditan, peninjauan feedback editor, dan pengiriman ulang naskah.
 */
const authorArticlesEditSteps = [
  {
    popover: {
      title: '✏️ Halaman Edit & Revisi Artikel',
      description:
        'Halaman ini digunakan untuk memperbarui naskah artikel yang masih berstatus Draf atau yang dikembalikan oleh Editor Admin untuk direvisi.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="edit-status-badge"]',
    popover: {
      title: '📌 Label Status Artikel',
      description:
        'Label ini menandakan kondisi naskahmu saat ini (misalnya: <em>Draft</em>, <em>Pending Review</em>, atau <em>Rejected / Needs Revision</em>).',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="edit-admin-feedback"]',
    popover: {
      title: '💬 Catatan Feedback dari Editor Redaksi',
      description:
        'Jika artikelmu berstatus <span style="color:#dc2626;font-weight:bold;">Rejected</span>, perhatikan kotak merah ini! Di dalamnya terdapat catatan khusus dari Editor mengenai bagian naskah mana saja yang perlu perbaikan sebelum diajukan kembali.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-title"]',
    popover: {
      title: '📝 Pengeditan Judul & Konten Naskah',
      description:
        'Kamu dapat mengubah judul, ringkasan, isi naskah di editor, hingga mengganti foto cover sesuai dengan arahan masukan editor.',
      side: 'right',
      align: 'start',
    },
  },
  {
    element: '[data-tour="create-publish-box"]',
    popover: {
      title: '🔄 Tombol Kirim Ulang (Re-Submit) vs Simpan Draf',
      description:
        '• <strong>Submit for Review / Re-Submit</strong>: Tekan tombol ini setelah kamu selesai memperbaiki naskah agar dikaji ulang oleh Editor.<br>' +
        '• <strong>Save Draft</strong>: Tekan tombol ini jika perbaikanmu belum selesai dan ingin melanjutkannya nanti.',
      side: 'left',
      align: 'start',
    },
  },
];

export { authorArticlesEditSteps };
