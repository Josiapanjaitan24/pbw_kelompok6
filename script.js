// Simpan produk ke localStorage untuk keranjang
function tambahKeKeranjang(nama, harga, gambar) {
  let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
  keranjang.push({ nama, harga, gambar });
  localStorage.setItem('keranjang', JSON.stringify(keranjang));
  alert(`${nama} telah dimasukkan ke keranjang 🛒`);
}

// Simpan produk sementara untuk halaman pesanan
function pesanSekarang(nama, harga, gambar) {
  localStorage.setItem('produk_dipesan', JSON.stringify({ nama, harga, gambar }));
  window.location.href = 'order.html';
}