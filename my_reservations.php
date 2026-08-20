<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            reservations.id,
            reservations.vehicle_number,
            reservations.reservation_date,
            reservations.start_time,
            reservations.end_time,
            reservations.status,
            parking_slots.slot_number
        FROM reservations
        JOIN parking_slots
        ON reservations.slot_id = parking_slots.id
        WHERE reservations.user_id = $user_id
        ORDER BY reservations.reservation_date DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>My Reservations - SmartPark</title>

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
            align-items: center;
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
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
        }

        .reservation {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .reservation h2 {
            margin-top: 0;
        }

        .reservation p {
            margin: 8px 0;
        }

        .active {
            color: #16a34a;
            font-weight: bold;
        }

        .completed {
            color: #2563eb;
            font-weight: bold;
        }

        .cancelled {
            color: #dc2626;
            font-weight: bold;
        }

        .empty {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 12px;
        }

    </style>

</head>

<body>

<nav>

    <h2>🚗 SmartPark</h2>

    <div>

        <a href="index.php">Home</a>

        <a href="parking.php">Find Parking</a>

        <a href="my_reservations.php">My Reservations</a>

        <a href="logout.php">Logout</a>

    </div>

</nav>


<div class="container">

    <h1>My Reservations</h1>


    <?php if ($result->num_rows > 0) { ?>

        <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="reservation">

                <h2>
                    🅿️ Parking Slot <?php echo $row['slot_number']; ?>
                </h2>

                <p>
                    🚗 Vehicle:
                    <strong><?php echo $row['vehicle_number']; ?></strong>
                </p>

                <p>
                    📅 Date:
                    <?php echo $row['reservation_date']; ?>
                </p>

                <p>
                    ⏰ Time:
                    <?php echo $row['start_time']; ?>
                    -
                    <?php echo $row['end_time']; ?>
                </p>

                <p>
                    Status:

                    <span class="<?php echo $row['status']; ?>">
                        <?php echo strtoupper($row['status']); ?>
                    </span>

                </p>
                <?php if ($row['status'] == 'active') { ?>

    <form action="cancel_reservation.php" method="POST">

        <input
            type="hidden"
            name="reservation_id"
            value="<?php echo $row['id']; ?>"
        >

        <button type="submit">
            Cancel Reservation
        </button>

    </form>

<?php } ?>

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="empty">

            <h2>No Reservations Yet</h2>

            <p>You haven't booked a parking slot.</p>

            <a href="parking.php">
                Find Parking
            </a>

        </div>

    <?php } ?>

</div>

</body>

</html>