<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$user_id = $_SESSION['user_id'];
$slot_id = $_POST['slot_id'];
$vehicle_number = $_POST['vehicle_number'];
$reservation_date = $_POST['reservation_date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

$sql = "INSERT INTO reservations
        (user_id, slot_id, vehicle_number, reservation_date, start_time, end_time, status)
        VALUES
        ('$user_id', '$slot_id', '$vehicle_number', '$reservation_date', '$start_time', '$end_time', 'active')";

if ($conn->query($sql) === TRUE) {

    $update = "UPDATE parking_slots
               SET status = 'occupied'
               WHERE id = $slot_id";

    $conn->query($update);

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Reservation Confirmed</title>

        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f5f7fa;
                text-align: center;
                padding-top: 100px;
            }

            .box {
                background: white;
                max-width: 500px;
                margin: auto;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            }

            h1 {
                color: #16a34a;
            }

            a {
                display: inline-block;
                margin-top: 25px;
                padding: 12px 25px;
                background: #2563eb;
                color: white;
                text-decoration: none;
                border-radius: 8px;
            }
        </style>
    </head>

    <body>

        <div class='box'>

            <h1>✅ Reservation Confirmed!</h1>

            <p>Your parking slot has been successfully reserved.</p>

            <p>🚗 Vehicle: <strong>$vehicle_number</strong></p>

            <p>📅 Date: <strong>$reservation_date</strong></p>

            <p>⏰ Time: <strong>$start_time - $end_time</strong></p>

            <a href='parking.php'>Back to Parking</a>

        </div>

    </body>
    </html>
    ";

} else {

    echo "Error: " . $conn->error;

}

?>