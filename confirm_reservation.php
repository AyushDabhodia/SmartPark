<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();

}

include "db.php";


/*
|--------------------------------------------------------------------------
| GET FORM DATA
|--------------------------------------------------------------------------
*/

$user_id = (int) $_SESSION['user_id'];

$slot_id = isset($_POST['slot_id'])
    ? (int) $_POST['slot_id']
    : 0;

$vehicle_number = isset($_POST['vehicle_number'])
    ? strtoupper(trim($_POST['vehicle_number']))
    : '';

$reservation_date = $_POST['reservation_date'] ?? '';

$start_time = $_POST['start_time'] ?? '';

$end_time = $_POST['end_time'] ?? '';


/*
|--------------------------------------------------------------------------
| BASIC VALIDATION
|--------------------------------------------------------------------------
*/

if (
    $slot_id <= 0 ||
    empty($vehicle_number) ||
    empty($reservation_date) ||
    empty($start_time) ||
    empty($end_time)
) {

    die("Please fill all reservation details.");

}


/*
|--------------------------------------------------------------------------
| DATE VALIDATION
|--------------------------------------------------------------------------
*/

$today = date('Y-m-d');

if ($reservation_date < $today) {

    die("Reservation date cannot be in the past.");

}


/*
|--------------------------------------------------------------------------
| TIME VALIDATION
|--------------------------------------------------------------------------
|
| Same time is not allowed.
|
| Example:
| 10:00 → 12:00  ✅
| 23:00 → 01:00  ✅ Overnight
| 10:00 → 10:00  ❌
|
|--------------------------------------------------------------------------
*/

if ($start_time === $end_time) {

    die("Start time and end time cannot be the same.");

}


/*
|--------------------------------------------------------------------------
| CHECK PARKING SLOT
|--------------------------------------------------------------------------
*/

$slot_check = $conn->query(
    "SELECT * FROM parking_slots WHERE id = $slot_id"
);

if (
    !$slot_check ||
    $slot_check->num_rows === 0
) {

    die("Parking slot not found.");

}

$slot = $slot_check->fetch_assoc();


/*
|--------------------------------------------------------------------------
| INSERT RESERVATION
|--------------------------------------------------------------------------
*/

$sql = "INSERT INTO reservations
        (
            user_id,
            slot_id,
            vehicle_number,
            reservation_date,
            start_time,
            end_time,
            status
        )
        VALUES
        (
            '$user_id',
            '$slot_id',
            '$vehicle_number',
            '$reservation_date',
            '$start_time',
            '$end_time',
            'active'
        )";


if ($conn->query($sql) === TRUE) {


    /*
     * Mark parking slot as occupied.
     */

    $update = "UPDATE parking_slots
               SET status = 'occupied'
               WHERE id = $slot_id";

    $conn->query($update);


    /*
     * Display confirmation.
     */

    echo "

    <!DOCTYPE html>

    <html>

    <head>

        <meta charset='UTF-8'>

        <meta
            name='viewport'
            content='width=device-width, initial-scale=1.0'
        >

        <title>Reservation Confirmed</title>

        <style>

            * {
                box-sizing: border-box;
            }

            body {
                 margin: 0;
                min-height: 100vh;

                font-family: Arial, sans-serif;

                 background: #f5f7fa;

                 display: flex;
                justify-content: center;
                 align-items: center;

                padding: 30px;
            }

            .box {
                width: 100%;
                max-width: 550px;

                background: white;

                padding: 45px;

                border-radius: 18px;

                text-align: center;

                box-shadow: 0 10px 35px rgba(0,0,0,0.08);
            }

            h1 {

                color: #16a34a;

                margin-top: 0;

            }

            .details {

                text-align: left;

                background: #f8fafc;

                padding: 20px;

                border-radius: 10px;

                margin-top: 25px;

                line-height: 1.8;

            }

            .button {

                display: inline-block;

                margin-top: 25px;

                padding: 13px 25px;

                background: #2563eb;

                color: white;

                text-decoration: none;

                border-radius: 9px;

                font-weight: bold;

            }

            .button:hover {

                background: #1d4ed8;

            }

        </style>

    </head>


    <body>

        <div class='box'>

            <h1>✅ Reservation Confirmed!</h1>

            <p>
                Your parking slot has been successfully reserved.
            </p>


            <div class='details'>

                <p>
                    🚗 Vehicle:
                    <strong>$vehicle_number</strong>
                </p>

                <p>
                    🅿️ Slot:
                    <strong>{$slot['slot_number']}</strong>
                </p>

                <p>
                    📅 Date:
                    <strong>$reservation_date</strong>
                </p>

                <p>
                    ⏰ Time:
                    <strong>$start_time - $end_time</strong>
                </p>

            </div>


            <a
                href='parking.php'
                class='button'
            >
                Back to Parking
            </a>

        </div>

    </body>

    </html>

    ";

} else {

    echo "Error: " . $conn->error;

}

?>