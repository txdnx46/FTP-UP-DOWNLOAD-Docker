<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['file'])) {
    $file_to_delete = $_POST['file'];

    $ftp_server = $_ENV['FTP_SERVER'];
    $ftp_user = $_ENV['FTP_USER'];
    $ftp_pass = $_ENV['FTP_PASS'];

    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

    if (ftp_login($ftp_conn, $ftp_user, $ftp_pass)) {
        if (ftp_delete($ftp_conn, $file_to_delete)) {
            // ลบชื่อไฟล์ออกจาก Session หรือ MySQL ตามที่คุณใช้
            if (isset($_SESSION['uploadedFiles']) && in_array($file_to_delete, $_SESSION['uploadedFiles'])) {
                $index = array_search($file_to_delete, $_SESSION['uploadedFiles']);
                unset($_SESSION['uploadedFiles'][$index]);
            }

            header("Location: index.php");
            exit();
        } else {
            echo "Error deleting file.";
        }

        ftp_close($ftp_conn);
    } else {
        echo "Could not connect as $ftp_user";
    }
}
?>
