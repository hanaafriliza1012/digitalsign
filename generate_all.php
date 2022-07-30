<?php
include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM peserta WHERE status = 1 AND id_kegiatan = $id");

$urut = 1;

// if (mysqli_fetch_array($query) == null) {
//     $redirect = '/view.php?id=' . $id;
//     header("Location: $redirect");
//     exit();
// }

// if (count(mysqli_fetch_array($query)) == 1) {
//     echo 'test';
// }

while ($row = mysqli_fetch_array($query)) {
    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");
    $id_kegiatan = $row['id_kegiatan'];
    $id_peserta = $row['id_peserta'];

    $data = [
        'id_peserta' => $row['id_peserta'],
        'link' => "https://lib.ilkomdigitalsignature.my.id/verify.php?id=" . $row['id_peserta'],
        'foto' => "https://lib.ilkomdigitalsignature.my.id/base64.php?id=" . $row['id_kegiatan']
    ];

    $hasil_qr = file_get_contents('https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . json_encode($data, JSON_UNESCAPED_SLASHES));

    $filenameqr = $urut++ . 'qr_' . date('YmdHis') . '.png';
    $save_path = 'upload_qr/' . $filenameqr;

    // Save the image
    file_put_contents($save_path, $hasil_qr);

    $insert = "INSERT INTO dokumen (id_kegiatan, id_peserta, qr_code, created_at, updated_at) VALUES ('$id_kegiatan', '$id_peserta', '$save_path', '$created_at', '$updated_at')";
    if (!mysqli_query($conn, $insert)) {
        $data = [
            'id' => null,
            'message' => mysqli_error($conn),
            'query' => $query
        ];
        echo json_encode($data);
        // header("Location: $redirect");
        // exit();
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
}
