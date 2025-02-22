<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Jika sudah login, tampilkan konten halaman shop
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop UmrahKeren</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/logoumrah.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/logoumrah.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/logoumrah.png">
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/logoumrah.png">
        <link rel="manifest" href="assets/img/favicons/manifest.json">
        <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
        <meta name="theme-color" content="#ffffff">
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="shop/css/styles.css" rel="stylesheet" />

    <style>
    .user-info {
        margin-left: 20px; /* Adds space between the user info and other elements */
    }

    /* Optional: add padding for better spacing inside user-info */
    .user-info a {
        margin-left: 10px; /* Adds space between the welcome text and the login/logout link */
    }
</style>
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.html">
                    <img src="assets/img/gallery/logoumrah.png" alt="Logo" style="height: 40px;">
                  </a>                  
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="sistemseat.php">Booking</a></li>
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
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
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
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Paket UmrahKeren 2025</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Different Way to Umrah</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="assets/img/img/paketjanuari.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Paket Umrah Januari</h5>
                                    <!-- Product price-->
                                    <p>Sisa Seat: <span id="seats">
                            <?php
                            $conn = new mysqli("localhost", "root", "", "umrahkeren");
                            if ($conn->connect_error) {
                                echo "Error connecting to database";
                            } else {
                                $sql = "SELECT seats_available FROM bookings WHERE id = 1";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    echo $row['seats_available'];
                                } else {
                                    echo "N/A";
                                }
                                $conn->close();
                            }
                            ?>
                            </span></p>
                            <p>Harga Rp. <span id="harga">
                                <?php
                                $conn = new mysqli("localhost", "root", "", "umrahkeren");
                                if ($conn->connect_error) {
                                    echo "Error connecting to database";
                                } else {
                                    $sql = "SELECT total_price FROM bookings WHERE id = 1";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        // Format currency biar kece
                                        echo number_format($row['total_price'], 0, ',', '.');
                                    } else {
                                        echo "N/A";
                                    }
                                    $conn->close();
                                }
                                ?>
                            </span></p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="umrahjanuari.php">View</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="assets/img/img/paketfebuari.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Paket Umrah Febuari</h5>
                                    <!-- Product price-->
                                    <p>Sisa Seat: <span id="seats">
                                    <?php
                                    $conn = new mysqli("localhost", "root", "", "umrahkeren");
                                    if ($conn->connect_error) {
                                        echo "Error connecting to database";
                                    } else {
                                        $sql = "SELECT seats_available FROM bookings WHERE id = 2";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            echo $row['seats_available'];
                                        } else {
                                            echo "N/A";
                                        }
                                        $conn->close();
                                    }
                                    ?>
                                    <p>
                                    Harga: 
                                    <span style="text-decoration: line-through; color: black;">
                                        Rp. 
                                        <?php
                                        $conn = new mysqli("localhost", "root", "", "umrahkeren");
                                        if ($conn->connect_error) {
                                            echo "Error connecting to database";
                                        } else {
                                            $sql = "SELECT total_price FROM bookings WHERE id = 2";
                                            $result = $conn->query($sql);

                                            if ($result && $result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $harga_asli = $row['total_price'];
                                                $harga_diskon = $harga_asli - 5000000; //diskon

                                                // Menampilkan harga asli dengan format Rp dan dicoret
                                                echo number_format($harga_asli, 0, ',', '.');
                                                ?>
                                    </span>
                                    <span style="color: black; font-weight: bold;">
                                        Rp. <?php echo number_format($harga_diskon, 0, ',', '.'); ?>
                                    </span>
                                    <?php
                                            } else {
                                                echo "N/A";
                                            }
                                            $conn->close();
                                        }
                                    ?>
                                </p>
                        </span></p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="umrahfebuari.php">view</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="assets/img/img/paketmaret.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Paket Umrah Maret</h5>
                                    <!-- Product price-->
                                    <p>Sisa Seat: <span id="seats">
                                    <?php
                                    $conn = new mysqli("localhost", "root", "", "umrahkeren");
                                    if ($conn->connect_error) {
                                        echo "Error connecting to database";
                                    } else {
                                        $sql = "SELECT seats_available FROM bookings WHERE id = 3";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            echo $row['seats_available'];
                                        } else {
                                            echo "N/A";
                                        }
                                        $conn->close();
                                    }
                                    ?>
                                    <p>
                                    Harga: 
                                    <span style="text-decoration: line-through; color: black;">
                                        Rp. 
                                        <?php
                                        $conn = new mysqli("localhost", "root", "", "umrahkeren");
                                        if ($conn->connect_error) {
                                            echo "Error connecting to database";
                                        } else {
                                            $sql = "SELECT total_price FROM bookings WHERE id = 3";
                                            $result = $conn->query($sql);

                                            if ($result && $result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $harga_asli = $row['total_price'];
                                                $harga_diskon = $harga_asli - 5000000; //diskon

                                                // Menampilkan harga asli dengan format Rp dan dicoret
                                                echo number_format($harga_asli, 0, ',', '.');
                                                ?>
                                    </span>
                                    <span style="color: black; font-weight: bold;">
                                        Rp. <?php echo number_format($harga_diskon, 0, ',', '.'); ?>
                                    </span>
                                    <?php
                                            } else {
                                                echo "N/A";
                                            }
                                            $conn->close();
                                        }
                                    ?>
                                </p>
                            </span></p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="umrahmaret.php">View</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="assets/img/img/paketapril.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Paket Umrah April</h5>
                                    <!-- Product price-->
                                    <p>Sisa Seat: <span id="seats">
                            <?php
                            $conn = new mysqli("localhost", "root", "", "umrahkeren");
                            if ($conn->connect_error) {
                                echo "Error connecting to database";
                            } else {
                                $sql = "SELECT seats_available FROM bookings WHERE id = 4";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    echo $row['seats_available'];
                                } else {
                                    echo "N/A";
                                }
                                $conn->close();
                            }
                            ?>
                            </span></p>
                            <p>Harga Rp. <span id="harga">
                                <?php
                                $conn = new mysqli("localhost", "root", "", "umrahkeren");
                                if ($conn->connect_error) {
                                    echo "Error connecting to database";
                                } else {
                                    $sql = "SELECT total_price FROM bookings WHERE id = 4";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        // Format currency biar kece
                                        echo number_format($row['total_price'], 0, ',', '.');
                                    } else {
                                        echo "N/A";
                                    }
                                    $conn->close();
                                }
                                ?>
                            </span></p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="umrahapril.php">View</a></div>
                            </div>
                        </div>
                    </div>
                    
                    
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Umrahkeren2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="shop/js/scripts.js"></script>
    </body>
</html>
