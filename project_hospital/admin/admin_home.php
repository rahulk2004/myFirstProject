<?php
session_start();
if(isset($_SESSION['alogged_in']) && $_SESSION['alogged_in']==true){
    //run
}else{
    header("location:../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krishna Clinic</title>
</head>
<body>
<?php
    include 'sidebar.php';
    ?>
    <main>
<h1>hello admin</h1>
    </main>
</body>
</html>