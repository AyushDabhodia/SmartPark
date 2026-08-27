<!DOCTYPE html>
<html>
<head>
    <title>SmartPark</title>

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

        .hero {
            text-align: center;
            padding: 100px 20px;
        }

        .hero h1 {
            font-size: 55px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            color: #555;
        }

        .button {
            display: inline-block;
            margin-top: 30px;
            padding: 15px 30px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 25px;
            padding: 40px;
        }

        .card {
            background: white;
            width: 250px;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .card h3 {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<nav>
    <h2>🚗 SmartPark</h2>

    <div>
        <a href="index.php">Home</a>
        <a href="login.php">Find Parking</a>
        <a href="login.php">Login</a>
    </div>
</nav>

<section class="hero">

    <h1>Smart Parking.<br>Made Simple.</h1>

    <p>
        Find, predict and reserve parking using AI.
    </p>

    <a href="login.php" class="button">
    Find Parking
    </a>

</section>

<section class="features">

    <div class="card">
        <h3>🅿️ Real-Time Parking</h3>
        <p>
            See available parking spaces in real time.
        </p>
    </div>

    <div class="card">
        <h3>🤖 AI Prediction</h3>
        <p>
            Predict parking demand before you arrive.
        </p>
    </div>

    <div class="card">
        <h3>📱 QR Check-In</h3>
        <p>
            Reserve your slot and check in using QR.
        </p>
    </div>

</section>

</body>
</html>