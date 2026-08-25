<x-mail::message>
# Halo {{ $boost->user->name }},

Terima kasih telah menggunakan fitur Boost Artikel. 
Pembayaran untuk Boost artikel **"{{ $boost->article->title }}"** telah kami terima.

**Detail Boost:**
- **Status:** {{ $boost->status === 'active' ? 'Aktif' : 'Terjadwal' }}
- **Tanggal Mulai:** {{ \Carbon\Carbon::parse($boost->start_date)->translatedFormat('d F Y') }}
- **Tanggal Selesai:** {{ \Carbon\Carbon::parse($boost->end_date)->translatedFormat('d F Y') }}

Artikel Anda akan tampil di bagian "Featured" di halaman utama selama periode tersebut.

<x-mail::button :url="route('article', $boost->article->slug)">
Lihat Artikel
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
