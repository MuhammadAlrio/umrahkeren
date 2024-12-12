<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "umrahkeren");
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Ambil ID group dari query string
$group_id = isset($_GET['group_id']) ? (int)$_GET['group_id'] : 1;  // Default 1 jika tidak ada

// Query untuk mendapatkan kamar berdasarkan group_id
$sql = "SELECT id, kamar FROM sistembooking WHERE booking_group_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $group_id); // Menggunakan group_id sebagai parameter
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = [
            'id' => $row['id'],  // ID kamar
            'kamar' => $row['kamar']  // Nama kamar
        ];
    }
    echo json_encode(['rooms' => $rooms]);
} else {
    echo json_encode(['error' => 'No rooms available for this group']);
}

$conn->close();
?>
