<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$user_id = $_SESSION['user_id'];
$reservation_id = $_POST['reservation_id'];

$sql = "SELECT slot_id
        FROM reservations
        WHERE id = $reservation_id
        AND user_id = $user_id
        AND status = 'active'";

$result = $conn->query($sql);

if ($result->num_rows == 1) {

    $reservation = $result->fetch_assoc();

    $slot_id = $reservation['slot_id'];

    $cancel = "UPDATE reservations
               SET status = 'cancelled'
               WHERE id = $reservation_id
               AND user_id = $user_id";

    if ($conn->query($cancel) === TRUE) {

        $update_slot = "UPDATE parking_slots
                        SET status = 'available'
                        WHERE id = $slot_id";

        $conn->query($update_slot);

        header("Location: my_reservations.php");
        exit();

    }

} else {

    echo "Invalid reservation.";

}

?>