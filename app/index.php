<!DOCTYPE html>
<html>
<link rel="stylesheet" href="index.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">

<head>
    <title>Page Title</title>
</head>

<body>
    <?php

    //session_start();

    $ftp_server = $_ENV['FTP_SERVER'];
    $ftp_user = $_ENV['FTP_USER'];
    $ftp_pass = $_ENV['FTP_PASS'];

    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

    if (ftp_login($ftp_conn, $ftp_user, $ftp_pass)) {
        // เริ่มต้นการเชื่อมต่อ FTP
        $file_list_ftp = ftp_nlist($ftp_conn, ".");

        echo "<header>";
        echo "<h1>File List (FTP)</h1>";
        echo "</header>";

        echo "<ul>";

        foreach ($file_list_ftp as $file) {
            echo "<li>";
            echo $file;
            echo " <form action='download.php' method='get' style='display:inline;'><input type='hidden' name='file' value='$file'><input type='submit' value='Download'></form>";
            echo " <form action='edit.php' method='get' style='display:inline;'><input type='hidden' name='file' value='$file'><input type='submit' value='Edit'></form>";
            echo " <form action='delete.php' method='post' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete $file?\")'><input type='hidden' name='file' value='$file'><input type='submit' value='Delete'></form>";
            echo "</li>";
        }

        echo "</ul>";

        // ส่วนที่ใช้สำหรับอัปโหลดไฟล์
        echo "<article>";
        echo "<h2>Upload File</h2>";
        echo "<form action='upload.php' method='post' enctype='multipart/form-data'>";
        echo "<input class='int-ch'type='file' name='file' />";
        echo "<input type='submit' value='Upload' />";
        echo "</form>";
        echo "</article>";



        //$sql = "SELECT * FROM file_store";
        //$mysqli_result = $conn->query($sql);

        if ($result->num_rows > 0) {

            echo "<h2>Uploaded Files (MySQL)</h2>";
            echo "<ul>";

            while ($row = $result->fetch_assoc()) {
                $filename = $row['filename'];
                echo "<li id='file_$filename'>
                    <span class='sp-text' id='display_$filename'>$filename</span> <tr>
                    <a href='download.php?file=" . urlencode($filename) . "'>Download File</a> <tr>
                    <a href='delete.php?file=" . urlencode($filename) . "'>Delete File</a> <tr>
                    <a href='#' onclick='editFileName(\"$filename\")'>Edit Name</a> <tr>
                  </li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No files uploaded yet.</p>";
        }

        //$conn->close();
    } else {
        echo "Could not connect as $ftp_user";
    }

    // ปิดการเชื่อมต่อ FTP
    ftp_close($ftp_conn);
    ?>

</body>

</html>




<script>
    function editFileName(filename) {
        var newName = prompt("Enter new name for " + filename + ":");
        if (newName !== null && newName !== "") {
            // Send the new name to edit.php
            window.location.href = "edit.php?file=" + encodeURIComponent(filename) + "&newName=" + encodeURIComponent(newName);
        }
    }
</script>