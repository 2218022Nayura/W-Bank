<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wbank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insert'])) {
        // Insert data
        $nama = $_POST['nama'];
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        $jumlah_transaksi = $_POST['jumlah_transaksi'];
        $kategori_transaksi = $_POST['kategori_transaksi'];
        $status = $_POST['status'];

        $sql = "INSERT INTO transactions (nama, tanggal_transaksi, jumlah_transaksi, kategori_transaksi, status, saldo) 
                VALUES ('$nama', '$tanggal_transaksi', '$jumlah_transaksi', '$kategori_transaksi', '$status', '0')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Get the last inserted ID
        $last_id = $conn->insert_id;
        $sql = "SELECT transactions.*, username AS user_name, users.saldo AS user_saldo FROM transactions JOIN users ON ID_transaction= username WHERE ID_transaction = $last_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $transaction = $row;
        ?>
            <script>
                const tbody = document.querySelector('tbody');
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-id', <?php echo $transaction['ID_transaction']; ?>);
                newRow.innerHTML = `
                    <td class="nama"><?php echo htmlspecialchars($transaction['user_name']); ?></td>
                    <td class="saldo"><?php echo htmlspecialchars($transaction['user_saldo']); ?></td>
                    <td class="tanggal_transaksi"><?php echo htmlspecialchars($transaction['tanggal_transaksi']); ?></td>
                    <td class="jumlah_transaksi"><?php echo htmlspecialchars($transaction['jumlah_transaksi']); ?></td>
                    <td class="kategori_transaksi"><?php echo htmlspecialchars($transaction['kategori_transaksi']); ?></td>
                    <td class="status"><?php echo htmlspecialchars($transaction['status']); ?></td>
                    <td class="action-buttons">
                        <button class="edit-btn">Edit</button>
                        <form action="transaction.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaction['ID_transaction']); ?>">
                            <button type="submit" name="delete" class="delete-btn">Delete</button>
                        </form>
                        <button class="save-btn" style="display:none;">Save</button>
                    </td>
                `;
                tbody.appendChild(newRow);
            </script>
        <?php
        }
    } elseif (isset($_POST['edit'])) {
        // Edit data
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $tanggal_transaksi = $_POST['tanggal_transaksi'];
        $jumlah_transaksi = $_POST['jumlah_transaksi'];
        $kategori_transaksi = $_POST['kategori_transaksi'];
        $status = $_POST['status'];

        $sql = "UPDATE transactions SET nama='$nama', tanggal_transaksi='$tanggal_transaksi', jumlah_transaksi='$jumlah_transaksi', kategori_transaksi='$kategori_transaksi', status='$status' WHERE ID_transaction='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Delete data
        $id = $_POST['id'];

        // Check if ID is valid
        if (is_numeric($id) && $id > 0) {
            $sql = "DELETE FROM transactions WHERE ID_transaction='$id'";

            if ($conn->query($sql) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Invalid ID.";
        }
    }
}

$transactions = [];
$sql = "SELECT transactions.*, username AS user_name, users.saldo AS user_saldo FROM transactions JOIN users ON ID_transaction= username";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="transaksi.css">
    <title>Transactions</title>
    <style>
        .edit-input {
            width: 100%;
            box-sizing: border-box;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin.php" class="back-btn">Back to Admin</a>
        <h1>Transactions</h1>
        <form action="transaction.php" method="POST" class="insert-form">
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="date" name="tanggal_transaksi" placeholder="Tanggal Transaksi" required>
            <input type="number" name="jumlah_transaksi" placeholder="Jumlah Transaksi" required>
            <input type="text" name="kategori_transaksi" placeholder="Kategori Transaksi" required>
            <input type="text" name="status" placeholder="Status" required>
            <button type="submit" name="insert">Insert Data</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Saldo</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jumlah Transaksi</th>
                    <th>Kategori Transaksi</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($transactions as $transaction) : ?>
                <tr data-id="<?php echo $transaction['ID_transaction']; ?>">
                    <td class="nama"><?php echo htmlspecialchars($transaction['user_name']); ?></td>
                    <td class="saldo"><?php echo htmlspecialchars($transaction['user_saldo']); ?></td>
                    <td class="tanggal_transaksi"><?php echo htmlspecialchars($transaction['tanggal_transaksi']); ?></td>
                    <td class="jumlah_transaksi"><?php echo htmlspecialchars($transaction['jumlah_transaksi']); ?></td>
                    <td class="kategori_transaksi"><?php echo htmlspecialchars($transaction['kategori_transaksi']); ?></td>
                    <td class="status"><?php echo htmlspecialchars($transaction['status']); ?></td>
                    <td class="action-buttons">
                        <button class="edit-btn">Edit</button>
                        <form action="transaction.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($transaction['ID_transaction']); ?>">
                            <button type="submit" name="delete" class="delete-btn">Delete</button>
                        </form>
                        <button class="save-btn" style="display:none;">Save</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const row = e.target.closest('tr');
                row.querySelectorAll('td').forEach(td => {
                    const className = td.className;
                    if (className && className !== 'action-buttons') {
                        const value = td.innerText;
                        td.innerHTML = `<input type="text" name="${className}" value="${value}" class="edit-input">`;
                    }
                });
                row.querySelector('.edit-btn').style.display = 'none';
                row.querySelector('.delete-btn').style.display = 'none';
                row.querySelector('.save-btn').style.display = 'inline-block';
            });
        });

        document.querySelectorAll('.save-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const row = e.target.closest('tr');
                const id = row.dataset.id;
                const nama = row.querySelector('input[name="nama"]').value;
                const tanggal_transaksi = row.querySelector('input[name="tanggal_transaksi"]').value;
                const jumlah_transaksi = row.querySelector('input[name="jumlah_transaksi"]').value;
                const kategori_transaksi = row.querySelector('input[name="kategori_transaksi"]').value;
                const status = row.querySelector('input[name="status"]').value;

                const formData = new FormData();
                formData.append('id', id);
                formData.append('nama', nama);
                formData.append('tanggal_transaksi', tanggal_transaksi);
                formData.append('jumlah_transaksi', jumlah_transaksi);
                formData.append('kategori_transaksi', kategori_transaksi);
                formData.append('status', status);
                formData.append('edit', true);

                fetch('transaction.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                .then(data => {
                    console.log(data);
                    row.querySelector('.nama').innerText = nama;
                    row.querySelector('.tanggal_transaksi').innerText = tanggal_transaksi;
                    row.querySelector('.jumlah_transaksi').innerText = jumlah_transaksi;
                    row.querySelector('.kategori_transaksi').innerText = kategori_transaksi;
                    row.querySelector('.status').innerText = status;
                    row.querySelector('.edit-btn').style.display = 'inline-block';
                    row.querySelector('.delete-btn').style.display = 'inline-block';
                    row.querySelector('.save-btn').style.display = 'none';
                }).catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>
</html>
