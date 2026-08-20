<!DOCTYPE html>
<html>

<head>

    <title>Login - SmartPark</title>

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
            max-width: 450px;
            margin: 60px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 30px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .register {
            text-align: center;
            margin-top: 20px;
        }

        .register a {
            color: #2563eb;
            text-decoration: none;
        }

    </style>

</head>

<body>

<nav>

    <h2>🚗 SmartPark</h2>

    <div>
        <a href="index.php">Home</a>
        <a href="parking.php">Find Parking</a>
        <a href="register.php">Register</a>
    </div>

</nav>


<div class="container">

    <h1>Login</h1>

    <form action="login_process.php" method="POST">

        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Enter your password"
            required
        >

        <button type="submit">
            Login
        </button>

    </form>


    <div class="register">

        Don't have an account?

        <a href="register.php">
            Register
        </a>

    </div>

</div>

</body>

</html>