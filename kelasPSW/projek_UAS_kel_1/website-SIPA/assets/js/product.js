// Data dummy produk
const products = [
  {
    id: 1,
    name: "Dimsum Original",
    image: "assets/images/trending-01.jpg",
    price: 24,
    oldPrice: 29,
    description: "Dimsum original dengan rasa klasik dan tekstur lembut.",
    longDescription: "Dimsum original kami dibuat dengan resep turun-temurun. Cocok untuk semua kalangan dan dapat disajikan dalam berbagai suasana. Bahan berkualitas dan dikukus sempurna."
  },
  {
    id: 2,
    name: "Dimsum Mentai Spicy Cheese",
    image: "assets/images/trending-02.jpg",
    price: 30,
    oldPrice: 35,
    description: "Dimsum dengan topping mentai dan keju pedas.",
    longDescription: "Untuk pencinta rasa pedas dan creamy, dimsum ini memiliki topping mentai spicy cheese yang menggugah selera. Cocok sebagai cemilan atau hidangan utama."
  },
  {
    id: 3,
    name: "Dimsum Family Pack",
    image: "assets/images/trending-03.jpg",
    price: 60,
    oldPrice: 70,
    description: "Paket keluarga isi 20 pcs dimsum.",
    longDescription: "Berisi berbagai varian dimsum seperti ayam, udang, dan jamur. Cocok untuk keluarga atau acara kumpul bersama. Hemat dan praktis."
  }
];

// Ambil ID produk dari URL
const params = new URLSearchParams(window.location.search);
const productId = parseInt(params.get("id"));

// Cari produk berdasarkan ID
const product = products.find(p => p.id === productId);

if (product) {
  // Isi elemen dengan data produk
  document.getElementById("product-title").textContent = product.name;
  document.getElementById("product-breadcrumb").textContent = product.name;
  document.getElementById("product-name").textContent = product.name;
  document.getElementById("product-image").src = product.image;
  document.getElementById("new-price").textContent = `$${product.price}`;
  document.getElementById("old-price").textContent = `$${product.oldPrice}`;
  document.getElementById("product-description").textContent = product.description;
  document.getElementById("product-long-description").textContent = product.longDescription;
} else {
  // Jika ID tidak ditemukan
  document.getElementById("product-title").textContent = "Produk tidak ditemukan";
  document.getElementById("product-name").textContent = "Produk tidak ditemukan";
  document.getElementById("product-description").textContent = "";
  document.getElementById("product-long-description").textContent = "";
}
