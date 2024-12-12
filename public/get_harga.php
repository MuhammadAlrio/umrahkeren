<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "umrahkeren");
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$date_id = $_GET['date_id'] ?? '';
$room_id = $_GET['room_id'] ?? '';
$program_id = $_GET['program_id'] ?? '';

$sql = "SELECT 
    (p.base_price + rt.price_adjustment) as total_price
FROM bookings b
JOIN packages p ON b.package_id = p.id
JOIN room_types rt ON rt.id = ?
WHERE b.id = ? AND p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $room_id, $date_id, $program_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['price' => $row['total_price']]);
} else {
    echo json_encode(['error' => 'No price found']);
}

$conn->close();
?>
