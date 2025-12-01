// Produk default (10 produk awal)
const DEFAULT_PRODUCTS = [
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

// Main function untuk load dan display produk detail
async function loadProductDetail() {
  // Get product ID dari URL
  const urlParams = new URLSearchParams(window.location.search);
  const productId = parseInt(urlParams.get("id"), 10);
  
  console.log('Loading product ID:', productId);
  
  // Start dengan produk default
  let allProducts = [];
  let dbProducts = [];
  
  // Try load dari database TERLEBIH DAHULU
  try {
    const response = await fetch('../back-end/get_products.php');
    if (response.ok) {
      const data = await response.json();
      console.log('Database products loaded:', data);
      
      if (data && Array.isArray(data) && data.length > 0) {
        // Format database products
        dbProducts = data.map(item => {
          let spek = item.spesifikasi;
          if (typeof spek === 'string') {
            try {
              spek = JSON.parse(spek);
            } catch (e) {
              spek = { bahan: '', ukuran: '', warna: '', perawatan: '' };
            }
          }
          return {
            id: parseInt(item.id),
            nama: item.nama,
            harga: parseInt(item.harga),
            gambar: `../uploads/produk/${item.foto}`,
            deskripsi: item.deskripsi,
            spesifikasi: spek || { bahan: '', ukuran: '', warna: '', perawatan: '' }
          };
        });
        console.log('Formatted DB products:', dbProducts);
      }
    }
  } catch (error) {
    console.error('Error fetching database products:', error);
  }
  
  // PRIORITAS: Database products DULUAN, baru default products
  // Ini memastikan produk baru dari database tidak ketimpa produk default
  allProducts = [...dbProducts, ...DEFAULT_PRODUCTS];
  
  console.log('All products (db first + default):', allProducts);
  console.log('Total products:', allProducts.length);
  
  // Debug-friendly summary table
  try {
    const summary = allProducts.map(p => ({ 
      id: p.id, 
      nama: p.nama, 
      sumber: (dbProducts.some(db => db.id === p.id) ? 'db' : 'default') 
    }));
    console.group('detail-new debug');
    console.log('Product count:', allProducts.length);
    console.table(summary);
    console.groupEnd();
  } catch (e) {
    console.debug('Could not print debug table', e);
  }
  
  // Cari produk
  const product = allProducts.find(p => p.id === productId);
  console.log('Product found:', product);
  console.log('Product source:', product ? (dbProducts.some(db => db.id === product.id) ? 'DATABASE' : 'DEFAULT') : 'NOT FOUND');
  
  if (!product) {
    document.getElementById('detail-nama').textContent = '❌ Produk tidak ditemukan (ID: ' + productId + ')';
    console.error('Product ID ' + productId + ' not found in ' + allProducts.length + ' products');
    return;
  }
  
  // Tampilkan produk
  displayProduct(product);
}

function displayProduct(product) {
  // Gambar
  const imgEl = document.getElementById('detail-gambar');
  if (imgEl) {
    imgEl.src = product.gambar;
    imgEl.onerror = () => imgEl.src = '../src/img/no-image.jpg';
  }
  
  // Nama
  const nameEl = document.getElementById('detail-nama');
  if (nameEl) nameEl.textContent = product.nama;
  
  // Harga
  const priceEl = document.getElementById('detail-harga');
  if (priceEl) priceEl.textContent = 'Rp ' + product.harga.toLocaleString('id-ID');
  
  // Deskripsi
  const descEl = document.getElementById('detail-deskripsi');
  if (descEl) descEl.textContent = product.deskripsi;
  
  // Spesifikasi
  const specUl = document.getElementById('detail-spesifikasi');
  if (specUl) {
    specUl.innerHTML = '';
    if (product.spesifikasi && typeof product.spesifikasi === 'object') {
      for (const [key, value] of Object.entries(product.spesifikasi)) {
        if (value) {
          const li = document.createElement('li');
          li.textContent = capitalize(key) + ': ' + value;
          li.style.marginBottom = '6px';
          li.style.color = '#cfcfcf';
          specUl.appendChild(li);
        }
      }
    }
  }
  
  // Checkout card
  const checkoutImg = document.getElementById('checkout-gambar');
  if (checkoutImg) {
    checkoutImg.src = product.gambar;
    checkoutImg.onerror = () => checkoutImg.src = '../src/img/no-image.jpg';
  }
  
  const checkoutName = document.getElementById('checkout-nama');
  if (checkoutName) checkoutName.textContent = product.nama;
  
  const checkoutPrice = document.getElementById('checkout-harga');
  if (checkoutPrice) checkoutPrice.textContent = 'Rp ' + product.harga.toLocaleString('id-ID');
  
  // Setup buttons
  setupCheckoutButtons(product);
}

function setupCheckoutButtons(product) {
  let qty = 1;
  
  // Update subtotal
  const updateSubtotal = () => {
    const subtotal = product.harga * qty;
    const subtotalEl = document.getElementById('subtotalHarga');
    const qtyEl = document.getElementById('qtyValue');
    if (subtotalEl) subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    if (qtyEl) qtyEl.textContent = qty;
  };
  
  updateSubtotal();
  
  // Plus button
  const plusBtn = document.getElementById('qtyPlus');
  if (plusBtn) plusBtn.onclick = () => { qty++; updateSubtotal(); };
  
  // Minus button
  const minusBtn = document.getElementById('qtyMinus');
  if (minusBtn) minusBtn.onclick = () => { if (qty > 1) qty--; updateSubtotal(); };
  
  // Cart button
  const cartBtn = document.getElementById('btnKeranjang');
  if (cartBtn) {
    cartBtn.onclick = () => {
      let cart = JSON.parse(localStorage.getItem('keranjang')) || [];
      cart.push({ ...product, jumlah: qty });
      localStorage.setItem('keranjang', JSON.stringify(cart));
      alert('✓ ' + product.nama + ' ditambahkan ke keranjang!');
    };
  }
  
  // Order button
  const orderBtn = document.getElementById('btnPesan');
  if (orderBtn) {
    orderBtn.onclick = () => {
      localStorage.setItem('produkDipesan', JSON.stringify([{ ...product, jumlah: qty }]));
      window.location.href = 'order.html';
    };
  }
}

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

// Load saat DOM ready
document.addEventListener('DOMContentLoaded', loadProductDetail);
