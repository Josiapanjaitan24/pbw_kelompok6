// Ambil ID dari URL
const urlParams = new URLSearchParams(window.location.search);
const id = parseInt(urlParams.get("id"));

// Cari produk
const produk = produkList.find(p => p.id === id);

// Jika tidak ada
if (!produk) {
  document.getElementById("detail-nama").textContent = "Produk tidak ditemukan.";
  throw new Error("ID produk tidak ditemukan");
}

// TAMPILKAN DATA
document.getElementById("detail-gambar").src = produk.gambar;
document.getElementById("detail-nama").textContent = produk.nama;
document.getElementById("detail-harga").textContent =
  "Rp " + produk.harga.toLocaleString("id-ID");

document.getElementById("detail-deskripsi").textContent = produk.deskripsi;

// CHECKOUT
document.getElementById("checkout-gambar").src = produk.gambar;
document.getElementById("checkout-nama").textContent = produk.nama;
document.getElementById("checkout-harga").textContent =
  "Rp " + produk.harga.toLocaleString("id-ID");

// Quantity
let qty = 1;

function updateSubtotal() {
  const subtotal = produk.harga * qty;
  document.getElementById("subtotalHarga").textContent =
    "Rp " + subtotal.toLocaleString("id-ID");
  document.getElementById("qtyValue").textContent = qty;
}

updateSubtotal();

document.getElementById("qtyPlus").onclick = () => {
  qty++; updateSubtotal();
};

document.getElementById("qtyMinus").onclick = () => {
  if (qty > 1) qty--;
  updateSubtotal();
};

// Keranjang
document.getElementById("btnKeranjang").onclick = () => {
  let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];

  keranjang.push({ ...produk, jumlah: qty });

  localStorage.setItem("keranjang", JSON.stringify(keranjang));
  alert("Produk ditambahkan ke keranjang!");
};

// Pesan sekarang
document.getElementById("btnPesan").onclick = () => {
  localStorage.setItem(
    "produkDipesan",
    JSON.stringify([{ ...produk, jumlah: qty }])
  );

  window.location.href = "order.html";
};