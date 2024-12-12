<?php
session_start();
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "umrahkeren");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil informasi produk berdasarkan ID
$sql = "SELECT id, name, price FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Jika produk ditemukan
if ($product) {
    $cart_item = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $quantity
    ];

    // Menambahkan produk ke keranjang sesi
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $cart_item;
    }

    // Menghitung total item dalam keranjang
    $total_items = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['quantity'];
    }

    // Kirimkan respon
    echo json_encode(['message' => 'Produk berhasil ditambahkan ke keranjang!', 'total_items' => $total_items]);
} else {
    echo json_encode(['message' => 'Produk tidak ditemukan!']);
}

$conn->close();
?>
