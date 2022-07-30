<?php
include('koneksi.php');
$id = $_GET['id'];
session_start();
require('FPDF/fpdf.php');


$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

//Image( file name , x position , y position , width [optional] , height [optional] )
$pdf->Image('frame.png', 5, 5, 287, 200);
$pdf->Image('unila.png', 40, 12, 28, 28);
$pdf->Cell(25, 8, '', 0, 1);
$pdf->SetFont('Times', 'B', '14');
$pdf->Cell(0, 5, "KEMENTRIAN RISET TEKNOLOGI DAN PENDIDIKAN TINGGI", 0, 1, 'C');
$pdf->Cell(25, 0, '', 0, 1);
$pdf->Cell(0, 5, "FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM", 0, 1, 'C');
$pdf->Cell(25, 0, '', 0, 1);
$pdf->SetFont('Times', 'B', '17');
$pdf->Cell(0, 5, "UNIVERSITAS LAMPUNG", 0, 1, 'C');
$pdf->Cell(25, 0, '', 0, 1);
$pdf->SetFont('Times', 'I', '10');
$pdf->Cell(0, 5, "Sekretariat Gedung E Lantai 1", 0, 1, 'C');
$pdf->Cell(25, 0, '', 0, 1);
$pdf->Cell(0, 2, "Jl. Prof. Dr. Ir. Sumantri Brojonegoro No.1, Gedong Meneng, Kec. Rajabasa, Kota Bandar Lampung, Lampung, 35141", 0, 1, 'C');
$pdf->Line(40, 42, 258, 42);

//set font to arial, bold, 14pt
$pdf->SetFont('Times', 'B', 35);
//make a dummy empty cell as a vertical spacer
$pdf->Cell(189, 13, '', 0, 1); //end of line
$pdf->Cell(8, 5, '', 0, 0);
$pdf->Cell(0, 5, 'SERTIFIKAT', 0, 0, 'C');
$pdf->Cell(0, 5, '', 0, 1);

//set font to arial, bold, 14pt
$pdf->SetFont('Times', '', 17);
//Cell(width , height , text , border , end line , [align] )
//make a dummy empty cell as a vertical spacer
$pdf->Cell(189, 4, '', 0, 1); //end of line
$pdf->Cell(8, 5, '', 0, 0);
$pdf->Cell(0, 5, 'Nomor Registrasi: AB-01-1789', 0, 0, 'C');
$pdf->Cell(0, 5, '', 0, 1);

//set font to arial, regular, 12pt
$pdf->SetFont('Times', '', 17);
//make a dummy empty cell as a vertical spacer
$pdf->Cell(8, 5, '', 0, 0);
$pdf->Cell(0, 25, "Dengan Ini Kami Memberikan Apresiasi dan Ucapan Terima Kasih Kepada:", 0, 0, 'C');
$pdf->Cell(8, 5, '', 0, 1);


$query = mysqli_query($conn, "SELECT * FROM dokumen JOIN peserta ON dokumen.id_peserta = peserta.id_peserta JOIN kegiatan ON dokumen.id_kegiatan = kegiatan.id_kegiatan WHERE peserta.id_peserta = " . $id);
$row = mysqli_fetch_array($query);
// var_dump($row);
$pdf->SetFont('Times', 'B', 25);
$pdf->Cell(110, 14, '', 0, 1); //end of line
$pdf->Cell(8, 5, '', 0, 0);
$pdf->MultiCell(0, 5, $row['nama_peserta'], 0, 'C', 0, 0);
$pdf->Line(200, 92, 100, 92);
$pdf->Cell(110, 5, '', 0, 1);

$pdf->SetFont('Times', '', 17);
$pdf->Cell(8, 5, '', 0, 0);
$pdf->Cell(0, 8, "Sebagai", 0, 0, 'C');
$pdf->Cell(8, 5, '', 0, 1);

$pdf->SetFont('Times', 'B', 20);
$pdf->Cell(8, 5, '', 0, 0);
$pdf->Cell(0, 15, "PESERTA", 0, 0, 'C');
$pdf->Cell(8, 5, '', 0, 1);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189, 15, '', 0, 1); //end of line
//billing address
$pdf->SetFont('Times', '', 17);
$pdf->Cell(15, 5, '', 0, 0); //end of line
$pdf->MultiCell(0, 6, $row['tema_kegiatan'], 0, 'C', 0, 1); //end of line

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189, 12, '', 0, 1); //end of line
$pdf->SetFont('Times', '', 17);
$pdf->Cell(8, 5, '', 0, 0);
$pdf->Cell(0, 12, "Bandar Lampung, " . $row['updated_at'], 0, 0, 'C');

$pdf->Cell(189, 10, '', 0, 1); //end of line
$pdf->SetFont('Times', 'B', 10);
$path1 = '';
$image1 = $row['qr_code'];
$fullPath1 = $path1 . $image1;
$pdf->Image($fullPath1, 30, 146, 45, 45);

$pdf->Cell(189, 2, '', 0, 1); //end of line
$pdf->SetFont('Times', '', 17);
$pdf->Cell(8, 4, '', 0, 0);
$pdf->Cell(0, 2, 'Ketua Pelaksana', 0, 1, 'C'); //end of line
$pdf->Cell(189, 10, '', 0, 1); //end of line


$query_ = mysqli_query($conn, "SELECT * FROM data_dokumen WHERE id_kegiatan = " . $row['id_kegiatan']);
$row_ = mysqli_fetch_array($query_);

$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(110, 4, '', 0, 0);
$path = 'upload/';
$image = $row_['signature_pad'];
$fullPath = $path . $image;
// var_dump($fullPath);
$pdf->Image($fullPath, 120, 133, 90, 0, 'PNG');

$pdf->Cell(189, 10, '', 0, 1); //end of line
$pdf->SetFont('Times', '', 17);
$pdf->Cell(8, 4, '', 0, 0);
$pdf->Cell(0, 10, $row['pemateri'], 0, 1, 'C'); //end of line


$pdf->Output("Certificate.pdf", "I");
