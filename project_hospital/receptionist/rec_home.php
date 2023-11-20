<?php
session_start();
if(isset($_SESSION['rlogged_in']) && $_SESSION['rlogged_in']==true){
    $userId = $_SESSION['user_id'];
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

<body>
    <?php
    include 'topnav.php';
    ?>
    <main>
    <?php
    require_once('../inc/connection.php');

    
    $currentDate = date("Y-m-d");

    $doctorFilter = isset($_GET['doctor']) ? $_GET['doctor'] : 'all';
    
    $sqlDoctors = "SELECT doctor_id, doctor_name FROM doctor";
    $resultDoctors = mysqli_query($conn, $sqlDoctors);
    
    $sqlAppointments = "SELECT * FROM appointments WHERE appointment_date = '$currentDate'";
    if ($doctorFilter !== 'all') {
        $sqlAppointments .= " AND doctor_id = $doctorFilter";
    }
    $sqlAppointments .= " ORDER BY appointment_time";
    $resultAppointments = mysqli_query($conn, $sqlAppointments);
    ?>

    <h1>Appointments</h1>
    <form method="GET" action="">
    <label for="doctor">Filter by Doctor:</label>
    <select id="doctor" name="doctor">
        <option value="all">All Doctors</option>
        <?php
        while ($rowDoctor = mysqli_fetch_assoc($resultDoctors)) {
            $selected = ($doctorFilter == $rowDoctor['doctor_id']) ? 'selected' : '';
            echo "<option value=\"{$rowDoctor['doctor_id']}\" $selected>{$rowDoctor['doctor_name']}</option>";
        }
        ?>
    </select>
    <input type="submit" value="Filter">
</form>
    
    <table>
        <thead>
            <tr>
                <th>token number</th>
                <th>Appointment ID</th>
                <th>doctor name</th>
                <th>Patient Name</th>
                <th>age</th>
                <th>gender</th>
                <th>date of birth</th>
                <th>address</th>
                <th>note</th>
                <th>Date</th>
                <th>Time</th>
                <th>Weight</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
    while ($row = mysqli_fetch_assoc($resultAppointments)) {

        $doctorNameQuery = "SELECT doctor_name FROM doctor WHERE doctor_id = {$row['doctor_id']}";
        $doctorNameResult = mysqli_query($conn, $doctorNameQuery);
        $doctorNameRow = mysqli_fetch_assoc($doctorNameResult);
        $doctorName = $doctorNameRow['doctor_name'];

        $appointmentTime12Hour = date("h:i A", strtotime($row['appointment_time']));


        echo "<tr>";
        echo "<td>{$row['token_number']}</td>";
        echo "<td>{$row['appointment_id']}</td>";
        echo "<td>$doctorName</td>";
        echo "<td>{$row['patient_name']}</td>";
        echo "<td>{$row['patient_age']}</td>";
        echo "<td>{$row['patient_gender']}</td>";
        echo "<td>{$row['date_of_birth']}</td>";
        echo "<td>{$row['patient_address']}</td>";
        echo "<td>{$row['note']}</td>";
        echo "<td>{$row['appointment_date']}</td>";
        echo "<td>{$appointmentTime12Hour}</td>";
        echo "<td>";
        echo "<form method='POST' action=''>";
        echo "<input type='hidden' name='appointment_id' value='{$row['appointment_id']}'>";
        echo "<input type='hidden' name='weight' value='{$row['patient_weight']}'>"; 
        if (empty($row['patient_weight'])) {
            echo "<input type='number' name='patient_weight' placeholder='Enter weight' required>";
        } else {
            echo $row['patient_weight'];
        }
        echo "</td>";
        echo "<td>{$row['appointment_status']}</td>";
        echo "<td>";
        if (empty($row['patient_weight'])) {
            echo "<input type='submit' name='mark_arrived' value='Mark Arrived'>";
        }
        echo "</form>";

    }
    ?>
</tbody>
</table>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_arrived'])) {
    $appointmentId = $_POST['appointment_id'];
    $currentDate = date("Y-m-d");

    $doctorIdQuery = "SELECT doctor_id FROM appointments WHERE appointment_id = '$appointmentId'";
    $doctorIdResult = mysqli_query($conn, $doctorIdQuery);
    $doctorIdRow = mysqli_fetch_assoc($doctorIdResult);
    $doctorId = $doctorIdRow['doctor_id'];

    $maxTokenQuery = "SELECT MAX(token_number) AS max_token FROM appointments WHERE appointment_date = '$currentDate' AND doctor_id = '$doctorId'";
    $maxTokenResult = mysqli_query($conn, $maxTokenQuery);
    $maxTokenRow = mysqli_fetch_assoc($maxTokenResult);
    $maxTokenNumber = $maxTokenRow['max_token'];

    $newTokenNumber = ($maxTokenNumber !== null) ? $maxTokenNumber + 1 : 1;

    $newWeight = $_POST['patient_weight'];
    $updateStatusQuery = "UPDATE appointments SET patient_weight = '$newWeight', appointment_status = 'Arrived', token_number = '$newTokenNumber' WHERE appointment_id = '$appointmentId'";
    $updateStatusResult = mysqli_query($conn, $updateStatusQuery);

    if ($updateStatusResult) {
        echo "Token generated successfully. New Token Number: " . $newTokenNumber;
        exit();
    } else {
        echo "Error updating appointment status.";
    }
}
?>
    </main>
</body>
</html>