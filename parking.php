<?php
session_start();

include "db.php";

$sql = "SELECT * FROM parking_slots";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Find Parking - SmartPark</title>

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
            padding: 50px;
        }

        h1 {
            text-align: center;
        }

        .slots {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 40px;
        }

        .slot {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .available {
            border-top: 5px solid #22c55e;
        }

        .occupied {
            border-top: 5px solid #ef4444;
        }

        .slot-number {
            font-size: 28px;
            font-weight: bold;
        }

        .status {
            margin-top: 10px;
            font-weight: bold;
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

        <?php if (isset($_SESSION['user_name'])) { ?>

            <span>
                Welcome, <?php echo $_SESSION['user_name']; ?>
            </span>

            <a href="logout.php">Logout</a>

        <?php } else { ?>

            <a href="login.php">Login</a>
            <a href="register.php">Register</a>

        <?php } ?>

    </div>
</nav>

<div class="container">

    <h1>Available Parking Slots</h1>

    <div class="slots">

        <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="slot <?php echo $row['status']; ?>">

                <div class="slot-number">
                    🅿️ <?php echo $row['slot_number']; ?>
                </div>

                <div>
                    Type: <?php echo $row['slot_type']; ?>
                </div>

                <div class="status">
                    <?php echo strtoupper($row['status']); ?>
                </div>
                <?php if ($row['status'] == 'available') { ?>

    <a href="reserve.php?slot_id=<?php echo $row['id']; ?>">
        <button>Reserve Slot</button>
    </a>

<?php } ?>

            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>