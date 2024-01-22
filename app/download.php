<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // ในกรณีนี้คุณสามารถใช้ header() หรือ readfile() เพื่อดาวน์โหลดไฟล์
    // ตัวอย่างนี้ใช้ readfile()
    
    $ftp_server = $_ENV['FTP_SERVER'];
    $ftp_user = $_ENV['FTP_USER'];
    $ftp_pass = $_ENV['FTP_PASS'];

    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

    if (ftp_login($ftp_conn, $ftp_user, $ftp_pass)) {
        $remote_file = $file;
        $local_file = tempnam(sys_get_temp_dir(), 'download_');

        if (ftp_get($ftp_conn, $local_file, $remote_file, FTP_BINARY)) {
            // กำหนด Content-Type ตามประเภทของไฟล์
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $local_file);
            finfo_close($finfo);

            header('Content-Type: ' . $mime_type);
            header('Content-Disposition: attachment; filename="' . $file . '"');
            readfile($local_file);

            // ลบไฟล์ที่ถูกดาวน์โหลดลงจากระบบ
            unlink($local_file);
        } else {
            echo "Error downloading file.";
        }

        ftp_close($ftp_conn);
    } else {
        echo "Could not connect as $ftp_user";
    }
} else {
    echo "File not specified.";
}
?>
