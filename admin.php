<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$user_id = $_SESSION['user_id'];

$role_query = "SELECT role FROM users WHERE id = $user_id";
$role_result = $conn->query($role_query);
$user = $role_result->fetch_assoc();

if ($user['role'] !== 'admin') {
    echo "Access Denied";
    exit();
}


/* TOTAL SLOTS */

$total_query = "SELECT COUNT(*) AS total FROM parking_slots";
$total_result = $conn->query($total_query);
$total_slots = $total_result->fetch_assoc()['total'];


/* AVAILABLE SLOTS */

$available_query = "SELECT COUNT(*) AS available
                    FROM parking_slots
                    WHERE status = 'available'";

$available_result = $conn->query($available_query);
$available_slots = $available_result->fetch_assoc()['available'];


/* OCCUPIED SLOTS */

$occupied_query = "SELECT COUNT(*) AS occupied
                   FROM parking_slots
                   WHERE status = 'occupied'";

$occupied_result = $conn->query($occupied_query);
$occupied_slots = $occupied_result->fetch_assoc()['occupied'];


/* TOTAL RESERVATIONS */

$reservation_query = "SELECT COUNT(*) AS reservations
                      FROM reservations";

$reservation_result = $conn->query($reservation_query);
$total_reservations = $reservation_result->fetch_assoc()['reservations'];


/* MOST USED PARKING SLOT */

$popular_slot_query = "SELECT
                       parking_slots.slot_number,
                       COUNT(reservations.id) AS booking_count
                       FROM reservations
                       JOIN parking_slots
                       ON reservations.slot_id = parking_slots.id
                       GROUP BY parking_slots.id
                       ORDER BY booking_count DESC
                       LIMIT 1";

$popular_slot_result = $conn->query($popular_slot_query);

$popular_slot = "None";
$popular_slot_count = 0;

if ($popular_slot_result->num_rows > 0) {

    $popular_data = $popular_slot_result->fetch_assoc();

    $popular_slot = $popular_data['slot_number'];
    $popular_slot_count = $popular_data['booking_count'];
}
/* MOST USED PARKING ZONE */

$popular_zone_query = "SELECT
                       parking_zones.zone_name,
                       COUNT(reservations.id) AS booking_count
                       FROM reservations
                       JOIN parking_slots
                       ON reservations.slot_id = parking_slots.id
                       JOIN parking_zones
                       ON parking_slots.zone_id = parking_zones.id
                       GROUP BY parking_zones.id
                       ORDER BY booking_count DESC
                       LIMIT 1";

$popular_zone_result = $conn->query($popular_zone_query);

$popular_zone = "None";
$popular_zone_count = 0;

if ($popular_zone_result->num_rows > 0) {

    $popular_zone_data = $popular_zone_result->fetch_assoc();

    $popular_zone = $popular_zone_data['zone_name'];
    $popular_zone_count = $popular_zone_data['booking_count'];
}


/* TODAY'S RESERVATIONS */

$today_query = "SELECT COUNT(*) AS today
                FROM reservations
                WHERE reservation_date = CURDATE()";

$today_result = $conn->query($today_query);
$today_reservations = $today_result->fetch_assoc()['today'];


/* ACTIVE RESERVATIONS */

$active_query = "SELECT COUNT(*) AS active
                 FROM reservations
                 WHERE status = 'active'";

$active_result = $conn->query($active_query);
$active_reservations = $active_result->fetch_assoc()['active'];


/* CANCELLED RESERVATIONS */

$cancelled_query = "SELECT COUNT(*) AS cancelled
                    FROM reservations
                    WHERE status = 'cancelled'";

$cancelled_result = $conn->query($cancelled_query);
$cancelled_reservations = $cancelled_result->fetch_assoc()['cancelled'];

?>

<!DOCTYPE html>

<html>

<head>

<title>Admin Dashboard - SmartPark</title>

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
    max-width: 1100px;
    margin: 50px auto;
    padding: 20px;
}

h1 {
    margin-bottom: 40px;
}

.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    text-align: center;
}

.card h2 {
    font-size: 35px;
    margin: 10px 0;
}

.card p {
    color: #666;
}

.analytics {
    margin-top: 30px;
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.analytics-card {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    text-align: center;
}

.analytics-card h2 {
    font-size: 40px;
    margin: 10px 0;
}

</style>

</head>

<body>


<nav>

    <h2>🚗 SmartPark Admin</h2>

    <div>

        <a href="parking.php">Parking</a>

        <a href="logout.php">Logout</a>

    </div>

</nav>


<div class="container">

    <h1>Admin Dashboard</h1>


    <!-- MAIN STATISTICS -->

    <div class="cards">

        <div class="card">

            <p>Total Parking Slots</p>

            <h2>
                <?php echo $total_slots; ?>
            </h2>

        </div>


        <div class="card">

            <p>Available Slots</p>

            <h2>
                <?php echo $available_slots; ?>
            </h2>

        </div>


        <div class="card">

            <p>Occupied Slots</p>

            <h2>
                <?php echo $occupied_slots; ?>
            </h2>

        </div>


        <div class="card">

            <p>Total Reservations</p>

            <h2>
                <?php echo $total_reservations; ?>
            </h2>

        </div>

    </div>


    <!-- RESERVATION STATISTICS -->

    <div class="cards">

        <div class="card">

            <p>Today's Reservations</p>

            <h2>
                <?php echo $today_reservations; ?>
            </h2>

        </div>


        <div class="card">

            <p>Active Reservations</p>

            <h2>
                <?php echo $active_reservations; ?>
            </h2>

        </div>


        <div class="card">

            <p>Cancelled Reservations</p>

            <h2>
                <?php echo $cancelled_reservations; ?>
            </h2>

        </div>

    </div>


    <!-- PARKING ANALYTICS -->

    <div class="analytics">

        <div class="analytics-card">

            <p>🔥 Most Used Parking Slot</p>

            <h2>
                <?php echo $popular_slot; ?>
            </h2>

            <p>
                <?php echo $popular_slot_count; ?> reservations
            </p>

        </div>
        <div class="analytics-card">

    <p>🏢 Most Used Parking Zone</p>

    <h2>
        <?php echo $popular_zone; ?>
    </h2>

    <p>
        <?php echo $popular_zone_count; ?> reservations
    </p>

</div>

    </div>


</div>


</body>

</html>