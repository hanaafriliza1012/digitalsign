<?php session_start();
include('koneksi.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Check</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!--Script CSS Datatables-->
    <link type="text/css" href='https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css' rel='stylesheet'>
    <link type="text/css" href='https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css' rel='stylesheet'>
    <link type="text/css" href='https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css' rel='stylesheet'>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <!-- <br /><br /> -->
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">DigSign</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="certificate.php">Certificate</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="check.php">Check</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br />
        <h2 align="center">VERIFICATION CERTIFICATE</h2>
        <br />
        <form method="post">
            <div class="form-group">

                <!--Script untuk memanggil Javascript-->
                <table id="tabel-data" class="display responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Kegiatan</th>
                            <th>QR Code</th>
                            <th>Print</th>
                            <th>Check</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $query = mysqli_query($conn, "SELECT * FROM dokumen JOIN peserta ON dokumen.id_peserta = peserta.id_peserta JOIN kegiatan ON dokumen.id_kegiatan = kegiatan.id_kegiatan WHERE peserta.status = '2'");
                        $cnt = 1;
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo htmlentities($cnt++); ?></td>
                                <td><?php echo htmlentities($row['nama_peserta']); ?></td>
                                <td><?php echo htmlentities($row['nama_kegiatan']); ?></td>
                                <td><?php echo htmlentities($row['tanggal_kegiatan']); ?></td>
                                <td><?= "<img src='/" . $row['qr_code'] . "'style='width:150px; height:150px;'>" ?></td>
                                <td>
                                    <a href="print.php?id=<?php echo htmlentities($row['id_peserta']); ?>"><button type="button" class="btn btn-primary">Print</button></a>
                                </td>
                                <td>
                                    <a href="verify.php?id=<?php echo htmlentities($row['id_peserta']); ?>"><button type="button" class="btn btn-primary">Verify</button></a>
                                    <a href="base64.php?id=<?php echo htmlentities($row['id_kegiatan']); ?>"><button type="button" class="btn btn-primary">Base64</button></a>
                                </td>


                            </tr>

                        <?php  } ?>

                    </tbody>
                </table>
            </div>
            <div class="form-group">
        </form>
    </div>

    <!--Script Javascript-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabel-data').DataTable();
        });
    </script>
</body>

</html>