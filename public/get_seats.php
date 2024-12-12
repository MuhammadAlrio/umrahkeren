<?php
$conn = new mysqli("localhost", "root", "", "umrahkeren");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'] ?? '';

$sql = "SELECT seats_available, total_seats FROM bookings WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $seatsAvailable = $row['seats_available'];
    $totalSeats = $row['total_seats'];
    $percentage = ($seatsAvailable / $totalSeats) * 100;
    
    echo json_encode([
        'seats_available' => $seatsAvailable,
        'total_seats' => $totalSeats,
        'percentage' => $percentage
    ]);
} else {
    echo json_encode([
        'error' => 'No booking found',
        'seats_available' => 0,
        'total_seats' => 0,
        'percentage' => 0
    ]);
}

$conn->close();
?>


