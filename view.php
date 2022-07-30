<?php session_start();
include('koneksi.php');
$id = $_GET['id']
?>
<!DOCTYPE html>
<html>

<head>
    <title>Certificate</title>
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
        <h2 align="center">PRINT CERTIFICATE</h2>
        <br />
        <form method="post">
            <div class="form-group">

                <!--Script untuk memanggil Javascript-->
                <a class="btn btn-dark" href="generate_all.php?id=<?php echo $id ?>" name="submit" value="">Generate All</a>
                <br />
                <table id="tabel-data" class="display responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Pemateri</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $query = mysqli_query($conn, "SELECT * FROM kegiatan JOIN peserta ON kegiatan.id_kegiatan = peserta.id_kegiatan WHERE kegiatan.id_kegiatan = $id");
                        $cnt = 1;
                        while ($row = mysqli_fetch_array($query)) {

                        ?>
                            <tr>
                                <td><?php echo htmlentities($cnt++); ?></td>
                                <td><?php echo htmlentities($row['nama_peserta']); ?></td>
                                <td><?php echo htmlentities($row['nama_kegiatan']); ?></td>
                                <td><?php echo htmlentities($row['tanggal_kegiatan']); ?></td>
                                <td><?php echo htmlentities($row['pemateri']); ?></td>
                                <td><?php if ($row['status'] == '2') {
                                        echo "Generated";
                                    } else {
                                        echo "Ungenerated";
                                    } ?></td>
                                <td>
                                    <a href="generate.php?id=<?php echo htmlentities($row['id_peserta']); ?>"><button type="button" class="btn btn-primary">Generate QR</button></a>
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