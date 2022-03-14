<?php
require APPPATH . 'third_party/phpqrcode/qrlib.php';

class Qrcode extends CI_Controller
{

    public function qrcode()
    {
        //direktori menyimpan hasil generate
        $tempdir = "qrcode/";
      
        //isi QRCode saat discan
        $isi_teks = "https://arditriheru.com";
      
        //direktori logo tengah
        $logopath = base_url('qrcode/qrcode_logo.png');
      
        //namafile setelah jadi qrcode
        $namafile = "qrcode_arditriheru.png";
      
        //kualitas dan ukuran qrcode
        $quality = 'H';
        $ukuran = 8;
        $padding = 0;

        QRCode::png($isi_teks, $tempdir . $namafile, QR_ECLEVEL_H, $ukuran, $padding);
        $filepath = $tempdir . $namafile;
        $QR = imagecreatefrompng($filepath);

        $logo = imagecreatefromstring(file_get_contents($logopath));
        $QR_width = imagesx($QR);
        $QR_height = imagesy($QR);

        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        //besar logo
        $logo_qr_width = $QR_width / 7;
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;

        //posisi logo
        imagecopyresampled($QR, $logo, 114, 100, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

        imagepng($QR, $filepath);

        echo '<img src="' . base_url('qrcode/' . $namafile) . '">';
    }
}
