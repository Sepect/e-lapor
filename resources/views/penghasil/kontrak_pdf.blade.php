@php
    \Carbon\Carbon::setLocale('id');

    $pInfo = $kontrak->penghasil?->informasiPenghasil;
    $pIzin = $kontrak->penghasil?->perizinanPenghasil;
    $tInfo = $kontrak->transporter?->informasiTransporter;
    $tIzin = $kontrak->transporter?->perizinanTransporter;

    $dot = function ($v, int $len = 20) {
        $v = is_string($v) ? trim($v) : $v;
        return $v ?: str_repeat('.', $len);
    };

    // Format tanggal aman untuk Carbon maupun string mentah (sebagian model tidak punya date cast).
    $fmt = function ($d, string $format = 'd F Y') {
        if (empty($d)) {
            return null;
        }

        return \Carbon\Carbon::parse($d)->translatedFormat($format);
    };

    $namaPenghasil = $kontrak->nama_perusahaan ?: ($pInfo->nama_penghasil ?? $kontrak->penghasil?->nama_user);
    $namaTransporter = $tInfo->nama_transporter ?? $kontrak->transporter?->nama_user;

    $tgl = $kontrak->tanggal_ttd ?: $fmt($kontrak->tgl_terbit, 'd');
    $bulan = $kontrak->bulan ?: $fmt($kontrak->tgl_terbit, 'F');
    $tahun = $kontrak->tahun ?: $fmt($kontrak->tgl_terbit, 'Y');
    $berlakuDari = $fmt($kontrak->masa_berlaku_dari);
    $berlakuSampai = $fmt($kontrak->masa_berlaku_sampai);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 2.2cm 2cm; }
        * { font-family: "Times New Roman", Times, serif; }
        body { font-size: 11pt; line-height: 1.5; color: #000; text-align: justify; }
        h1, h2, h3 { text-align: center; margin: 0; }
        .title { font-size: 13pt; font-weight: bold; text-transform: uppercase; }
        .subtitle { font-size: 12pt; font-weight: bold; }
        .center { text-align: center; }
        .nomor { text-align: center; margin: 2px 0; }
        p { margin: 0 0 8px; }
        .pasal-title { text-align: center; font-weight: bold; margin: 14px 0 2px; page-break-after: avoid; }
        ol { margin: 0 0 8px; padding-left: 22px; }
        ol li { margin-bottom: 4px; }
        ol.alpha { list-style-type: lower-alpha; }
        table { width: 100%; border-collapse: collapse; }
        .id-table td { vertical-align: top; padding: 1px 3px; }
        .id-table td.k { width: 150px; }
        .id-table td.s { width: 10px; }
        .ttd-table { margin-top: 24px; }
        .ttd-table td { text-align: center; vertical-align: top; width: 33%; padding: 4px; }
        .sign-space { height: 70px; }
        .bold { font-weight: bold; }
        .u { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="title">Kontrak Kerjasama</div>
    <div class="subtitle">Pengelolaan Limbah Bahan Berbahaya dan Beracun (B3)</div>
    <p class="center" style="margin-top:6px;">ANTARA</p>
    <p class="center bold">{{ strtoupper($namaPenghasil ?: 'NAMA PENGHASIL') }}</p>
    <p class="center bold">{{ strtoupper($namaTransporter ?: 'NAMA TRANSPORTER') }}</p>
    <p class="center">DAN</p>
    <p class="center bold">UPT-PLB3 DINAS LINGKUNGAN HIDUP DAN KEHUTANAN<br>PROVINSI SULAWESI SELATAN</p>
    <p class="center">TENTANG</p>
    <p class="center bold">PENGELOLAAN LIMBAH BAHAN BERBAHAYA DAN BERACUN</p>
    <div class="nomor">NOMOR : {{ $dot($kontrak->nomor_kontrak, 25) }} (Penghasil)</div>
    <div class="nomor">NOMOR : {{ $dot(null, 25) }} (Transporter)</div>
    <div class="nomor">NOMOR : {{ $dot(null, 25) }} (UPT-PLB3)</div>

    <p style="margin-top:12px;">
        Perjanjian Pengelolaan Limbah Bahan Berbahaya dan Beracun ini (selanjutnya disebut &ldquo;Perjanjian&rdquo;)
        dibuat dan ditandatangani di {{ $instansi['kota'] }} pada tanggal {{ $dot($tgl, 6) }} Bulan {{ $dot($bulan, 10) }}
        Tahun {{ $dot($tahun, 12) }} oleh dan antara:
    </p>

    <p>
        <span class="bold">{{ $namaPenghasil ?: $dot(null, 30) }}</span> berkedudukan di
        {{ $dot($kontrak->alamat_ttd ?: ($pInfo->alamat_penghasil ?? null), 30) }},
        Kota {{ $dot($kontrak->kota_ttd ?: ($pInfo->kota_penghasil ?? null), 15) }},
        Provinsi {{ $dot($kontrak->provinsi_ttd, 15) }}, dalam hal ini diwakili
        {{ $dot($kontrak->nama_ttd ?: ($pInfo->nama_penanggung_jawab ?? null), 25) }} selaku
        {{ $dot($kontrak->jabatan_ttd, 20) }} dengan demikian berwenang untuk menandatangani dan melaksanakan
        Perjanjian ini (selanjutnya disebut &ldquo;Pihak Kesatu&rdquo;).
    </p>

    <p>
        <span class="bold">{{ $namaTransporter ?: $dot(null, 30) }}</span>, suatu perseroan yang didirikan berdasarkan
        Hukum Republik Indonesia, berdomisili di {{ $dot($tInfo->alamat_transporter ?? null, 30) }},
        Kota {{ $dot($tInfo->kota_transporter ?? null, 15) }}, dalam hal ini diwakili oleh
        {{ $dot($tInfo->nama_penanggung_jawab ?? null, 25) }}, dengan demikian sah bertindak untuk dan atas nama
        perseroan (selanjutnya disebut &ldquo;Pihak Kedua&rdquo;).
    </p>

    <p>
        <span class="bold">{{ $instansi['nama'] }}</span>, suatu Unit Pelaksana Teknis yang didirikan berdasarkan
        Hukum Republik Indonesia, berdomisili di {{ $instansi['alamat'] }}, Kelurahan {{ $instansi['kelurahan'] }},
        Kecamatan {{ $instansi['kecamatan'] }}, Kota {{ $instansi['kota'] }}, Provinsi {{ $instansi['provinsi'] }},
        dalam hal ini diwakili oleh {{ $instansi['pimpinan'] }}, selaku {{ $instansi['jabatan'] }}, dengan demikian
        sah bertindak untuk dan atas nama UPT (selanjutnya disebut &ldquo;Pihak Ketiga&rdquo;).
    </p>

    <p class="center bold">BAHWASANYA</p>
    <p>
        Selanjutnya Pihak Kesatu, Pihak Kedua, dan Pihak Ketiga secara sendiri-sendiri disebut &ldquo;PIHAK&rdquo;
        dan secara bersama-sama disebut &ldquo;PARA PIHAK&rdquo;.
    </p>
    <ol>
        <li>Bahwa Pihak Kesatu adalah {{ $dot($kontrak->jenis_usaha, 18) }} yang menghasilkan Limbah Bahan Berbahaya
            dan Beracun (B3) sesuai Akta Pendirian Nomor {{ $dot($pIzin->no_akta ?? null, 18) }}
            tanggal {{ $dot($fmt($pIzin?->tgl_terbit), 18) }}.</li>
        <li>Bahwa Pihak Kedua adalah Perusahaan yang bergerak di Jasa Pengangkutan (transporter) berdasarkan
            Rekomendasi Pengangkutan Limbah B3 Nomor {{ $dot($tIzin->no_perling ?? null, 18) }}
            tanggal {{ $dot($fmt($tIzin?->tgl_terbit_perling), 16) }}
            dan berakhir pada tanggal {{ $dot($fmt($tIzin?->masa_berlaku_perling_sampai), 16) }}.</li>
        <li>Bahwa Pihak Ketiga merupakan pihak yang bergerak di bidang Jasa Pengolahan Limbah B3 secara insinerasi
            berdasarkan Surat Keputusan Kementerian Lingkungan Hidup dan Kehutanan Nomor {{ $instansi['izin_no'] }}
            tanggal {{ $instansi['izin_tgl'] }} dan berakhir pada tanggal {{ $instansi['izin_berakhir'] }}.</li>
        <li>Bahwa untuk melaksanakan pengangkutan limbah B3 tersebut Pihak Kesatu sepakat menunjuk Pihak Kedua sebagai
            transporter untuk mengangkut limbah B3 dari lokasi Pihak Kesatu sampai ke lokasi Pihak Ketiga.</li>
    </ol>
    <p>
        Sehubungan dengan hal tersebut di atas, PARA PIHAK telah setuju dan sepakat untuk membuat perjanjian kerjasama
        Pengelolaan Limbah B3 dengan syarat-syarat dan ketentuan sebagai berikut.
    </p>

    <div class="pasal-title">Pasal 1<br>Pokok Perjanjian</div>
    <ol>
        <li>Pihak Kesatu menyetujui untuk menyerahkan limbah bahan berbahaya dan beracun berupa limbah padat sesuai
            dengan perizinan yang dimiliki Pihak Ketiga.</li>
        <li>Untuk melaksanakan pengangkutan limbah B3 tersebut Pihak Kedua mempergunakan alat angkut yang telah memiliki
            izin angkut Limbah B3 dan bertanggung jawab dalam proses pengangkutan dari lokasi Pihak Kesatu sampai di
            lokasi Pihak Ketiga.</li>
        <li>Pihak Ketiga bertanggung jawab dalam proses pengolahan limbah yang dihasilkan oleh Pihak Kesatu sesuai
            perizinan yang diperolehnya.</li>
        <li>Pihak Ketiga memberikan pelayanan administrasi pengolahan limbah B3 dengan menerbitkan Berita Acara
            Penerimaan Limbah B3, Surat Penagihan, dan Laporan Pengolahan Limbah B3 melalui aplikasi.</li>
    </ol>

    <div class="pasal-title">Pasal 2<br>Dasar Hukum Perjanjian</div>
    <p>Pelaksanaan pekerjaan sebagaimana tersebut dalam Pasal 1 berdasarkan kepada:</p>
    <ol class="alpha">
        <li>Peraturan Menteri Lingkungan Hidup No. 101 Tahun 2014 tentang Tata Cara Perizinan Pengelolaan Limbah B3;</li>
        <li>Undang-Undang No. 22 Tahun 2009 tentang Lalu Lintas dan Angkutan Jalan;</li>
        <li>Peraturan Pemerintah Nomor 22 Tahun 2021 tentang Penyelenggaraan Perlindungan dan Pengelolaan Lingkungan Hidup;</li>
        <li>Peraturan Menteri Lingkungan Hidup dan Kehutanan Nomor 6 Tahun 2021 tentang Tata Cara dan Persyaratan Pengelolaan Limbah B3;</li>
        <li>Peraturan Menteri Lingkungan Hidup Nomor 14 Tahun 2013 tentang Simbol dan Label Limbah B3;</li>
        <li>Peraturan Menteri Lingkungan Hidup dan Kehutanan Nomor 56 Tahun 2015 tentang Tata Cara dan Persyaratan Teknis Pengelolaan Limbah B3 dari Fasilitas Pelayanan Kesehatan;</li>
        <li>Perda Provinsi Sulawesi Selatan Nomor 12 Tahun 2019 tentang Retribusi Jasa Usaha;</li>
        <li>Peraturan Gubernur Sulawesi Selatan Nomor 34 Tahun 2022 tentang Peninjauan Tarif Retribusi Pemakaian Kekayaan Daerah.</li>
    </ol>

    <div class="pasal-title">Pasal 3<br>Masa Berlakunya Perjanjian</div>
    <ol>
        <li>Jangka Waktu Perjanjian ini berlaku efektif terhitung sejak tanggal penandatanganan untuk jangka waktu
            {{ $dot($kontrak->jangka_waktu, 14) }}, yaitu tanggal {{ $dot($berlakuDari, 16) }} sampai dengan tanggal
            {{ $dot($berlakuSampai, 16) }}.</li>
        <li>Surat Perjanjian kerjasama ini sewaktu-waktu dapat ditinjau kembali oleh masing-masing pihak, setelah
            sebelumnya salah satu pihak memberitahukan terlebih dahulu kepada pihak lainnya secara tertulis.</li>
        <li>Selama peninjauan kembali, ketentuan dalam perjanjian kerjasama ini tetap berlaku sebelum adanya kesepakatan
            perubahan tertulis dari ketiga belah pihak.</li>
    </ol>

    <div class="pasal-title">Pasal 4<br>Kewajiban Para Pihak</div>
    <ol>
        <li>Pihak Kesatu wajib memberitahukan kepada Pihak Kedua dan Pihak Ketiga setiap ada limbah B3 yang diangkut dari lokasi Pihak Kesatu;</li>
        <li>Pihak Kesatu wajib menanggung semua biaya jasa pengolahan dan pengangkutan LB3 serta pajak kepada Pihak Kedua sesuai mekanisme pembayaran yang disepakati;</li>
        <li>Pihak Kedua wajib membayar biaya pengolahan limbah B3 milik Pihak Kesatu kepada Pihak Ketiga sesuai mekanisme pembayaran yang disepakati;</li>
        <li>Pihak Kedua dalam membuat invoice atas pengolahan limbah milik Pihak Kesatu harus ditujukan kepada Pihak Kesatu;</li>
        <li>Para Pihak wajib memiliki akun aplikasi pengelolaan limbah B3 serta wajib menggunakan manifest elektronik (festronik);</li>
        <li>Pihak Ketiga bertanggung jawab atas kelengkapan izin-izin yang berkenaan dengan pengolahan Limbah B3 sesuai ketentuan yang berlaku.</li>
    </ol>

    <div class="pasal-title">Pasal 5<br>Biaya Pengolahan dan Pengangkutan</div>
    <ol>
        <li>Mengenai besarnya biaya pengolahan dan pengangkutan serta mekanisme pembayarannya akan ditentukan oleh Para Pihak;</li>
        <li>Para Pihak bersepakat tidak akan menurunkan atau menaikkan harga yang telah disepakati sampai berakhirnya jangka waktu Perjanjian;</li>
        <li>Segala keputusan dari hasil penetapan biaya dan mekanisme pembayaran merupakan bagian yang tidak terpisahkan dari Perjanjian ini.</li>
    </ol>

    <div class="pasal-title">Pasal 6<br>Pembayaran</div>
    <ol>
        <li>Pelaksanaan pembayaran oleh Pihak Kesatu maksimal 7 hari kalender sejak menerima invoice dari Pihak Kedua;</li>
        <li>Pembayaran biaya jasa pengolahan dilakukan oleh Pihak Kedua kepada Pihak Ketiga dengan cara transfer ke rekening
            {{ $instansi['bank_nama'] }} Nomor {{ $instansi['bank_rekening'] }} a.n. {{ $instansi['bank_atas_nama'] }};</li>
        <li>Batas waktu pembayaran biaya jasa pengolahan Limbah B3 maksimal 30 (tiga puluh) hari sejak Pihak Ketiga menerima
            limbah B3 untuk diolah yang dibuktikan dengan manifest elektronik dan berita acara penerimaan limbah B3;</li>
        <li>Jika total pembayaran telah mencapai Rp50.000.000 (lima puluh juta rupiah) dan/atau telah melewati jangka waktu
            pembayaran, maka Pihak Ketiga akan menghentikan sementara pelayanan penerimaan limbah B3 sampai tagihan terbayarkan;</li>
        <li>Biaya pengolahan limbah B3 dikenakan denda sebesar 2% (dua persen) dari total tagihan jika belum dilakukan pembayaran sampai batas waktu.</li>
    </ol>

    <div class="pasal-title">Pasal 7<br>Pernyataan dan Jaminan Para Pihak</div>
    <p>Para Pihak menjamin dan menyatakan bahwa masing-masing merupakan pihak yang berwenang untuk menjalin kerjasama,
        membuat kesepakatan, dan menandatangani Perjanjian ini, serta bersedia melaksanakan seluruh hak dan kewajibannya
        dengan penuh tanggung jawab dan itikad baik, tunduk pada Undang-Undang dan peraturan yang berlaku.</p>

    <div class="pasal-title">Pasal 8<br>Pelanggaran</div>
    <p>Apabila dalam pengolahan limbah B3 terbukti Pihak Ketiga tidak melakukan pengolahan sesuai izin yang diperoleh,
        maka Pihak Kesatu dan Pihak Kedua berhak memutuskan kerjasama penyerahan Limbah B3 kepada Pihak Ketiga.</p>

    <div class="pasal-title">Pasal 9<br>Pengakhiran Perjanjian</div>
    <ol>
        <li>Perjanjian ini berakhir dengan sendirinya apabila salah satu pihak tidak ingin memperpanjang berlakunya Perjanjian ini;</li>
        <li>Pengakhiran dilakukan dengan pemberitahuan tertulis dengan tenggang waktu 30 (tiga puluh) hari kalender;</li>
        <li>Dengan berakhirnya Perjanjian ini, Para Pihak tetap bertanggung jawab atas kewajiban yang belum dilaksanakan menurut Perjanjian ini.</li>
    </ol>

    <div class="pasal-title">Pasal 10<br>Force Majeure</div>
    <p>Para Pihak tidak dapat menuntut ganti rugi atas kegagalan atau keterlambatan melaksanakan kewajibannya yang
        disebabkan oleh hal-hal di luar kemampuan yang wajar (Force Majeure), termasuk bencana alam, kebakaran, peperangan,
        huru-hara, dan wabah penyakit yang secara langsung berhubungan dengan Perjanjian ini. Pemberitahuan Force Majeure
        disampaikan secara tertulis selambat-lambatnya 2 x 24 jam.</p>

    <div class="pasal-title">Pasal 11<br>Penyelesaian Sengketa</div>
    <p>Segala sengketa yang timbul diselesaikan secara musyawarah untuk mufakat. Apabila tidak tercapai, Para Pihak sepakat
        menyelesaikannya melalui Kantor Panitera Pengadilan Negeri Makassar.</p>

    <div class="pasal-title">Pasal 12<br>Ketentuan Lain</div>
    <p>Hal-hal yang belum diatur dalam Perjanjian ini akan diatur dalam addendum tersendiri atas dasar musyawarah dan
        mufakat. Perjanjian ini dibuat dalam rangkap 3 (tiga) bermaterai cukup, masing-masing mempunyai kekuatan hukum yang
        sama, dan ditandatangani pada tanggal sebagaimana tercantum pada bagian awal Perjanjian ini.</p>

    <table class="ttd-table">
        <tr>
            <td>PIHAK KESATU<br><span style="font-size:9pt;">(Penghasil)</span><div class="sign-space"></div>
                <span class="bold u">{{ $kontrak->nama_ttd ?: ($pInfo->nama_penanggung_jawab ?? '(.................)') }}</span></td>
            <td>PIHAK KEDUA<br><span style="font-size:9pt;">(Transporter)</span><div class="sign-space"></div>
                <span class="bold u">{{ $tInfo->nama_penanggung_jawab ?? '(.................)' }}</span></td>
            <td>PIHAK KETIGA<br><span style="font-size:9pt;">UPT-PLB3 DPLH Prov. Sulsel</span><div class="sign-space"></div>
                <span class="bold u">{{ $instansi['pimpinan'] }}</span><br>
                <span style="font-size:9pt;">Pangkat: {{ $instansi['pangkat'] }}<br>NIP: {{ $instansi['nip'] }}</span></td>
        </tr>
    </table>

</body>
</html>
