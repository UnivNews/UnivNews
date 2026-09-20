/**
 * Tour steps: Admin — Active Sessions Settings (admin.sessions.index)
 * Penjelasan mendetail untuk pemantauan sesi login, kalibrasi GPS riil, revokasi akses, dan keamanan akun.
 */
const adminSessionsIndexSteps = [
  {
    popover: {
      title: '🛡️ Halaman Keamanan & Pemantauan Sesi Aktif',
      description:
        'Selamat datang di pusat keamanan sesi login! Halaman ini memonitor seluruh perangkat fisik yang sedang menggunakan akun Administrator ini secara langsung (<em>real-time</em>) lengkap dengan pelacakan posisi GPS.',
      side: 'over',
      align: 'center',
    },
  },
  {
    element: '[data-tour="sessions-header"]',
    popover: {
      title: '📱 Ringkasan Perangkat Aktif',
      description:
        'Header ini menampilkan total perangkat riil yang sedang terhubung ke akunmu. Kamu bisa memastikan tidak ada perangkat tak dikenal yang memiliki akses ke dashboard.',
      side: 'bottom',
      align: 'start',
    },
  },
  {
    element: '[data-tour="sessions-gps-sync-btn"]',
    popover: {
      title: '📍 Tombol "Sync Live GPS"',
      description:
        'Klik tombol ini untuk mengkalibrasi posisi GPS akurat perangkatmu melalui browser Geolocation API. Koordinat hardware dan nama kota/kabupaten terkini akan otomatis disinkronkan ke server.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="sessions-revoke-others-btn"]',
    popover: {
      title: '🚪 Tombol "Sign Out Everywhere Else"',
      description:
        'Jika terdeteksi login di komputer umum atau perangkat lain yang sudah tidak terpakai, klik tombol merah ini untuk mencabut akses semua perangkat lain sekaligus. Kamu akan tetap aman masuk di perangkat ini.',
      side: 'left',
      align: 'start',
    },
  },
  {
    element: '[data-tour="sessions-card"]',
    popover: {
      title: '💻 Kartu Device Sessions',
      description:
        'Bagian ini menampilkan daftar otentik perangkat yang tersimpan di basis data sesi. Setiap entri mencantumkan jenis perangkat (Desktop, Mobile, Tablet), browser, IP address publik, kota/wilayah, serta waktu aktif terakhir.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="sessions-list"]',
    popover: {
      title: '🏷️ Badge "This Device" & Tombol "Sign Out"',
      description:
        '• <strong>This device</strong>: Menandai perangkat yang sedang kamu gunakan saat ini.<br>' +
        '• <strong>Sign out</strong>: Tersedia pada perangkat sekunder/lainnya untuk mengeluarkan sesi tersebut secara individual dengan aman.',
      side: 'top',
      align: 'start',
    },
  },
  {
    element: '[data-tour="sessions-info-note"]',
    popover: {
      title: 'ℹ️ Catatan Keamanan & Konfigurasi API',
      description:
        'Mencabut sesi perangkat akan langsung membatalkan <em>refresh token</em> perangkat tersebut sehingga wajib melakukan login ulang. Kotak ini juga memuat petunjuk opsi integrasi Google Maps Geocoding atau IPinfo jika ingin menggunakan API korporat.',
      side: 'top',
      align: 'start',
    },
  },
];

export { adminSessionsIndexSteps };
