<?php

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

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #111827;
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
            font-size: 22px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-size: 15px;
        }

        nav a:hover {
            color: #93c5fd;
        }

        .container {
            width: calc(100% - 30px);
            max-width: 650px;

            margin: 55px auto;

            background: white;

            padding: 45px;

            border-radius: 18px;

            box-shadow:
                0 10px 35px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            font-size: 40px;
            margin: 0 0 25px;
        }

        .slot {
            text-align: center;

            font-size: 28px;
            font-weight: bold;

            margin-bottom: 35px;
        }

        .field {
            margin-top: 22px;
        }

        label {
            display: block;

            font-size: 16px;
            font-weight: bold;

            margin-bottom: 8px;
        }

        input {
            width: 100%;
            height: 54px;

            padding: 0 15px;

            border: 1px solid #d1d5db;
            border-radius: 10px;

            background: white;

            font-family: Arial, sans-serif;
            font-size: 16px;

            color: #111827;

            outline: none;

            transition:
                border-color 0.2s,
                box-shadow 0.2s;
        }

        input:hover {
            border-color: #9ca3af;
        }

        input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        input[type="date"],
        input[type="time"] {
            cursor: pointer;
        }

        .time-row {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 20px;
        }

        .info-box {
            margin-top: 25px;

            padding: 15px 18px;

            background: #eff6ff;

            border: 1px solid #bfdbfe;

            border-radius: 10px;

            color: #1e40af;

            font-size: 14px;

            line-height: 1.5;
        }

        .error-message {
            display: none;

            margin-top: 15px;

            padding: 13px 16px;

            background: #fef2f2;

            border: 1px solid #fecaca;

            color: #b91c1c;

            border-radius: 9px;

            font-size: 14px;

            line-height: 1.4;
        }

        button {
            width: 100%;

            height: 58px;

            margin-top: 28px;

            background: #2563eb;

            color: white;

            border: none;

            border-radius: 10px;

            font-size: 18px;
            font-weight: bold;

            cursor: pointer;

            transition: background 0.2s;
        }

        button:hover {
            background: #1d4ed8;
        }

        @media (max-width: 700px) {

            nav {
                padding: 18px 22px;
            }

            nav h2 {
                font-size: 19px;
            }

            nav a {
                margin-left: 12px;
                font-size: 14px;
            }

            .container {
                margin: 25px auto;
                padding: 30px 22px;
            }

            h1 {
                font-size: 32px;
            }

            .slot {
                font-size: 24px;
            }

            .time-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

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
        🅿️ <?php echo htmlspecialchars($slot['slot_number']); ?>
    </div>


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


        <!-- VEHICLE NUMBER -->

        <div class="field">

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

        </div>


        <!-- DATE -->

        <div class="field">

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

        <div class="field">

            <div class="time-row">

                <div>

                    <label for="start_time">
                        Start Time
                    </label>

                    <input
                        type="time"
                        id="start_time"
                        name="start_time"
                        step="60"
                        required
                    >

                </div>


                <div>

                    <label for="end_time">
                        End Time
                    </label>

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


        <div class="info-box">

            ℹ️ You can reserve a parking slot for a normal
            time period or overnight.
            For example, <strong>11:00 PM → 01:00 AM</strong>
            is allowed.

        </div>


        <div
            id="errorMessage"
            class="error-message"
        ></div>


        <button type="submit">
            ✓ Confirm Reservation
        </button>

    </form>

</div>


<script>

/*
|--------------------------------------------------------------------------
| ELEMENTS
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| TODAY'S DATE
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| VEHICLE NUMBER
|--------------------------------------------------------------------------
*/

vehicleInput.addEventListener(
    "input",
    function () {

        this.value =
            this.value.toUpperCase();

    }
);


/*
|--------------------------------------------------------------------------
| ERROR HANDLING
|--------------------------------------------------------------------------
*/

function showError(message) {

    errorMessage.textContent = message;

    errorMessage.style.display = "block";

}

function clearError() {

    errorMessage.textContent = "";

    errorMessage.style.display = "none";

}


/*
|--------------------------------------------------------------------------
| DATE VALIDATION
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| TIME VALIDATION
|--------------------------------------------------------------------------
|
| IMPORTANT:
|
| Normal booking:
|
| 10:00 AM → 12:00 PM
|
| Overnight booking:
|
| 11:00 PM → 01:00 AM
|
| Both are valid.
|
|--------------------------------------------------------------------------
*/

function validateTimes() {

    const start =
        startInput.value;

    const end =
        endInput.value;


    if (!start || !end) {

        return true;

    }


    /*
     * Same time is not allowed.
     */

    if (start === end) {

        showError(
            "Start time and end time cannot be the same."
        );

        return false;

    }


    /*
     * If end time is greater than start time,
     * it is a normal same-day reservation.
     *
     * Example:
     * 10:00 → 12:00
     */

    if (end > start) {

        return true;

    }


    /*
     * If end time is smaller than start time,
     * we treat it as an overnight reservation.
     *
     * Example:
     * 23:00 → 01:00
     *
     * This is VALID.
     */

    if (end < start) {

        return true;

    }


    return true;
}


/*
|--------------------------------------------------------------------------
| DATE CHANGE
|--------------------------------------------------------------------------
*/

dateInput.addEventListener(
    "change",
    function () {

        clearError();

        validateDate();

    }
);


/*
|--------------------------------------------------------------------------
| START TIME CHANGE
|--------------------------------------------------------------------------
*/

startInput.addEventListener(
    "change",
    function () {

        clearError();

        validateTimes();

    }
);


/*
|--------------------------------------------------------------------------
| END TIME CHANGE
|--------------------------------------------------------------------------
*/

endInput.addEventListener(
    "change",
    function () {

        clearError();

        validateTimes();

    }
);


/*
|--------------------------------------------------------------------------
| FORM SUBMISSION
|--------------------------------------------------------------------------
*/

form.addEventListener(
    "submit",
    function (event) {

        clearError();


        if (!validateDate()) {

            event.preventDefault();

            return;

        }


        if (!validateTimes()) {

            event.preventDefault();

            return;

        }

    }
);

</script>

</body>

</html>