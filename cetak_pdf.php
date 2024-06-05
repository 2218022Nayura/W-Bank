<?php
require('fpdf/fpdf.php');

// Koneksi ke database
$server = "localhost";
$username = "root";
$password = "";
$database = "wbank";

try {
    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil data kategori
    $stmt = $conn->prepare("SELECT * FROM kategori");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

// Membuat file PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Daftar Kategori', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Jenis Kartu', 1);
$pdf->Cell(40, 10, 'Kategori', 1);
$pdf->Cell(60, 10, 'Deskripsi', 1);
$pdf->Cell(30, 10, 'Harga', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($categories as $category) {
    $pdf->Cell(40, 10, $category['jenis_kartu'], 1);
    $pdf->Cell(40, 10, $category['kategori'], 1);
    $pdf->Cell(60, 10, $category['deskripsi'], 1);
    $pdf->Cell(30, 10, $category['harga'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'categories.pdf');
?>
