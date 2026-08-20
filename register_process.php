<?php

include "db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password, role)
        VALUES ('$name', '$email', '$hashed_password', 'user')";

if ($conn->query($sql) === TRUE) {

    echo "
    <!DOCTYPE html>
    <html>

    <head>
        <title>Registration Successful</title>

        <style>

            body {
                font-family: Arial, sans-serif;
                background: #f5f7fa;
                text-align: center;
                padding-top: 100px;
            }

            .box {
                background: white;
                max-width: 500px;
                margin: auto;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            }

            h1 {
                color: #16a34a;
            }

            a {
                display: inline-block;
                margin-top: 25px;
                padding: 12px 25px;
                background: #2563eb;
                color: white;
                text-decoration: none;
                border-radius: 8px;
            }

        </style>

    </head>

    <body>

        <div class='box'>

            <h1>✅ Account Created!</h1>

            <p>Welcome to SmartPark.</p>

            <a href='login.php'>Login Now</a>

        </div>

    </body>

    </html>
    ";

} else {

    echo "Error: " . $conn->error;

}

?>