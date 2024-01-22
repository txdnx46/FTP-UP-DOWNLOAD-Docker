<?php

  // ส่วนที่ใช้สำหรับแสดงรายการไฟล์ที่อัปโหลดจาก MySQL
  $servername = "mysql_db";
  $username = "root";
  $password = "root";
  $db = "file_db";

  $conn = mysqli_connect($servername, $username, $password, $db);
  if(!$conn) echo"..." ;


  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_FILES['file'])){

      $file = $_FILES['file'];

      $sql = "insert into file_store(id,filename) values(1,'$file');";

    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
    <form action="" method="POST">
     <input type="file" name="file"> filename 
     <input type="submit">down
    </form>
    <?php
      $sql = "select*from file_db"; 
      $reslut = mysqli_query($conn,$sql);
      if($reslut) 
        echo "pas" ;
    ?>
</body>
</html>