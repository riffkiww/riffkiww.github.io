<?php
header('Content-Type: application/json');

// koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'sensor_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Koneksi gagal: ' . $conn->connect_error]));
}

// ambil semua data dari tabel data_sensor
// 💥 PERUBAHAN UTAMA: Tambahkan ORDER BY `timestamp` DESC agar data terbaru muncul di awal
$query = "SELECT * FROM data_sensor ORDER BY `timestamp` DESC"; 
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// cari suhu max, min, rata2
$suhu_values = array_column($data, 'suhu');
// Cek jika data kosong untuk menghindari error pembagian dengan nol
if (empty($suhu_values)) {
    $max_suhu = 0;
    $min_suhu = 0;
    $rata_suhu = 0;
} else {
    $max_suhu = max($suhu_values);
    $min_suhu = min($suhu_values);
    $rata_suhu = array_sum($suhu_values) / count($suhu_values);
}

// Logic filtering data suhu max dihapus/dilewati

// Ambil bulan dan tahun unik
$month_year = [];
foreach ($data as $row) {
    $t = strtotime($row['timestamp']);
    $month_year[] = date('n-Y', $t);
}
$month_year = array_unique($month_year);

// hasil akhir JSON
$output = [
    'suhumax' => $max_suhu,
    'suhumin' => $min_suhu,
    'suhurata' => round($rata_suhu, 2),
    // Mengirim SEMUA data ($data) untuk ditampilkan di tabel historis
    'nilai_suhu_max_humid_max' => $data, 
    'month_year_max' => array_map(fn($v) => ['month_year' => $v], $month_year)
];

echo json_encode($output, JSON_PRETTY_PRINT);
?>