<?php
session_start();

include "db.php";

$sql = "SELECT * FROM parking_slots";
$result = $conn->query($sql);

$total_slots = 0;
$available_slots = 0;
$occupied_slots = 0;

$slots = [];

while ($row = $result->fetch_assoc()) {
    $slots[] = $row;

    $total_slots++;

    if ($row['status'] == 'available') {
        $available_slots++;
    } else {
        $occupied_slots++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Find Parking - SmartPark</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<?php include "components/navbar.php"; ?>


<main>

    <!-- PAGE HEADER -->

    <section class="hero">

        <div class="hero-content">

            <div class="hero-label">
                PARKING AVAILABILITY
            </div>

            <h1>
                Find Your<br>
                Parking Space.
            </h1>

            <p class="hero-description">
                Choose an available parking slot and reserve
                it for your preferred time.
            </p>

        </div>

    </section>


    <!-- PARKING SUMMARY -->

    <div class="container">

        <div class="slot-grid">

            <div class="card">

                <div class="card-title">
                    Total Slots
                </div>

                <div class="stat-number">
                    <?php echo $total_slots; ?>
                </div>

            </div>


            <div class="card">

                <div class="card-title">
                    Available
                </div>

                <div class="stat-number">
                    <?php echo $available_slots; ?>
                </div>

            </div>


            <div class="card">

                <div class="card-title">
                    Occupied
                </div>

                <div class="stat-number">
                    <?php echo $occupied_slots; ?>
                </div>

            </div>

        </div>


        <!-- PARKING SECTION -->

        <div class="page-header">

            <h2 class="page-title">
                Parking Slots
            </h2>

            <p class="page-subtitle">
                Select an available slot to continue with your reservation.
            </p>

        </div>


        <!-- SLOT GRID -->

        <div class="slot-grid">

            <?php foreach ($slots as $row) { ?>

                <div class="card">

                    <div class="card-header">

                        <div>

                            <div class="slot-number">

                                <?php echo htmlspecialchars($row['slot_number']); ?>

                            </div>

                            <div class="card-description">

                                <?php echo htmlspecialchars($row['slot_type']); ?>

                            </div>

                        </div>


                        <div>

                            <?php if ($row['status'] == 'available') { ?>

                                <span class="badge badge-available">
                                    AVAILABLE
                                </span>

                            <?php } else { ?>

                                <span class="badge badge-occupied">
                                    OCCUPIED
                                </span>

                            <?php } ?>

                        </div>

                    </div>


                    <div class="card-actions">

                        <?php if ($row['status'] == 'available') { ?>

                            <a
                                href="reserve.php?slot_id=<?php echo $row['id']; ?>"
                                class="btn btn-primary"
                            >
                                Reserve Slot
                            </a>

                        <?php } else { ?>

                            <button
                                class="btn btn-secondary"
                                disabled
                            >
                                Currently Unavailable
                            </button>

                        <?php } ?>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</main>


<?php include "components/footer.php"; ?>


</body>

</html>