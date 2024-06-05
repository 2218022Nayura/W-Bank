<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wbank";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk transfer ke user lain
if (isset($_POST['transfer'])) {
    $username_to = $_POST['username_to'];
    $amount = $_POST['amount'];

    // Ambil saldo pengguna
    $sql = "SELECT saldo FROM users WHERE username = '{$_SESSION['username']}'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $saldo = $row['saldo'];

    // Validasi jumlah transfer tidak melebihi saldo
    if ($amount > $saldo) {
        echo "Jumlah transfer melebihi saldo.";
    } else {
        // Kurangi saldo pengguna
        $saldo -= $amount;

        // Update saldo pengguna
        $sql = "UPDATE users SET saldo = $saldo WHERE username = '{$_SESSION['username']}'";
        $conn->query($sql);

        // Tambah saldo pengguna tujuan (asumsi tabel users memiliki kolom saldo)
        $sql = "UPDATE users SET saldo = saldo + $amount WHERE username = '$username_to'";
        $conn->query($sql);

        echo "Transfer berhasil.";
    }
}

// Fungsi untuk cek saldo
if (isset($_POST['check_balance'])) {
    $sql = "SELECT saldo FROM users WHERE username = '{$_SESSION['username']}'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $saldo = $row['saldo'];
    echo "<script>alert('Saldo Anda saat ini: $saldo');</script>";
}

// Fungsi untuk setor tunai
if (isset($_POST['deposit'])) {
    $deposit_amount = $_POST['deposit_amount'];

    // Tambahkan saldo
    $sql = "UPDATE users SET saldo = saldo + $deposit_amount WHERE username = '{$_SESSION['username']}'";
    $conn->query($sql);

    echo "<script>alert('Setor tunai berhasil.');</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - W-Bank</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard - W-Bank</h1>

        <h2>Transfer ke User Lain</h2>
        <form action="dashboard.php" method="post">
            <label for="username_to">Username Tujuan:</label>
            <input type="text" id="username_to" name="username_to" required><br>
            <label for="amount">Jumlah yang ingin ditransfer:</label>
            <input type="number" id="amount" name="amount" required><br>
            <input type="submit" name="transfer" value="Transfer">
        </form>

        <h2>Cek Saldo</h2>
        <form action="dashboard.php" method="post">
            <input type="submit" name="check_balance" value="Cek Saldo">
        </form>

        <h2>Setor Tunai</h2>
        <form action="dashboard.php" method="post">
            <label for="deposit_amount">Jumlah yang ingin disetor:</label>
            <input type="number" id="deposit_amount" name="deposit_amount" required><br>
            <input type="submit" name="deposit" value="Setor Tunai">
        </form>

        <!-- Tombol logout -->
        <form action="index.php" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>

    </div>
</body>
</html>
