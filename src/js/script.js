// Daftar semua produk
const produkList = [
  {
    id: 1,
    nama: "Kemeja Navy",
    harga: 180000,
    gambar: "../src/img/kemeja navy.jpg",
    deskripsi: "Kemeja navy lengan panjang ini memberikan kesan elegan dan modern. Warna biru navy yang klasik membuatnya ideal untuk acara formal, kantor, hingga malam hari. Dibuat dari bahan berkualitas yang nyaman dipakai serta potongan yang rapi untuk meningkatkan rasa percaya diri.",
    spesifikasi: {
      bahan: "Katun premium",
      ukuran: "S, M, L, XL",
      warna: "Navy",
      perawatan: "Cuci mesin dingin, jangan pemutih"
    }
  },
  {
    id: 2,
    nama: "Kemeja flanel",
    harga: 150000,
    gambar: "../src/img/flanel.jpg",
    deskripsi: "Kemeja flanel merah lengan panjang ini dibuat dari bahan katun berkualitas yang lembut, nyaman, dan hangat saat digunakan. Motif kotak khas flanel memberikan kesan kasual namun tetap stylish, cocok digunakan untuk aktivitas sehari-hari, hangout, hingga acara semi-formal.",
    spesifikasi: {
      bahan: "Flanel katun",
      ukuran: "M, L, XL",
      warna: "Merah kotak",
      perawatan: "Cuci terbalik, jangan dikeringkan dengan panas"
    }
  },
  {
    id: 3,
    nama: "Batik",
    harga: 175000,
    gambar: "../src/img/batik.jpg",
    deskripsi: "Kemeja batik lengan panjang warna coklat terang ini mengusung motif tradisional yang elegan dan bernuansa hangat. Dibuat dari bahan berkualitas yang lembut, ringan, dan nyaman digunakan seharian. Cocok untuk acara formal, pertemuan kerja, hingga acara keluarga dengan tampilan yang tetap sopan dan menawan.",
    spesifikasi: {
      bahan: "Katun batik",
      ukuran: "S, M, L",
      warna: "Coklat",
      perawatan: "Cuci tangan, jangan direndam lama"
    }
  },
  {
    id: 4,
    nama: "Blazer",
    harga: 200000,
    gambar: "../src/img/blazer.jpg",
    deskripsi: "Blazer ini dirancang dengan potongan modern yang memberikan kesan rapi dan profesional. Bahan yang digunakan nyaman dan tidak mudah kusut, cocok untuk acara formal, meeting, maupun tampilan semi-formal yang stylish. Dapat dipadukan dengan kemeja atau kaos untuk berbagai suasana.",
    spesifikasi: {
      bahan: "Polyester mix",
      ukuran: "M, L, XL",
      warna: "Hitam",
      perawatan: "Setrika suhu rendah"
    }
  },
  {
    id: 5,
    nama: "Kemeja Hitam",
    harga: 150000,
    gambar: "../src/img/kemeja hitam.jpg",
    deskripsi: "Kemeja hitam lengan panjang ini menawarkan tampilan elegan dan maskulin. Terbuat dari bahan lembut yang nyaman dipakai seharian. Cocok untuk acara formal, kerja kantor, maupun dipadukan dengan outfit santai di malam hari.",
    spesifikasi: {
      bahan: "Katun combed",
      ukuran: "S, M, L, XL",
      warna: "Hitam",
      perawatan: "Cuci mesin biasa"
    }
  },
  {
    id: 6,
    nama: "Kaos Hitam",
    harga: 100000,
    gambar: "../src/img/kaos hitam.jpg",
    deskripsi: "Kaos hitam polos ini mengusung konsep minimalis yang everlasting. Bahannya lembut, breathable, dan elastis sehingga sangat nyaman digunakan untuk aktivitas harian. Mudah dipadukan dengan jaket, flanel, atau jeans favoritmu.",
    spesifikasi: {
      bahan: "Katun stretch",
      ukuran: "S, M, L",
      warna: "Hitam",
      perawatan: "Cuci mesin dingin"
    }
  },
  {
    id: 7,
    nama: "Kaos Putih",
    harga: 100000,
    gambar: "../src/img/kaos putih.jpg",
    deskripsi: "Kaos putih polos yang simpel dan serbaguna. Terbuat dari bahan katun berkualitas yang menyerap keringat dan tidak gerah saat digunakan. Cocok untuk tampilan kasual maupun layer outfit seperti jaket dan kemeja luar.",
    spesifikasi: {
      bahan: "Katun 100%",
      ukuran: "S, M, L, XL",
      warna: "Putih",
      perawatan: "Cuci terpisah untuk warna putih"
    }
  },
  {
    id: 8,
    nama: "Polo Hitam",
    harga: 150000,
    gambar: "../src/img/polo hitam.jpg",
    deskripsi: "Kaos polo hitam ini memiliki desain kasual namun tetap terlihat rapi. Menggunakan bahan halus yang nyaman serta kerah polo yang memberikan kesan semi-formal. Ideal untuk kegiatan santai, hangout, hingga acara casual office.",
    spesifikasi: {
      bahan: "Pique cotton",
      ukuran: "M, L, XL",
      warna: "Hitam",
      perawatan: "Setrika suhu sedang"
    }
  },
  {
    id: 9,
    nama: "Polo Merah",
    harga: 150000,
    gambar: "../src/img/polo merah.jpg",
    deskripsi: "Kaos polo merah ini memberikan kesan energik dan percaya diri. Dibuat dari bahan yang adem dan nyaman dipakai, cocok untuk kamu yang ingin tampil standout tanpa meninggalkan kesan sporty dan rapi.",
    spesifikasi: {
      bahan: "Pique cotton",
      ukuran: "S, M, L",
      warna: "Merah",
      perawatan: "Cuci terbalik"
    }
  },
  {
    id: 10,
    nama: "Polo Putih",
    harga: 150000,
    gambar: "../src/img/polo putih.jpg",
    deskripsi: "Kaos polo putih ini menawarkan tampilan bersih dan elegan. Cocok untuk kamu yang suka gaya simple namun tetap rapi. Dibuat dari bahan yang halus, ringan, dan nyaman, sehingga cocok dipakai untuk kegiatan santai hingga acara semi-formal. Warnanya yang netral mudah dipadukan dengan berbagai pilihan celana dan outer.",
    spesifikasi: {
      bahan: "Pique cotton",
      ukuran: "S, M, L, XL",
      warna: "Putih",
      perawatan: "Cuci terpisah untuk warna putih"
    }
  }
];

function toggleUserDropdown() {
  const dropdown = document.getElementById("userDropdown");
  dropdown.style.display =
    dropdown.style.display === "block" ? "none" : "block";
}

// Tutup dropdown ketika klik di luar
document.addEventListener("click", function (e) {
  const userMenu = document.querySelector(".user-menu");
  const dropdown = document.getElementById("userDropdown");

  if (!userMenu.contains(e.target)) {
    dropdown.style.display = "none";
  }
});