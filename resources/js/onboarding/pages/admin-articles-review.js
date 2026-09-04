/**
 * Tour steps: Admin — Review Article (admin.articles.review)
 * Penjelasan mendetail untuk proses peninjauan naskah: membaca konten, menyetujui, menjadwalkan, atau menolak dengan catatan revisi.
 */
const adminArticlesReviewSteps = [
  {
    popover: {
      title: '🔍 Layar Evaluasi & Review Artikel Redaksi',
      description:
        'Ini adalah layar paling krusial bagi Administrator! Di sini kamu membaca naskah yang diajukan oleh Author, memeriksa kelayakan jurnalistik, dan menentukan apakah artikel disetujui atau butuh perbaikan.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="review-metadata"]',
    popover: {
      title: '🏷️ Kartu Metadata & Link "Edit Metadata"',
      description:
        'Memeriksa kategori, tag, serta informasi penulis. Jika kategori atau tag kurang tepat, kamu bisa mengklik tombol <strong>Edit Metadata</strong> untuk membenahinya langsung tanpa mengubah naskah utama.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="review-approve-btn"]',
    popover: {
      title: '✅ Tombol "Approve & Schedule"',
      description:
        'Klik tombol merah ini jika naskah sudah layak terbit. Artikel akan diubah statusnya menjadi <em>Awaiting Payment</em> dan email pemberitahuan beserta instruksi pembayaran akan otomatis dikirimkan ke Author.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="review-reject-box"]',
    popover: {
      title: '💬 Form "Admin Notes" & Tombol "Reject"',
      description:
        'Jika artikel belum layak terbit:<br>' +
        '1. Ketik catatan revisi yang spesifik di kotak <strong>Admin Notes / Feedback</strong> (misal: "Tambahkan foto narasumber dan perbaiki alinea 2").<br>' +
        '2. Klik tombol <strong>Reject</strong>.<br>' +
        'Catatanmu akan langsung dikirimkan ke Author untuk direvisi.',
      side: 'left',
      align: 'start',
    },
  },
];

export { adminArticlesReviewSteps };
