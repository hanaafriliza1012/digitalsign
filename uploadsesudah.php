<?php
include 'koneksi.php';
// new filename
$filenamesignature = 'pic_' . date('YmdHis') . '.png';
$url1 = '';
if (move_uploaded_file($_FILES['signature']['tmp_name'], 'upload/' . $filenamesignature)) {
    $url1 = $filenamesignature;
}

// query SQL untuk insert data
$data_uri = $_POST['data_uri'];
$id_kegiatan = $_POST['id_kegiatan'];
$query = "INSERT INTO data_dokumen (signature_pad, data_uri, id_kegiatan) VALUES ('$url1', '$data_uri', '$id_kegiatan')";
if (!mysqli_query($conn, $query)) {
    $data = [
        'id' => null,
        'message' => "Data Berhasil Ditambahkan!",
        'query' => $query
    ];
    $id = $conn->insert_id;
    echo json_encode($data);
} else {
    $id = $conn->insert_id;
    $query_update = "UPDATE kegiatan SET status='2' WHERE id_kegiatan=" . $id_kegiatan;
    mysqli_query($conn, $query_update);
    $data = [
        'id' => $id,
        'message' => "Data Berhasil Ditambahkan!"
    ];
    echo json_encode($data);
}
