<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIPETRA - Solusi Praktis Layanan Hewan</title>
  <meta name="description" content="SIPETRA adalah platform layanan hewan terpercaya untuk grooming, penitipan, antar jemput, dan kebersihan kandang. Mudah, aman, dan didukung oleh mitra berpengalaman." />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary: #bb9587;
      --dark: #1a1a1a;
      --light: #ffffff;
      --muted: #666;
      --bg: #fefefe;
      --accent: #fff4f1;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--dark);
      scroll-behavior: smooth;
    }

    header {
      background: linear-gradient(135deg, #bb9587, #e6d0c8);
      color: var(--light);
      padding: 140px 20px 120px;
      text-align: center;
    }
    header h1 {
      font-size: 3.2rem;
      font-weight: 800;
      margin-bottom: 20px;
    }
    header p {
      font-size: 1.25rem;
      max-width: 640px;
      margin: 0 auto 36px;
      line-height: 1.6;
    }
    .btn {
      background: var(--light);
      color: var(--primary);
      padding: 14px 32px;
      border-radius: 30px;
      font-weight: 600;
      font-size: 1rem;
      text-decoration: none;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }
    .btn:hover {
      background: #f2e3df;
      transform: translateY(-2px);
    }

    section {
      padding: 100px 24px;
      max-width: 1140px;
      margin: auto;
      text-align: center;
    }
    section h2 {
      font-size: 2.5rem;
      margin-bottom: 56px;
      color: var(--primary);
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 32px;
    }
    .card {
      background: var(--light);
      border-radius: 20px;
      padding: 32px;
      box-shadow: 0 8px 28px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 36px rgba(0,0,0,0.08);
    }
    .card h3 {
      font-size: 1.25rem;
      margin-bottom: 12px;
      color: var(--primary);
    }
    .card p {
      font-size: 0.95rem;
      color: var(--muted);
      line-height: 1.6;
    }

    .highlight {
  background: var(--accent);
  padding: 100px 24px;
  border-radius: 32px;
  margin: 80px auto;
  max-width: 1000px;
  text-align: center;
}

    .testimonial-box {
      background: var(--light);
      padding: 48px;
      border-radius: 24px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.06);
      max-width: 720px;
      margin: auto;
    }
    .testimonial-box p {
      font-style: italic;
      font-size: 1.15rem;
      line-height: 1.8;
    }
    .testimonial-box cite {
      display: block;
      margin-top: 20px;
      font-weight: 600;
      color: var(--primary);
    }

    .cta {
      background: linear-gradient(135deg, #bb9587, #d9bdb3);
      color: #fff;
      text-align: center;
      padding: 100px 24px;
    }
    .cta h2 {
      font-size: 2.2rem;
      margin-bottom: 28px;
    }
    .cta a {
      background: #fff;
      color: var(--primary);
      padding: 16px 40px;
      font-weight: 600;
      font-size: 1rem;
      border-radius: 30px;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    .cta a:hover {
      background: #f3eae8;
      transform: translateY(-2px);
    }

    footer {
      background: #fff;
      text-align: center;
      font-size: 0.9rem;
      padding: 40px 20px;
      color: #888;
    }
  </style>
</head>
<body>
  <header>
    <h1>SIPETRA</h1>
    <p>Platform modern dan terpercaya untuk layanan grooming, penitipan, antar jemput, dan pembersihan kandang hewan peliharaan Anda.</p>
    <a href="{{ route('signup') }}" class="btn">Gabung Sekarang</a>
  </header>

  <section>
    <h2>Layanan SIPETRA</h2>
    <div class="features-grid">
      <div class="card">
        <h3>📌 Pemesanan Layanan Perawatan</h3>
        <p>Pesan layanan grooming, penitipan, antar jemput, atau pembersihan kandang langsung dari aplikasi secara praktis dan cepat.</p>
      </div>
      <div class="card">
        <h3>📍 Pencarian Layanan Berdasarkan Lokasi</h3>
        <p>Temukan penyedia jasa terdekat dari lokasi Anda tanpa harus repot mencari secara manual.</p>
      </div>
      <div class="card">
        <h3>💳 Pembayaran Terintegrasi</h3>
        <p>Lakukan pembayaran langsung di aplikasi dengan aman dan efisien tanpa harus pindah platform.</p>
      </div>
      <div class="card">
        <h3>📖 Riwayat Pemesanan</h3>
        <p>Lihat kembali riwayat transaksi dan layanan yang telah Anda gunakan sebelumnya kapan pun Anda butuh.</p>
      </div>
    </div>
  </section>

  <section class="highlight">
    <h2>Kenapa Pengguna Memilih SIPETRA?</h2>
    <div class="features-grid">
      <div class="card">
        <h3>🔐 Mitra Terverifikasi</h3>
        <p>Setiap mitra SIPETRA telah melewati proses seleksi dan verifikasi untuk menjamin kualitas layanan.</p>
      </div>
      <div class="card">
        <h3>⚡ Pemesanan Mudah</h3>
        <p>Interface yang intuitif memudahkan Anda memesan layanan dalam waktu singkat.</p>
      </div>
      <div class="card">
        <h3>🌍 Jangkauan Layanan</h3>
        <p>SIPETRA tersedia di berbagai kota besar di Indonesia dan terus berkembang.</p>
      </div>
      <div class="card">
        <h3>📊 Transparansi & Riwayat</h3>
        <p>Lihat riwayat pesanan Anda dan dapatkan informasi harga yang jelas sejak awal.</p>
      </div>
    </div>
  </section>

  <section>
    <h2>Apa Kata Pengguna SIPETRA?</h2>
    <div class="testimonial-box">
      <p>"Saya bisa booking layanan penitipan dan grooming langsung dari HP saya tanpa repot. SIPETRA sangat membantu!"</p>
      <cite>– Anisa, Surabaya</cite>
    </div>
  </section>

  <section class="cta" style="max-width: 900px; margin: 0 auto; border-radius: 30px;">
    <h2>Yuk, mulai rawat hewanmu bersama SIPETRA!</h2>
    <a href="{{ route('signup') }}">Daftar Sekarang</a>
  </section>

  <footer>
    &copy; {{ date('Y') }} SIPETRA
  </footer>
</body>
</html>
