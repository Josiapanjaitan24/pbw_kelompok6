// Daftar semua produk
const produkList = [
  {
    id: 1,
    nama: "Kemeja Navy",
    harga: 180000,
    gambar: "../src/img/kemeja navy.jpg",
    deskripsi: "Kemeja navy berkualitas dengan bahan premium dan nyaman dipakai."
  },
  {
    id: 2,
    nama: "Kemeja flanel",
    harga: 150000,
    gambar: "../src/img/flanel.jpg",
    deskripsi: "flanel."
  },
  {
    id: 3,
    nama: "Batik",
    harga: 175000,
    gambar: "../src/img/batik.jpg",
    deskripsi: "batik."
  },
  {
    id: 4,
    nama: "Blazer",
    harga: 200000,
    gambar: "../src/img/blazer.jpg",
    deskripsi: "blazer"
  },
  {
    id: 5,
    nama: "Kemeja Hitam",
    harga: 150000,
    gambar: "../src/img/kemeja hitam.jpg",
    deskripsi: "Kemeja hitam."
  },
  {
    id: 6,
    nama: "Kaos Hitam",
    harga: 100000,
    gambar: "../src/img/kaos hitam.jpg",
    deskripsi: "Kaos Hitam"
  },
  {
    id: 7,
    nama: "Kaos Putih",
    harga: 100000,
    gambar: "../src/img/kaos putih.jpg",
    deskripsi: "Kaos Putih."
  },
  {
    id: 8,
    nama: "Polo Hitam",
    harga: 150000,
    gambar: "../src/img/polo hitam.jpg",
    deskripsi: "Polo Hitam"
  },
  {
    id: 9,
    nama: "Polo Merah",
    harga: 150000,
    gambar: "../src/img/polo merah.jpg",
    deskripsi: "polo merah"
  },
  {
    id: 10,
    nama: "Polo Putih",
    harga: 150000,
    gambar: "../src/img/polo putih.jpg",
    deskripsi: "Polo Putih"
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