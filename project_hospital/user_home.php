<?php
session_start();
if(isset($_SESSION['ulogged_in']) && $_SESSION['ulogged_in']==true){
    echo  "welcome $_SESSION[email]";
}else{
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krishna Clinic</title>

<body>
    <?php
    include 'inc/header.php';
    ?>
    <main>
    <h1>Hello <b><?php echo $_SESSION['name']; ?></b> welcome to hospital</h1>
    </main>
</body>
</html>