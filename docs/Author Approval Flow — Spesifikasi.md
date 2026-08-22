```
Author Approval Flow — Spesifikasi Fitur
```

```
Dokumen ini menjelaskan alur lengkap perubahan role user dari Public/Reader
menjadi Author, mulai dari apply, review oleh admin, sampai aktivasi akun.
Ditulis untuk jadi acuan development (AI-ready: bisa langsung dipakai sebagai
konteks/prompt ke AI coding assistant).
```

```
1. Latar Belakang & Keputusan Desain
Autentikasi utama menggunakan Google OAuth. Semua user yang login lewat Google
otomatis punya role default Public/Reader, dan akun ini tidak memiliki password
(karena auth sepenuhnya lewat Google).
Reader tidak wajib melakukan apa pun untuk bisa membaca konten — tidak ada
friction tambahan.
User yang ingin menjadi kontributor konten harus mengajukan Apply for Author
Access, yang kemudian direview manual oleh admin.
Tombol "Apply as Author" / "Write" ditempatkan di profile/account settings,
bukan di navbar utama, supaya tidak mengganggu pengalaman reader biasa namun
tetap mudah ditemukan.
Keputusan penting (Skema B): Password baru dibuat setelah aplikasi disetujui
admin, bukan saat apply. Alasan:
Mengurangi friction saat apply (user tidak perlu mikirin password di awal, cukup
isi data kontribusi).
Menghindari password/token yang keburu basi kalau proses review makan waktu
lama.
Secara psikologis, pembuatan password terasa seperti "aktivasi resmi"/reward
setelah diterima, bukan beban administratif di awal.
2. Role & State User
RoleDeskripsi
PUBLIC / READERDefault role setelah login Google. Bisa baca semua konten
publik. Tidak punya password.
AUTHOR_PENDINGUser sudah submit form apply, menunggu review admin.
AUTHOR_REJECTEDAplikasi ditolak admin. (opsional: bisa apply ulang setelah
durasi tertentu)
AUTHORAplikasi disetujui, password sudah di-set, akun aktif sebagai
kontributor.
3. Alur Utama (End-to-End Flow)
[User login via Google]
        ↓ (role: PUBLIC, no password)
[User buka Profile Settings]
        ↓
[Klik "Apply for Author Access"]
        ↓
[Isi form aplikasi — TANPA password]
        ↓
[Submit] → role berubah jadi AUTHOR_PENDING
        ↓
[Tampilkan halaman/modal konfirmasi formal]
        ↓
[Notifikasi email: "Aplikasi kamu sedang direview"]
        ↓
```

```
   ┌────────────────┐
   │  Admin Review   │
   └────────────────┘
        ↓
   ┌─────────┴─────────┐
   ↓                    ↓
[APPROVED]          [REJECTED]
   ↓                    ↓
[Email: link set     [Email: pemberitahuan
 password (token,      penolakan + alasan
 expiring)             (opsional) + role
   ↓                    kembali ke PUBLIC]
[User klik link →
 set password baru]
```

```
   ↓
[role: AUTHOR, akun aktif]
4. Detail Form "Apply for Author Access"
4.1 Field
FieldWajib?Editable?Catatan
Applicant NameYaYaPrefill dari data Google, tapi tetap bisa diedit
user
EmailYaRead-onlyPrefill dari akun Google, styling disabled (background
abu-abu) untuk menandakan tidak bisa diubah
UniversityYaYaDropdown (untuk sekarang: static list). Perlu opsi
"Other" yang memunculkan text field manual, untuk universitas yang tidak ada di
list
```

```
Faculty / DepartmentYaYaFree text
Author Slug / Desk NameTidakYaBeri ikon info (i) dengan tooltip:
menjelaskan bahwa ini akan jadi identitas/byline penulis di artikel mereka
Phone NumberTidakYaFree text, optional
Why do you want to contribute? (Bio & Topics)YaYaTextarea. Tambahkan
karakter minimum (misal 50 karakter) dan character counter (misal "120/500")
supaya jawaban tidak asal singkat. Ini jadi bahan pertimbangan utama admin saat
review
```

