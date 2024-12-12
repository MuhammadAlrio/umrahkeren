<?php
// config.php - Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'umrahkeren';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Umrah Keren</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/logoumrah.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/logoumrah.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/logoumrah.png">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="theme-color" content="#ffffff">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS -->
    <link href="shop/css/styles1.css" rel="stylesheet" />
</head>
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.html">
                <img src="assets/img/gallery/logoumrah.png" alt="Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Booking</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                            <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                <div class="user-info">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Display the username if logged in -->
                        <span>Welcome, <?php echo $_SESSION['username']; ?></span>
                        <a href="logout.php">Logout</a>
                    <?php else: ?>
                        <!-- Display Login link if not logged in -->
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <img class="card-img-top mb-5 mb-md-0" src="assets/img/img/paketmaret.jpg" alt="..." />
                </div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder">Paket UmrahKeren Maret</h1>
                    <h3 class="display-5 fw-bolder">
                        <?php
                        // Get base package price
                        $sql = "SELECT (p.base_price + rt.price_adjustment) as total_price 
                                FROM packages p 
                                JOIN bookings b ON p.id = b.package_id
                                JOIN room_types rt ON b.room_type_id = rt.id
                                WHERE b.id = 4";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo "IDR " . number_format($row['total_price'], 0, ',', '.');
                        } else {
                            echo "N/A";
                        }
                        ?>
                    </h3>

                    <!-- Available Seats -->
                    <?php
                    $sql = "SELECT seats_available, total_seats FROM bookings WHERE id = 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $seatsAvailable = $row['seats_available'];
                        $totalSeats = $row['total_seats'];
                        $percentage = ($seatsAvailable / $totalSeats) * 100;
                    } else {
                        $seatsAvailable = "N/A";
                        $percentage = 0;
                    }
                    ?>

                    <p>Sisa Seat: <span id="seats"><?php echo $seatsAvailable; ?></span></p>
                    <div style="width: 100%; background-color: #ddd; height: 20px; border-radius: 5px;">
                        <div id="progressBar" style="width: <?php echo $percentage; ?>%; background-color: #333333; height: 100%; border-radius: 5px;"></div>
                    </div>

                    <p class="lead"></p>
                    
                    <!-- Booking Form -->
                    <form id="bookingForm">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Program Hari</th>
                                    <td>
                                        <select class="form-select" id="programSelect" name="program">
                                            <?php
                                            $sql = "SELECT id, program FROM packages";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo '<option value="'.$row['id'].'">'.$row['program'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Bandara Keberangkatan</th>
                                    <td>
                                        <select class="form-select" id="airportSelect" name="bandara">
                                            <option value="CGK">Soekarno-Hatta International Airport (CGK)</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal Keberangkatan</th>
                                    <td>
                                        <select class="form-select" name="tanggal" id="tanggalSelect">
                                            <?php
                                            $sql = "SELECT id, tanggal FROM bookings WHERE seats_available > 0";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo '<option value="'.$row['id'].'">'.date('Y-m-d', strtotime($row['tanggal'])).'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Pilihan Kamar</th>
                                    <td>
                                        <select class="form-select" name="kamar" id="kamarSelect">
                                            <?php
                                            $sql = "SELECT id, name FROM room_types";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Total</th>
                                    <td>
                                        <p id="harga">IDR 0</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                    <!-- Action Buttons -->
                    <div class="d-grid mt-3">
                        <a href="https://wa.me/+6287838234365?text=Hallo.%20Saya%20mau%20konsul%20mengenai%20paket%20umrah" 
                           class="btn" style="background-color: #333333; color: white; border: none;">
                            Konsultasi Paket
                        </a>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-start">
                            <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 3rem" />
                            <button class="btn btn-outline-dark" type="button">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update price when room type changes
            document.getElementById("kamarSelect").addEventListener("change", updatePrice);
            document.getElementById("programSelect").addEventListener("change", updatePrice);
            document.getElementById("tanggalSelect").addEventListener("change", updatePrice);

            function updatePrice() {
                const selectedDateId = document.getElementById("tanggalSelect").value;
                const selectedRoom = document.getElementById("kamarSelect").value;
                const selectedProgram = document.getElementById("programSelect").value;

                fetch(`get_harga.php?date_id=${selectedDateId}&room_id=${selectedRoom}&program_id=${selectedProgram}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            document.getElementById('harga').innerHTML = 'Harga tidak tersedia';
                        } else {
                            document.getElementById('harga').innerHTML = 
                                'IDR ' + new Intl.NumberFormat('id-ID').format(data.price);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('harga').innerHTML = 'Error mengambil harga';
                    });

                // Update available seats
                fetch(`get_seats.php?id=${selectedDateId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("seats").innerText = data.seats_available;
                        document.getElementById('progressBar').style.width = data.percentage + '%';
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
</body>
</html>