// Run when DOM is ready to avoid timing issues
window.addEventListener('DOMContentLoaded', () => {
  // Ambil ID dari URL
  const urlParams = new URLSearchParams(window.location.search);
  const id = parseInt(urlParams.get("id"), 10);

  // Cari produk
  const produk = produkList.find(p => p.id === id);

  // Jika tidak ada
  if (!produk) {
    const nameEl = document.getElementById("detail-nama");
    if (nameEl) nameEl.textContent = "Produk tidak ditemukan.";
    console.error('Produk dengan id', id, 'tidak ditemukan');
    return;
  }

  // TAMPILKAN DATA
  const gambarEl = document.getElementById("detail-gambar");
  const namaEl = document.getElementById("detail-nama");
  const hargaEl = document.getElementById("detail-harga");
  const deskripsiEl = document.getElementById("detail-deskripsi");

  if (gambarEl) gambarEl.src = produk.gambar;
  if (namaEl) namaEl.textContent = produk.nama;
  if (hargaEl) hargaEl.textContent = "Rp " + produk.harga.toLocaleString("id-ID");
  if (deskripsiEl) deskripsiEl.textContent = produk.deskripsi;

  // Debug: pastikan produk.spesifikasi ada
  console.debug('Detail produk:', produk);

  // Tampilkan spesifikasi jika ada
  let specContainer = document.getElementById("detail-spesifikasi");
  if (!specContainer) {
    // buat elemen jika tidak ada (fallback)
    const center = document.querySelector('.detail-center');
    if (center) {
      specContainer = document.createElement('ul');
      specContainer.id = 'detail-spesifikasi';
      center.appendChild(specContainer);
    }
  }

  if (specContainer) {
    if (produk.spesifikasi && typeof produk.spesifikasi === 'object') {
      specContainer.innerHTML = ''; // clear
      // ensure the list is visible even if global styles hide lists
      specContainer.style.listStyle = 'disc';
      specContainer.style.marginLeft = '18px';
      specContainer.style.color = '#cfcfcf';
      specContainer.style.paddingLeft = '6px';
      for (const [key, value] of Object.entries(produk.spesifikasi)) {
        const li = document.createElement('li');
        // ubah key menjadi label kapitalized
        const label = key.charAt(0).toUpperCase() + key.slice(1);
        li.textContent = `${label}: ${value}`;
        li.style.marginBottom = '6px';
        li.style.color = '#cfcfcf';
        specContainer.appendChild(li);
      }
    } else {
      specContainer.textContent = '-';
    }
  } else {
    console.warn('Spec container not found and could not be created');
  }

  // CHECKOUT
  const checkoutGambar = document.getElementById("checkout-gambar");
  const checkoutNama = document.getElementById("checkout-nama");
  const checkoutHarga = document.getElementById("checkout-harga");
  if (checkoutGambar) checkoutGambar.src = produk.gambar;
  if (checkoutNama) checkoutNama.textContent = produk.nama;
  if (checkoutHarga) checkoutHarga.textContent = "Rp " + produk.harga.toLocaleString("id-ID");

  // Quantity
  let qty = 1;

  function updateSubtotal() {
    const subtotal = produk.harga * qty;
    const subtotalEl = document.getElementById("subtotalHarga");
    const qtyValueEl = document.getElementById("qtyValue");
    if (subtotalEl) subtotalEl.textContent = "Rp " + subtotal.toLocaleString("id-ID");
    if (qtyValueEl) qtyValueEl.textContent = qty;
  }

  updateSubtotal();

  const plusBtn = document.getElementById("qtyPlus");
  const minusBtn = document.getElementById("qtyMinus");
  if (plusBtn) plusBtn.onclick = () => { qty++; updateSubtotal(); };
  if (minusBtn) minusBtn.onclick = () => { if (qty > 1) qty--; updateSubtotal(); };

  // Keranjang
  const btnKeranjang = document.getElementById("btnKeranjang");
  if (btnKeranjang) btnKeranjang.onclick = () => {
    let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
    keranjang.push({ ...produk, jumlah: qty });
    localStorage.setItem("keranjang", JSON.stringify(keranjang));
    alert("Produk ditambahkan ke keranjang!");
  };

  // Pesan sekarang
  const btnPesan = document.getElementById("btnPesan");
  if (btnPesan) btnPesan.onclick = () => {
    localStorage.setItem("produkDipesan", JSON.stringify([{ ...produk, jumlah: qty }]));
    window.location.href = "order.html";
  };

});

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