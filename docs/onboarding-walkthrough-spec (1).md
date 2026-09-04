# Spec: Onboarding Walkthrough (Role Author & Admin) — UnivNews

## 1. Tujuan

Menyediakan guided tour otomatis yang muncul saat user (author/admin) pertama kali membuka dashboard mereka, menjelaskan fitur-fitur utama sesuai role. Tour dibangun pakai **Driver.js**, trigger-nya berbasis flag di DB, bukan berbasis "pernah buka halaman".

> ⚠️ **Catatan penting**: Dokumen ini fokus ke *mekanisme* (DB schema, trigger logic, struktur config Driver.js, endpoint AJAX). Bagian **isi step per role (section 5 & 6) sengaja dibuat sebagai template placeholder** karena ada fitur-fitur yang sudah ditambahkan di project tapi belum dikomunikasikan di sesi ini. Sebelum implementasi, isi ulang `TODO` di section 5 & 6 sesuai fitur aktual yang sudah ada di UI sekarang (menu, tombol, halaman apa saja yang benar-benar ada).

---

## 2. Prinsip Desain

- **Flag `has_completed_onboarding` merepresentasikan "user sudah pernah menyelesaikan/skip tour"**, bukan "user pernah membuka halaman". Lihat section 4 untuk alasan (race condition, refresh sebelum selesai, dst).
- Tour **role-specific** — author dan admin dapat step yang berbeda, karena tujuan dan area kerja mereka beda.
- Tour harus bisa **di-replay manual** kapan saja lewat tombol "Lihat tutorial" (tidak hanya sekali seumur hidup).
- Step tour harus **defensif terhadap elemen yang tidak ada** — kalau DOM selector suatu step tidak ditemukan (misal karena user role campuran atau UI berubah), skip step tersebut, jangan error/crash.

---

## 3. Skema Database

Tambahan kolom di tabel `users` (via migration):

```php
Schema::table('users', function (Blueprint $table) {
    $table->boolean('has_completed_onboarding')->default(false);
    $table->timestamp('onboarding_completed_at')->nullable();
});
```

Tidak perlu tabel terpisah — cukup 1 flag per user karena tour ditentukan dari role user saat itu (`author` / `admin`), bukan per-fitur.

---

## 4. Trigger Logic

### 4.1 Kapan tour muncul
- Saat halaman dashboard (author atau admin) selesai di-render (`DOMContentLoaded`)
- **DAN** `auth()->user()->has_completed_onboarding === false`

Dicek dari Blade, di-pass ke JS via data attribute atau `@json`:

```blade
<body data-onboarding-pending="{{ auth()->user()->has_completed_onboarding ? 'false' : 'true' }}"
      data-user-role="{{ auth()->user()->role }}">
```

### 4.2 Kapan flag di-set `true`
**Bukan** saat page load. **Hanya** saat salah satu dari:
1. User menyelesaikan seluruh step tour (klik "Done" di step terakhir)
2. User klik "Skip tour" / tombol close (×)

Kedua kondisi trigger AJAX call yang sama ke endpoint `POST /onboarding/complete`.

**Kenapa bukan page load?**
- Race condition antara Blade render vs JS/Driver.js load (koneksi lambat → flag keburu true, tour belum sempat muncul)
- User refresh/nutup tab di tengah tour → kalau di-set saat load, tour hilang selamanya padahal belum kelar dilihat
- Flag harus mencerminkan fakta "user sudah berinteraksi dengan tour", bukan "server sempat render halaman"

### 4.3 Replay manual
Tombol "Lihat tutorial lagi" di halaman settings/help masing-masing role → trigger tour secara manual dari JS (tanpa cek flag, langsung `driver.drive()`), **tidak** mengubah flag `has_completed_onboarding` (karena sudah `true`, tidak perlu diubah lagi).

---

## 5. Endpoint

### `POST /onboarding/complete`

**Request:**
```json
{
  "status": "completed" // atau "skipped"
}
```

**Behavior:**
```php
Route::post('/onboarding/complete', function (Request $request) {
    $request->user()->update([
        'has_completed_onboarding' => true,
        'onboarding_completed_at' => now(),
    ]);
    // optional: log $request->status untuk analytics (completed vs skipped)
    return response()->json(['success' => true]);
})->middleware('auth');
```

Tidak perlu validasi rumit — cukup pastikan user authenticated (middleware `auth`), karena ini per-user sendiri, tidak ada input sensitif dari client yang dipercaya mentah-mentah.

---

## 6. Struktur Frontend (Driver.js)

### 6.1 Install library via npm (bukan CDN)

Karena project sudah pakai build tooling (Vite, bawaan Laravel), lebih aman & stabil install Driver.js via npm lalu di-bundle bareng asset lain — bukan load dari CDN pihak ketiga saat runtime. Alasan:
- File di-serve dari server sendiri, tidak gantung ke uptime/keamanan CDN luar tiap page load
- Tidak ada request eksternal tambahan tiap kali dashboard author/admin dibuka
- Versi library terkunci persis sesuai `package.json` / `package-lock.json`, tidak berubah tiba-tiba

```bash
npm install driver.js
```

Import di file JS onboarding (bukan tag `<script>` CDN):

```js
import { driver } from "driver.js";
import "driver.js/dist/driver.css";
```

Pastikan file JS onboarding (`resources/js/onboarding/onboarding-core.js`, dst) di-include ke entry point Vite (`resources/js/app.js` atau entry khusus dashboard), lalu di-compile lewat `npm run build` seperti asset lain. Tidak perlu tag `<link>`/`<script>` manual ke CDN di Blade.

### 6.2 Struktur file JS
Rekomendasi: pisah per role supaya maintainable.

