<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="kategori.css">
    <title>Categories</title>
    <style>
        /* Styles from your CSS file */
    </style>
</head>
<body>
    <div class="container">
        <h1>Categories</h1>
        <a href="admin.php" class="back-btn">Back to Admin</a>
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
                <tr>
                    <td contenteditable="true">Silver</td>
                    <td contenteditable="true">Category 1</td>
                    <td contenteditable="true">Deskripsi Category 1</td>
                    <td contenteditable="true">$100</td>
                    <td>
                        <button class="edit-btn" onclick="editRow(this)">Edit</button>
                        <button class="delete-btn" onclick="deleteRow(this)">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td contenteditable="true">Gold</td>
                    <td contenteditable="true">Category 2</td>
                    <td contenteditable="true">Deskripsi Category 2</td>
                    <td contenteditable="true">$150</td>
                    <td>
                        <button class="edit-btn" onclick="editRow(this)">Edit</button>
                        <button class="delete-btn" onclick="deleteRow(this)">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td contenteditable="true">Platinum</td>
                    <td contenteditable="true">Category 3</td>
                    <td contenteditable="true">Deskripsi Category 3</td>
                    <td contenteditable="true">$200</td>
                    <td>
                        <button class="edit-btn" onclick="editRow(this)">Edit</button>
                        <button class="delete-btn" onclick="deleteRow(this)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="add-btn" onclick="addRow()">Tambah Data</button>
    </div>

    <script>
        function editRow(button) {
            var row = button.parentNode.parentNode;
            var cells = row.getElementsByTagName("td");
            for (var i = 0; i < cells.length - 1; i++) {
                var cell = cells[i];
                if (cell.getAttribute("contenteditable") === "true") {
                    cell.setAttribute("contenteditable", "true");
                    cell.style.border = "1px solid black";
                } else {
                    cell.removeAttribute("contenteditable");
                    cell.style.border = "none";
                }
            }
        }

        function deleteRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        function addRow() {
            var table = document.getElementById("category-table").getElementsByTagName("tbody")[0];
            var newRow = table.insertRow(table.rows.length);
            newRow.innerHTML = `
                <td contenteditable="true">New jenis kartu</td>
                <td contenteditable="true">New kategori</td>
                <td contenteditable="true">New deskripsi</td>
                <td contenteditable="true">$100</td>
                <td>
                    <button class="edit-btn" onclick="editRow(this)">Edit</button>
                    <button class="delete-btn" onclick="deleteRow(this)">Delete</button>
                </td>
            `;
        }
    </script>
</body>
</html>
