<?php
session_start();

include "db.php";

$slot_id = isset($_GET['slot_id']) ? (int) $_GET['slot_id'] : 0;

if ($slot_id <= 0) {
    die("Invalid parking slot.");
}

$sql = "SELECT * FROM parking_slots WHERE id = $slot_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    die("Parking slot not found.");
}

$slot = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reserve Parking - SmartPark</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<?php include "components/navbar.php"; ?>


<main>

    <div class="reservation-page">

        <div class="reservation-container">


            <!-- HEADER -->

            <div class="reservation-header">

                <div class="hero-label">
                    PARKING RESERVATION
                </div>

                <h1>
                    Reserve Your<br>
                    Parking Space
                </h1>

                <p>
                    Enter your vehicle details and choose your
                    preferred date and time.
                </p>

            </div>


            <!-- SELECTED SLOT -->

            <div class="selected-slot">

                <div>

                    <span class="selected-slot-label">
                        SELECTED PARKING SLOT
                    </span>

                    <div class="selected-slot-number">
                        <?php echo htmlspecialchars($slot['slot_number']); ?>
                    </div>

                </div>

                <span class="badge badge-available">
                    AVAILABLE
                </span>

            </div>


            <!-- FORM -->

            <form
                action="confirm_reservation.php"
                method="POST"
                id="reservationForm"
            >

                <input
                    type="hidden"
                    name="slot_id"
                    value="<?php echo $slot['id']; ?>"
                >


                <!-- VEHICLE -->

                <div class="reservation-field">

                    <label for="vehicle_number">
                        Vehicle Number
                    </label>

                    <input
                        type="text"
                        id="vehicle_number"
                        name="vehicle_number"
                        placeholder="Example: UP32AB1234"
                        maxlength="15"
                        autocomplete="off"
                        required
                    >

                    <small>
                        Enter your vehicle registration number.
                    </small>

                </div>


                <!-- DATE -->

                <div class="reservation-field">

                    <label for="reservation_date">
                        Reservation Date
                    </label>

                    <input
                        type="date"
                        id="reservation_date"
                        name="reservation_date"
                        required
                    >

                </div>


                <!-- TIME -->

                <div class="reservation-field">

                    <label>
                        Reservation Time
                    </label>

                    <div class="reservation-time-row">

                        <div>

                            <span class="time-label">
                                Start Time
                            </span>

                            <input
                                type="time"
                                id="start_time"
                                name="start_time"
                                step="60"
                                required
                            >

                        </div>


                        <div>

                            <span class="time-label">
                                End Time
                            </span>

                            <input
                                type="time"
                                id="end_time"
                                name="end_time"
                                step="60"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- INFORMATION -->

                <div class="reservation-info">

                    <strong>Reservation details</strong>

                    <p>
                        Select any available date and enter your
                        preferred start and end time.
                    </p>

                </div>


                <!-- ERROR -->

                <div
                    id="errorMessage"
                    class="reservation-error"
                ></div>


                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="btn btn-primary reservation-submit"
                >
                    Confirm Reservation
                </button>

            </form>

        </div>

    </div>

</main>


<?php include "components/footer.php"; ?>


<script>

const form =
    document.getElementById("reservationForm");

const dateInput =
    document.getElementById("reservation_date");

const startInput =
    document.getElementById("start_time");

const endInput =
    document.getElementById("end_time");

const vehicleInput =
    document.getElementById("vehicle_number");

const errorMessage =
    document.getElementById("errorMessage");


/* TODAY */

function getTodayString() {

    const today = new Date();

    const year =
        today.getFullYear();

    const month =
        String(today.getMonth() + 1).padStart(2, "0");

    const day =
        String(today.getDate()).padStart(2, "0");

    return `${year}-${month}-${day}`;
}

dateInput.min = getTodayString();


/* VEHICLE NUMBER */

vehicleInput.addEventListener("input", function () {

    this.value = this.value.toUpperCase();

});


/* ERROR */

function showError(message) {

    errorMessage.textContent = message;

    errorMessage.style.display = "block";

}

function clearError() {

    errorMessage.textContent = "";

    errorMessage.style.display = "none";

}


/* DATE VALIDATION */

function validateDate() {

    const selectedDate =
        dateInput.value;

    const today =
        getTodayString();

    if (!selectedDate) {

        showError(
            "Please select a reservation date."
        );

        return false;
    }

    if (selectedDate < today) {

        showError(
            "Please select today or a future date."
        );

        return false;
    }

    return true;
}


/* TIME VALIDATION */

function validateTimes() {

    const start =
        startInput.value;

    const end =
        endInput.value;

    if (!start || !end) {
        return true;
    }

    if (start === end) {

        showError(
            "Start time and end time cannot be the same."
        );

        return false;
    }

    /*
       Both normal and overnight reservations
       are allowed.

       Example:

       10:00 → 12:00
       23:00 → 01:00
    */

    return true;
}


/* DATE CHANGE */

dateInput.addEventListener("change", function () {

    clearError();

    validateDate();

});


/* TIME CHANGE */

startInput.addEventListener("change", function () {

    clearError();

    validateTimes();

});


endInput.addEventListener("change", function () {

    clearError();

    validateTimes();

});


/* FORM SUBMISSION */

form.addEventListener("submit", function (event) {

    clearError();

    if (!validateDate()) {

        event.preventDefault();

        return;
    }

    if (!validateTimes()) {

        event.preventDefault();

        return;
    }

});

</script>


</body>

</html>