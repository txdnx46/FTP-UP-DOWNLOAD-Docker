<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $ftp_server = $_ENV['FTP_SERVER'];
    $ftp_user = $_ENV['FTP_USER'];  
    $ftp_pass = $_ENV['FTP_PASS'];

    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

    if (ftp_login($ftp_conn, $ftp_user, $ftp_pass)) {
        $file_name = $_FILES["file"]["name"];
        $file_temp = $_FILES["file"]["tmp_name"];

        if (ftp_put($ftp_conn, $file_name, $file_temp, FTP_BINARY)) {
            // เพิ่มชื่อไฟล์ที่อัปโหลดลงใน Session
            $_SESSION['uploadedFiles'][] = $file_name;

            // หรือจะเพิ่มชื่อไฟล์ลงในฐานข้อมูล MySQL ก็ได้ที่นี่

            header("Location: index.php");
            exit();
        } else {
            echo "Error uploading file.";
        }

        ftp_close($ftp_conn);
    } else {
        echo "Could not connect as $ftp_user";
    }
}
?>
