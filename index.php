<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W-Banking - Home</title>
    <style>
        /* CSS Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Goudy Bookletter 1911', serif;
            background: url('5.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        .overlay {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 90%;
        }
        h1 {
            font-size: 3em;
            margin-bottom: 20px;
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        p {
            font-size: 1.5em;
            margin-bottom: 30px;
            color: #555;
        }
        a {
            text-decoration: none;
            color: #fff;
            background-color: #333;
            padding: 15px 30px;
            border-radius: 5px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        a:hover {
            background-color: #555;
        }

        /* Styles for carousel */
        .carousel {
            margin-top: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .carousel-container {
            display: flex;
            transition: transform 0.5s ease;
        }

        .carousel-item {
            flex: 0 0 auto;
            width: 100%;
            display: none;
        }

        .carousel-item:first-child {
            display: block;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            outline: none;
            font-size: 1.5em;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .carousel-button:hover {
            background: rgba(0, 0, 0, 0.7);
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }

        /* Styles for additional content */
        .additional-content {
            margin-top: 30px;
            text-align: left;
        }

        .additional-content h2 {
            font-size: 2em;
            color: #333;
        }

        .additional-content ul {
            list-style: none;
            padding-left: 0;
        }

        .additional-content ul li {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        /* Styles for bottom buttons */
        .bottom-buttons {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        .bottom-buttons button {
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 0 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .bottom-buttons button:hover {
            background-color: #555;
        }
        .carousel-item img {
             max-width: 100%;
            height: 355px;
        }

        /* Position the Admin button */
        .admin-button {
            display: block;
            margin-top: 20px;
        }

        /* Popup styles */
        .popup-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
            display: none;
            transition: opacity 0.5s ease;
        }

        .popup-container {
            position: fixed;
            top: -100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 100;
            display: none;
            transition: top 0.5s ease;
        }

        .popup-container.active {
            top: 50%;
        }

        /* Popup close button */
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

    </style>
</head>
<body>
    <div class="overlay">
        <h1>W-BANK</h1>
        <p>Financial Solutions.</p>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="admin.php" class="admin-button">Admin</a>

        <!-- Additional content -->
        <div class="additional-content">
            <h2>Our Services</h2>
            <ul>
                <li>Personal Banking</li>
                <li>Business Banking</li>
                <li>Investment Solutions</li>
            </ul>
        </div>
    </div>

    <!-- Carousel -->
    <div class="carousel">
        <div class="carousel-container">
            <div class="carousel-item"><img src="cc5.jpg" alt="Image 4"></div>
            <div class="carousel-item"><img src="cc6.jpg" alt="Image 5"></div>
            <div class="carousel-item"><img src="cc4.jpg" alt="Image 6"></div>
        </div>
        <button class="carousel-button prev" onclick="prevSlide()">&#10094;</button>
        <button class="carousel-button next" onclick="nextSlide()">&#10095;</button>
    </div>

    <!-- Bottom buttons -->
    <div class="bottom-buttons">
        <!-- Tambahkan id pada tombol -->
        <button id="popup-comment-btn">Customer Comment</button>
        <button id="popup-info-btn">Information</button>
    </div>

    <!-- Popup Background -->
    <div class="popup-background" id="popup-background"></div>

    <!-- Popup boxes -->
    <div class="popup-container" id="popup-comment">
        <span class="close" onclick="closePopup('popup-comment')">&times;</span>
        <p>1.NAY "This really petrified me, thank you W-BANK!"</p>
        <p>2.ALDO "My finances improved after 2 months with W-BANK"</p>
        <p>3.ALDO "I recently joined W-BANK, it's very interesting!"</p>
    </div>

    <div class="popup-container" id="popup-info">
        <span class="close" onclick="closePopup('popup-info')">&times;</span>
        <p>HAII</p>
        <p>Designed by Naii</p>
    </div>

    <script>
        // JavaScript functions
        var slideIndex = 0;
        showSlide(slideIndex);

        function prevSlide() {
            showSlide(slideIndex -= 1);
        }

        function nextSlide() {
            showSlide(slideIndex += 1);
        }

        function showSlide(index) {
            var slides = document.getElementsByClassName("carousel-item");
            if (index >= slides.length) { slideIndex = 0; }
            if (index < 0) { slideIndex = slides.length - 1; }
            for (var i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex].style.display = "block";
        }

        // Fungsi untuk menampilkan popup
        function showPopup(popupId) {
            document.getElementById('popup-background').style.display = "block";
            document.getElementById(popupId).style.display = "block";
            setTimeout(function() {
                document.getElementById(popupId).classList.add('active');
                document.getElementById('popup-background').classList.add('active');
            }, 10); // Menunggu sedikit agar transisi CSS berfungsi
        }

        // Fungsi untuk menutup popup
        function closePopup(popupId) {
            document.getElementById(popupId).classList.remove('active');
            document.getElementById('popup-background').classList.remove('active');
            setTimeout(function() {
                document.getElementById(popupId).style.display = "none";
                document.getElementById('popup-background').style.display = "none";
            }, 500); // Durasi transisi CSS
        }

        // Tambahkan event listener untuk tombol yang akan menampilkan popup box
        document.getElementById('popup-comment-btn').addEventListener('click', function() {
            showPopup('popup-comment');
        });

        document.getElementById('popup-info-btn').addEventListener('click', function() {
            showPopup('popup-info');
        });
    </script>
</body>
</html>
