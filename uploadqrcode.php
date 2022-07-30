<?php
include 'koneksi.php';
// new filename
// $filenameqr = 'qr_' . date('YmdHis') . '.png';
// $url2 = '';


// menyimpan data kedalam variabel
$created_at = date("Y-m-d H:i:s");
$updated_at = date("Y-m-d H:i:s");

// query SQL untuk insert data
$id_kegiatan = $_POST['id_kegiatan'];
$id_peserta = $_POST['id_peserta'];

$link = $_POST['qrc'];

$hasil_qr = file_get_contents($link);

$filenameqr = 'qr_' . date('YmdHis') . '.png';
$save_path = 'upload_qr/' . $filenameqr;

// Save the image
file_put_contents($save_path, $hasil_qr);


$query = "INSERT INTO dokumen (id_kegiatan, id_peserta, qr_code, created_at, updated_at) VALUES ('$id_kegiatan', '$id_peserta', '$save_path', '$created_at', '$updated_at')";
if (!mysqli_query($conn, $query)) {
    $data = [
        'id' => null,
        'message' => mysqli_error($conn),
        'query' => $query
    ];
    echo json_encode($data);
} else {
    $id = $conn->insert_id;
    $query_update = "UPDATE peserta SET status='2' WHERE id_peserta=" . $id_peserta;
    mysqli_query($conn, $query_update);
    $data = [
        'id' => $id,
        'message' => "Data Berhasil Ditambahkan!"
    ];
    echo json_encode($data);
}
