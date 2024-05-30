<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBanking - Register</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 90%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            grid-column: 1 / span 1;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            width: 100%;
        }
        label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            color: #555;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        a {
            text-decoration: none;
            color: #007bff;
            margin-top: 10px;
            display: inline-block;
            margin-right: 10px;
        }
        .image-container {
            border-radius: 10px;
            overflow: hidden;
            grid-column: 2 / span 1;
            position: relative;
        }
        .image-container img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            filter: grayscale(80%);
            transition: filter 0.3s;
        }
        .image-container:hover img {
            filter: grayscale(0);
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .overlay:hover {
            opacity: 1;
        }
        .overlay-content {
            text-align: center;
            color: #fff;
        }
        .overlay-content h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        .overlay-content p {
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Register</h1>
            <form action="register.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <input type="submit" value="Register">
            </form>
            <a href="login.php">Login</a>
        </div>
        <div class="image-container">
            <img src="cc2.jpg" alt="Register Image">
            <div class="overlay">
                <div class="overlay-content">
                    <h2>YOUR TEMPLATE CREDIT CARD</h2>
                    <p>W-BANK Financial Solution</p>
                </div>
            </div>
        </div>
    </div>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (!empty($username) && !empty($password) && !empty($email)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $servername = "localhost";
        $db_username = "root";
        $db_password = ""; 
        $dbname = "wbank";

        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Error prepare: " . $conn->error);
        }

        $bind = $stmt->bind_param("sss", $username, $hashed_password, $email);
        if ($bind === false) {
            die("Error bind_param: " . $stmt->error);
        }

        $exec = $stmt->execute();
        if ($exec) {
            echo "<script>
                    alert('Welcome to W-Bank, we are happy to be able to help you, your happiness is our responsibility, enjoy our features and if you have any criticism or suggestions please contact us, thank you');
                  </script>";
        } else {
            die("Error execute: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<p style='color: red;'>Semua kolom harus diisi!</p>";
    }
}
?>
</body>
</html>
