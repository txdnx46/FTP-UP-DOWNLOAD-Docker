<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['file']) && isset($_GET['newName'])) {
    $old_file = $_GET['file'];
    $new_name = $_GET['newName'];

    $ftp_server = $_ENV['FTP_SERVER'];
    $ftp_user = $_ENV['FTP_USER'];
    $ftp_pass = $_ENV['FTP_PASS'];

    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

    if (ftp_login($ftp_conn, $ftp_user, $ftp_pass)) {
        if (ftp_rename($ftp_conn, $old_file, $new_name)) {
            // อัปเดตชื่อไฟล์ใน Session หรือ MySQL ตามที่คุณใช้
            if (isset($_SESSION['uploadedFiles']) && in_array($old_file, $_SESSION['uploadedFiles'])) {
                $index = array_search($old_file, $_SESSION['uploadedFiles']);
                $_SESSION['uploadedFiles'][$index] = $new_name;
            }

            header("Location: index.php");
            exit();
        } else {
            echo "Error renaming file.";
        }

        ftp_close($ftp_conn);
    } else {
        echo "Could not connect as $ftp_user";
    }
}
?>
