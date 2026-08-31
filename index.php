<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SmartPark</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include "components/navbar.php"; ?>


<!-- HERO SECTION -->

<section class="hero">

    <div class="hero-content">

        <div class="hero-label">
            SMART PARKING SYSTEM
        </div>

        <h1>
            Smart Parking.<br>
            Made Simple.
        </h1>

        <p class="hero-description">
            Find, predict and reserve parking spaces
            with a smarter parking experience.
        </p>

        <div class="hero-actions">

            <a href="parking.php" class="btn btn-primary">
                Find Parking
            </a>

            <a href="register.php" class="btn btn-secondary">
                Create Account
            </a>

        </div>

    </div>

</section>


<!-- FEATURES -->

<div class="container">

    <div class="page-header">

        <h2 class="page-title">
            Why SmartPark?
        </h2>

        <p class="page-subtitle">
            Everything you need for a simple and efficient parking experience.
        </p>

    </div>


    <div class="slot-grid">

        <div class="card">

            <h3 class="card-title">
                Real-Time Availability
            </h3>

            <p class="card-description">
                View available and occupied parking spaces
                before making your reservation.
            </p>

        </div>


        <div class="card">

            <h3 class="card-title">
                Smart Predictions
            </h3>

            <p class="card-description">
                Use intelligent parking predictions
                to plan your visit more efficiently.
            </p>

        </div>


        <div class="card">

            <h3 class="card-title">
                Easy Reservations
            </h3>

            <p class="card-description">
                Select a parking slot, choose your time
                and reserve it in just a few steps.
            </p>

        </div>

    </div>

</div>


<?php include "components/footer.php"; ?>

</body>

</html>