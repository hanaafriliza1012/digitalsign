<?php session_start();
include('koneksi.php');
$id = $_GET['id_kegiatan']
?>
<!DOCTYPE html>
<html>

<head>
    <title>Signature</title>
    <!-- CSS Signature -->
    <link rel="stylesheet" href="style.css">
    <!-- CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
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
        <h2 align="center">FORM TANDA TANGAN</h2>
        <br />

        <table class="table table-borderless display responsive nowrap" style="width:100%">
            <?php $query = mysqli_query($conn, "SELECT * FROM kegiatan where id_kegiatan = " . $id);
            $row = mysqli_fetch_array($query);
            $jumlah_query = mysqli_query($conn, "SELECT * FROM peserta WHERE id_kegiatan = " . $id);
            $jumlah = mysqli_fetch_all($jumlah_query);
            ?>

            <tbody>
                <tr>
                    <th scope="row">Nama Kegiatan</th>
                    <td>: <?php echo $row['nama_kegiatan'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Tema Kegiatan</th>
                    <td>: <?php echo $row['tema_kegiatan'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Tanggal Kegiatan</th>
                    <td>: <?php echo $row['tanggal_kegiatan'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Pemateri</th>
                    <td>: <?php echo $row['pemateri'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Jumlah Peserta</th>
                    <td colspan="2">: <?php echo count($jumlah) ?> Peserta</td>
                </tr>
            </tbody>
        </table>
        <fieldset>
            <div class="alert-message">
            </div>
            <h2 align="center"></h2>
            <br />
            <form action="uploadsesudah.php" method="POST" onsubmit="signature.upload_signuri(event)" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label for="signature-pad" class="col-sm-2 col-form-label">Tanda Tangan</label>
                    <div class="wrapper col-sm-4">
                        <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="button" id="clear" class="btn btn-secondary">Clear</button>
                        <button type="button" id="save" class="btn btn-success">Save</button>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Hasil Tanda Tangan</label>
                    <div class="col-sm-10">
                        <img src="" id="signature-img-result" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="camera" class="col-sm-2 col-form-label">Kamera</label>
                    <div class="col-sm-4">
                        <div id="camera">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="button" value="Take a Snap" id="btPic" onclick="takeSnapShot()">Capture</button>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Hasil Base64</label>
                    <div class="col-sm-10" id="snapShot">
                        <!-- <div>Image Data URL</div> -->
                        <textarea id="data_uri" readonly></textarea>
                    </div>
                </div>
                <div class="d-grid gap-2 col-12 mx-auto">
                    <button class="btn btn-dark" type="submit" name="submit" value="Submit QR">Submit</button>
                    <input type="hidden" name="id_kegiatan" id="id_kegiatan" value="<?php echo $row['id_kegiatan'] ?>" />
                </div>
        </fieldset>
        </form>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
        <script src="signature.js"></script>
        <script>
            signature.pad = "signature-pad";
            signature.camera = "#camera";
            signature.result = "#signature-result";
            signature.img_result = "#signature-img-result";
            signature.submit = "#form-submit";
            signature.clear = "#clear";
            signature.snapshot = "#snapShot";
            signature.img = "img"
            signature.init();
        </script>
</body>

</HTML>