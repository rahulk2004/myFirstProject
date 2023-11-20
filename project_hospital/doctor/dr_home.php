<?php
session_start();
if(isset($_SESSION['dlogged_in']) && $_SESSION['dlogged_in'] == true){
    $doctorId = $_SESSION['doctor_id'];
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
    <style>
        table {
			margin: 0 auto;
			font-size: large;
			border: 1px solid black;
			width:95%;
			border-collapse:collapse;
            
		}

		
		td {
			background-color: #E4F5D4;
			border: 1px solid black;
		}

		th,
		td {
			font-weight: bold;
			border: 1px solid black;
			text-align: center;
		}

		td {
			font-weight: lighter;
		}
    </style>
</head>
<body>
    <?php
    include 'navbar.php';
    ?>
    <main>
    <?php
    require_once('../inc/connection.php');

    $sqlAppointments = "SELECT * FROM appointments WHERE doctor_id = $doctorId AND appointment_status = 'Arrived'";
    $resultAppointments = mysqli_query($conn, $sqlAppointments);

    ?>

    <h1>Your Appointments</h1>
    
    <table>
    <thead>
        <tr>
            <th>Appointment ID</th>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Weight</th>
            <th>Status</th>
            <th>Action</th> 
        </tr>
    </thead>
    <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($resultAppointments)) {
        $appointmentTime12Hour = date("h:i A", strtotime($row['appointment_time']));

        echo "<tr>";
        echo "<td>{$row['token_number']}</td>";
        echo "<td>{$row['patient_name']}</td>";
        echo "<td>{$row['patient_age']}</td>";
        echo "<td>{$row['patient_gender']}</td>";
        echo "<td>{$row['date_of_birth']}</td>";
        echo "<td>{$row['patient_address']}</td>";
        echo "<td>{$row['note']}</td>";
        echo "<td>{$row['appointment_date']}</td>";
        echo "<td>{$appointmentTime12Hour}</td>";
        echo "<td>{$row['patient_weight']}</td>";
        echo "<td>{$row['appointment_status']}</td>";
        echo "<td>";
        
        if ($row['appointment_status'] !== 'Visited') {
            echo "<form method='POST' action=''>";
            echo "<input type='hidden' name='appointment_id' value='{$row['appointment_id']}'>";
            echo "<input type='submit' name='mark_visited' value='Mark Visited'>";
            echo "</form>";
        }
        
        echo "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_visited'])) {
    $appointmentId = $_POST['appointment_id'];

    $updateStatusQuery = "UPDATE appointments SET appointment_status = 'Visited' WHERE appointment_id = '$appointmentId'";
    $updateStatusResult = mysqli_query($conn, $updateStatusQuery);

    if ($updateStatusResult) {
        echo "Appointment status updated to 'Visited'.";
    } else {
        echo "Error updating appointment status.";
    }
}

?>

    </main>
</body>
</html>
