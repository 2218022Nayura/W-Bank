<?php
session_start();

// Jika pengguna belum login, redirect ke halaman login
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

// Memeriksa waktu terakhir login
if (isset($_SESSION["last_login_time"])) {
    $last_login_time = $_SESSION["last_login_time"];
    $current_time = time();
    $time_diff = $current_time - $last_login_time;

    // Jika waktu terakhir login lebih dari 10 detik yang lalu, tampilkan pesan
    if ($time_diff > 10) {
        // Unset session dan tampilkan pesan
        session_unset();
        session_destroy();
        $error = "Waktu login telah habis. Silahkan login ulang.";
        header("Location: login.php");
        exit;
    }
}

// Set waktu login terakhir
$_SESSION["last_login_time"] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="sidebar">
        <div class="logo-details">
            <img src="wall2.png" alt="W-Bank Logo"> <!-- Gambar Logo -->
            <span class="logo_name">W-Bank</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="#" class="active">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="categories.php" class="menu-link">
                    <i class="bx bx-box"></i>
                    <span class="links_name">Categories</span>
                </a>
            </li>
            <li>
                <a href="transaction.php" class="menu-link">
                    <i class="bx bx-list-ul"></i>
                    <span class="links_name">Transaction</span>
                </a>
            </li>
            <li>
                <a href="index.php">
                    <i class="bx bx-arrow-back"></i>
                    <span class="links_name">Back to Home</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
            </div>
            <div class="profile-details">
                <span class="admin_name">W-Bank Admin</span>
            </div>
        </nav>
        <div class="home-content">
            <h1>Welcome Admin</h1>
            <p>This is your dashboard. Manage your categories and transactions here.</p>
        </div>
    </section>
    <!-- Input checkbox sebagai trigger pop-up -->
    <input type="checkbox" id="popup-toggle">
    <!-- Label untuk strip 3 -->
    <label for="popup-toggle" class="strip">☰</label>
    <!-- Pop-up -->
    <div class="popup" id="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">×</span>
            <h2>Transaction Details</h2>
            <div id="transaction-details"></div>
        </div>
    </div>

    <script>
        // Fungsi untuk mengambil data transaksi dari server secara asinkron
        async function fetchTransactions() {
            try {
                const response = await fetch('https://api.example.com/transactions');
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Error fetching transactions:', error);
                return [];
            }
        }

        // Fungsi untuk menampilkan data transaksi dalam pop-up
        async function showTransactionPopup() {
            const transactions = await fetchTransactions();
            const popupContent = document.getElementById('transaction-details');
            popupContent.innerHTML = ''; // Kosongkan konten pop-up sebelum menambahkan data baru
            transactions.forEach(transaction => {
                const transactionElement = document.createElement('div');
                transactionElement.innerHTML = `<p>${transaction.id}: ${transaction.description}</p>`;
                popupContent.appendChild(transactionElement);
            });
            // Tampilkan pop-up setelah data dimuat
            document.getElementById('popup').style.display = 'block';
        }

        // Fungsi untuk menutup pop-up
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        // Event listener untuk menampilkan pop-up saat label di klik
        document.querySelector('.strip').addEventListener('click', showTransactionPopup);
    </script>
</body>
</html>