```
4.2 Validasi
Validasi terjadi di dalam form ini (bukan sebelum user masuk ke form). User yang
klik "Apply as Author" dari profile langsung diarahkan ke form ini tanpa
hambatan/blokir awal.
Required field ditandai asterisk merah (*).
Jika submit ditekan dan ada field wajib kosong / bio kurang dari minimum
karakter → shake effect di field yang bermasalah + border merah + pesan error
singkat di bawah field.
Tidak ada field password di form ini (sesuai Skema B).
4.3 Setelah Submit
```

```
Tampilkan halaman konfirmasi formal (bukan sekadar toast), dengan pesan kurang
lebih:
```

# `Aplikasi Terkirim` 

```
Terima kasih, [Nama User]. Aplikasi kamu untuk menjadi Author telah berhasil
diterima oleh sistem kami dan saat ini berada dalam proses peninjauan oleh tim
admin.
```

```
Kami akan meninjau data dan kredensial yang kamu berikan. Proses ini biasanya
memakan waktu 1–3 hari kerja. Hasil dari peninjauan — baik disetujui maupun
tidak — akan dikirimkan melalui email ke alamat [email user].
```

```
Mohon untuk memeriksa folder spam/promosi apabila email tidak kunjung diterima
dalam waktu yang ditentukan.
```

```
Jika ada pertanyaan lebih lanjut, silakan hubungi tim kami melalui
[kontak/support email].
```

```
Status aplikasi (Pending) sebaiknya juga terlihat di halaman Profile Settings
user, agar mereka bisa cek kapan saja tanpa harus menunggu email.
```

```
5. Alur Admin Review
Admin melihat daftar aplikasi dengan status AUTHOR_PENDING di dashboard admin.
Admin bisa melihat seluruh detail form yang disubmit (nama, universitas,
departemen, bio/alasan, dll).
Admin melakukan salah satu aksi:
Approve → trigger flow set password (lihat bagian 6)
Reject → role user kembali ke PUBLIC, kirim email notifikasi (opsional sertakan
alasan penolakan/catatan dari admin)
6. Alur Setelah Approved (Password Setup)
Admin approve aplikasi → sistem generate token unik dengan masa berlaku terbatas
(misal 24–48 jam).
```

```
Sistem kirim email ke user berisi link aktivasi, contoh:
https://domain.com/author/set-password?token=xxxxxxx
User klik link → diarahkan ke halaman "Set Your Password" (bukan halaman
lengkapi profil lagi, karena data sudah diisi saat apply).
User isi password baru + konfirmasi password.
Setelah berhasil submit:
Role user berubah dari AUTHOR_PENDING → AUTHOR.
Password tersimpan (hashed) sebagai kredensial tambahan untuk akun tersebut, di
luar Google OAuth.
Redirect ke dashboard author / halaman "Akun kamu telah aktif sebagai Author".
Jika token expired sebelum user sempat set password → sediakan opsi "Kirim ulang
link aktivasi" di halaman error/token invalid.
7. Catatan Teknis Tambahan
Login tetap bisa lewat Google untuk author — password baru ini hanya diperlukan
untuk kasus tertentu (misal login manual/dashboard admin/2FA tambahan),
sesuaikan dengan kebutuhan sistem otentikasi yang sedang dibangun.
Field email di form apply harus di-lock secara backend juga, bukan hanya
disabled di UI (mencegah manipulasi request langsung ke API).
State AUTHOR_REJECTED sebaiknya menyimpan history/log agar admin bisa lihat
riwayat aplikasi sebelumnya jika user apply ulang.
Semua transisi status (PENDING → APPROVED/REJECTED → AUTHOR) sebaiknya dicatat
dengan timestamp untuk audit trail.
8. Ringkasan Diagram State
PUBLIC ──(apply)── AUTHOR_PENDING ──(admin approve)── [set password] ── ▶▶▶
AUTHOR
                          │
```

```
▶
```

