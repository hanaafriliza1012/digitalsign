<?php session_start();
include('koneksi.php');
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Verify</title>
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
        <h2 align="center">GENERATE QR PESERTA</h2>
        <br />
        <form action="uploadqrcode.php" method="POST" onsubmit="signature.generateQR(event)" enctype="multipart/form-data">
            <?php $query = mysqli_query($conn, "SELECT * FROM peserta JOIN kegiatan ON peserta.id_kegiatan = kegiatan.id_kegiatan WHERE id_peserta = " . $id);
            $row = mysqli_fetch_array($query);
            ?>
            <input type="hidden" name="id_kegiatan" id="id_kegiatan" value="<?php echo $row['id_kegiatan'] ?>" />
            <input type="hidden" name="id_peserta" id="id_peserta" value="<?php echo $row['id_peserta'] ?>" />

            <button class="btn btn-dark" type="submit" name="submit" value="submit">Add QR Code</button>
            <table class="table table-borderless display responsive nowrap" style="width:100%">
                <tbody>
                    <tr>
                        <th scope="row">Status</th>
                        <td>: <?php if ($row != NULL) {
                                    echo "Valid";
                                } else {
                                    echo "Invalid";
                                } ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Nama Peserta</th>
                        <td>: <?php if ($row != NULL) {
                                    echo htmlentities($row['nama_peserta']);
                                } else {
                                    echo "";
                                } ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Nama Kegiatan</th>
                        <td>: <?php if ($row != NULL) {
                                    echo htmlentities($row['nama_kegiatan']);
                                } else {
                                    echo "";
                                } ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Tema Kegiatan</th>
                        <td>: <?php if ($row != NULL) {
                                    echo htmlentities($row['tema_kegiatan']);
                                } else {
                                    echo "";
                                } ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Kegiatan</th>
                        <td>: <?php if ($row != NULL) {
                                    echo htmlentities($row['tanggal_kegiatan']);
                                } else {
                                    echo "";
                                } ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Pemateri</th>
                        <td>: <?php if ($row != NULL) {
                                    echo htmlentities($row['pemateri']);
                                } else {
                                    echo "";
                                } ?></td>
                    </tr>
                </tbody>
            </table>
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
    <script src="signature.js"></script>

</body>

</html>