<?php

include "db.php";

$slot_id = $_GET['slot_id'];

$sql = "SELECT * FROM parking_slots WHERE id = $slot_id";
$result = $conn->query($sql);
$slot = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>

    <title>Reserve Parking - SmartPark</title>

    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fa;
        }

        nav {
            background: #111827;
            color: white;
            padding: 20px 60px;
            display: flex;
            justify-content: space-between;
        }

        nav h2 {
            margin: 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
        }

        .container {
            max-width: 500px;
            margin: 60px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
        }

        .slot {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 30px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

    </style>

</head>

<body>

<nav>

    <h2>🚗 SmartPark</h2>

    <div>
        <a href="index.php">Home</a>
        <a href="parking.php">Find Parking</a>
    </div>

</nav>


<div class="container">

    <h1>Reserve Parking</h1>

    <div class="slot">

        🅿️ <?php echo $slot['slot_number']; ?>

    </div>


    <form action="confirm_reservation.php" method="POST">

        <input type="hidden" name="slot_id"
               value="<?php echo $slot['id']; ?>">


        <label>Vehicle Number</label>

        <input
            type="text"
            name="vehicle_number"
            placeholder="Example: UP32AB1234"
            required
        >


        <label>Reservation Date</label>

        <input
            type="date"
            name="reservation_date"
            required
        >


        <label>Start Time</label>

        <input
            type="time"
            name="start_time"
            required
        >


        <label>End Time</label>

        <input
            type="time"
            name="end_time"
            required
        >


        <button type="submit">
            Confirm Reservation
        </button>

    </form>

</div>

</body>

</html>