```
resources/js/onboarding/
├── onboarding-core.js       # inisialisasi driver, logic trigger, AJAX complete
├── onboarding-author.js     # array steps khusus author
└── onboarding-admin.js      # array steps khusus admin
```

`onboarding-core.js` (kerangka, tidak berubah antar role):

```js
import { driver } from "driver.js";
import "driver.js/dist/driver.css";

function initOnboarding(steps) {
  const pending = document.body.dataset.onboardingPending === 'true';
  if (!pending) return;

  const driverObj = driver({
    showProgress: true,
    steps: steps,
    onDestroyed: () => markOnboardingComplete(),
  });

  driverObj.drive();
}

function markOnboardingComplete(status = 'completed') {
  fetch('/onboarding/complete', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify({ status }),
  }).catch(err => console.error('Failed to mark onboarding complete', err));
}

function replayOnboarding(steps) {
  const driverObj = driver({ showProgress: true, steps });
  driverObj.drive();
}

export { initOnboarding, replayOnboarding };
```

> Catatan: Driver.js `onDestroyed` terpanggil baik saat user klik "Done" di step terakhir **maupun** saat close (×) / skip — jadi satu handler ini cukup untuk kedua kasus (section 4.2).

---

## 7. Konten Step — TEMPLATE (perlu diisi ulang sesuai fitur aktual)

> **PENTING**: Isi di bawah ini adalah **placeholder generik** berdasarkan fitur yang pernah dibahas sebelumnya (apply-to-author, submit artikel, payment, boosting, dst). Karena ada fitur tambahan yang belum dikomunikasikan, **cek ulang UI dashboard yang sekarang** dan sesuaikan:
> - Selector CSS/ID tiap elemen (harus cocok dengan Blade yang sebenarnya)
> - Urutan step (ikuti alur kerja natural di UI sekarang)
> - Tambah/hapus step sesuai fitur yang benar-benar ada

### 7.1 Author — `onboarding-author.js`

```js
const authorSteps = [
  {
    element: '#TODO-sidebar-submit-article', // TODO: sesuaikan selector
    popover: {
      title: 'Submit Artikel Baru',
      description: 'Klik di sini untuk mulai menulis dan mengajukan artikel baru.',
    },
  },
  {
    element: '#TODO-article-status-list', // TODO: sesuaikan selector
    popover: {
      title: 'Status Artikel',
      description: 'Pantau status artikel kamu: draft, menunggu review, disetujui, atau ditolak.',
    },
  },
  {
    element: '#TODO-payment-section', // TODO: sesuaikan selector, cek dulu apakah UI payment authornya seperti apa sekarang
    popover: {
      title: 'Pembayaran Publikasi',
      description: 'Setelah artikel disetujui admin, kamu perlu menyelesaikan pembayaran sebelum artikel dipublikasikan.',
    },
  },
  {
    element: '#TODO-boost-section', // TODO: sesuaikan, cek UI fitur boosting saat ini
    popover: {
      title: 'Boost Artikel',
      description: 'Ingin artikelmu tampil di homepage? Booking slot boost di sini.',
    },
  },
  // TODO: tambahkan step lain sesuai fitur tambahan yang belum dikomunikasikan
];
```

### 7.2 Admin — `onboarding-admin.js`

```js
const adminSteps = [
  {
    element: '#TODO-pending-approval-list', // TODO: sesuaikan selector
    popover: {
      title: 'Antrian Approval',
      description: 'Di sini kamu bisa review pengajuan author baru dan artikel yang menunggu persetujuan.',
    },
  },
  {
    element: '#TODO-boost-management', // TODO: sesuaikan, cek UI admin boost management saat ini
    popover: {
      title: 'Kelola Boosting',
      description: 'Atur slot boost yang aktif, harga, dan durasi yang tersedia untuk author.',
    },
  },
  // TODO: tambahkan step untuk fitur admin lain yang sudah ditambahkan tapi belum dibahas di sini
];
```

---

## 8. Checklist Implementasi

1. [ ] Migration: tambah kolom `has_completed_onboarding`, `onboarding_completed_at` di `users`
2. [ ] Route + controller method `POST /onboarding/complete`
3. [ ] `npm install driver.js`, pastikan masuk `package.json` (dependencies, bukan devDependencies)
4. [ ] Buat `onboarding-core.js`, `onboarding-author.js`, `onboarding-admin.js`, import via ES module (bukan tag `<script>` CDN), sertakan di entry point Vite
5. [ ] Pasang data attribute `data-onboarding-pending` & `data-user-role` di `<body>` layout
6. [ ] **Audit UI dashboard saat ini** → update selector & step di section 7 sesuai fitur aktual (termasuk fitur yang belum dikomunikasikan)
7. [ ] Tambah tombol "Lihat tutorial lagi" di halaman settings/help masing-masing role → panggil `replayOnboarding()`
8. [ ] Test skenario: refresh di tengah tour (flag harus tetap `false`), skip tour (flag jadi `true`), selesai penuh (flag jadi `true`)
9. [ ] Pastikan step yang elemen-nya tidak ditemukan tidak menyebabkan JS error (Driver.js akan skip otomatis kalau selector tidak match, tapi tetap perlu ditest)

---

## 9. Open Questions

- Apakah perlu tour terpisah untuk **public reader** juga, atau cukup author & admin dulu?
- Apakah step tour perlu di-versioning (misal: kalau ada fitur baru ditambahkan setelah user selesai onboarding, apakah perlu "re-trigger partial tour" untuk fitur baru saja)? — di luar scope dokumen ini, tapi perlu didiskusikan kalau relevan ke depannya.
