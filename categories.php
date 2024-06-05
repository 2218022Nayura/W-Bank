<?php
// koneksi ke database phpmyadmin
$server = "localhost";
$username = "root";
$password = ""; 
$database = "wbank";

// CRUD 

// Create
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    try {
        $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $jenis_kartu = $_POST["jenis_kartu"];
        $kategori = $_POST["kategori"];
        $deskripsi = $_POST["deskripsi"];
        $harga = $_POST["harga"];

        $stmt = $conn->prepare("INSERT INTO kategori (ID_categories, jenis_kartu, kategori, deskripsi, harga) VALUES (DEFAULT, :jenis_kartu, :kategori, :deskripsi, :harga)");
        $stmt->bindParam(':jenis_kartu', $jenis_kartu);
        $stmt->bindParam(':kategori', $kategori);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->bindParam(':harga', $harga);
        $stmt->execute();

        header("Location: categories.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Read
$categories = [];
try {
    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM kategori");
    $stmt->execute();

    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    try {
        $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_POST["id"];
        $jenis_kartu = $_POST["jenis_kartu"];
        $kategori = $_POST["kategori"];
        $deskripsi = $_POST["deskripsi"];
        $harga = $_POST["harga"];

        $stmt = $conn->prepare("UPDATE kategori SET jenis_kartu=:jenis_kartu, kategori=:kategori, deskripsi=:deskripsi, harga=:harga WHERE ID_categories=:id");
        $stmt->bindParam(':jenis_kartu', $jenis_kartu);
        $stmt->bindParam(':kategori', $kategori);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: categories.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Delete
if (isset($_POST["delete"])) {
    try {
        $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_POST["id"];

        $stmt = $conn->prepare("DELETE FROM kategori WHERE ID_categories=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: categories.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="kategori.css">
    <title>Categories</title>
</head>
<body>
    <div class="container">
        <h1>Categories</h1>
        <a href="admin.php" class="back-btn">Back to Admin</a>
        <a href="cetak_pdf.php" class="back-btn">Cetak PDF</a>
        <table id="category-table">
            <thead>
                <tr>
                    <th>Jenis Kartu</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo $category['jenis_kartu']; ?></td>
                        <td><?php echo $category['kategori']; ?></td>
                        <td><?php echo $category['deskripsi']; ?></td>
                        <td><?php echo $category['harga']; ?></td>
                        <td>
                            <form method="POST" style="display: inline-block;">
                                <input type="hidden" name="id" value="<?php echo $category['ID_categories']; ?>">
                                <input type="submit" name="delete" value="Delete">
                            </form>
                            <button onclick="editRow(<?php echo $category['ID_categories']; ?>, '<?php echo $category['jenis_kartu']; ?>', '<?php echo $category['kategori']; ?>', '<?php echo $category['deskripsi']; ?>', '<?php echo $category['harga']; ?>')">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form method="POST">
            <input type="hidden" name="id" value="">
            <input type="text" name="jenis_kartu" placeholder="Jenis Kartu" required>
            <input type="text" name="kategori" placeholder="Kategori" required>
            <input type="text" name="deskripsi" placeholder="Deskripsi" required>
            <input type="text" name="harga" placeholder="Harga" required>
            <button type="submit" name="add">Tambah Data</button>
            <button type="submit" name="update" style="display: none;">Update Data</button>
        </form>
    </div>

    <script>
        function editRow(id, jenis_kartu, kategori, deskripsi, harga) {
            document.querySelector('input[name="id"]').value = id;
            document.querySelector('input[name="jenis_kartu"]').value = jenis_kartu;
            document.querySelector('input[name="kategori"]').value = kategori;
            document.querySelector('input[name="deskripsi"]').value = deskripsi;
            document.querySelector('input[name="harga"]').value = harga;
            document.querySelector('button[name="add"]').style.display = 'none';
            document.querySelector('button[name="update"]').style.display = 'inline-block';
        }
    </script>
</body>
</html>
