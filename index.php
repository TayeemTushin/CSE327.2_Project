<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ride Sharing Platform</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }
        body {
            background: #f6f6fa;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #fff;
            padding: 32px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            width: 340px;
            overflow: hidden; /* Add this line */
        }
        h2 {
            text-align: center;
            margin-bottom: 18px;
            color: #982dea;
        }
        .tabs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .tabs button {
            flex: 1;
            padding: 10px 0;
            border: none;
            background: #eee;
            color: #333;
            font-weight: 500;
            cursor: pointer;
            border-radius: 6px 6px 0 0;
            margin-right: 2px;
            transition: background 0.2s;
        }
        .tabs button.active {
            background: #982dea;
            color: #fff;
        }
        form {
            display: none;
            flex-direction: column;
        }
        form.active {
            display: flex;
        }
        .input-box {
            margin-bottom: 14px;
            position: relative;
        }
        .input-box input {
            width: 100%;
            padding: 10px 36px 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            font-size: 15px;
        }
        .input-box i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        .btn {
            background: #982dea;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #7a1fc2;
        }
        .switch-link {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .switch-link a {
            color: #982dea;
            text-decoration: none;
            font-weight: 500;
        }
        .otp-info {
            text-align: center;
            color: #555;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="tabs">
        <button id="userTab" class="active">User</button>
        <button id="driverTab">Driver</button>
    </div>

    <!-- USER LOGIN FORM -->
    <form id="userLoginForm" class="active" action="login.php" method="POST">
        <h2>User Login</h2>
        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
            <i class="bx bx-user"></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class="bx bx-lock"></i>
        </div>
        <button type="submit" class="btn">Login</button>
        <div class="switch-link">
            Don't have an account? <a href="#" id="showUserRegister">Register</a>
        </div>
    </form>

    <!-- USER REGISTER FORM -->
    <form id="userRegisterForm" action="send_otp.php" method="POST">
        <h2>User Register</h2>
        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
            <i class="bx bx-user"></i>
        </div>
        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
            <i class="bx bx-envelope"></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class="bx bx-lock"></i>
        </div>
        <button type="submit" class="btn">Register & Get OTP</button>
        <div class="switch-link">
            Already have an account? <a href="#" id="showUserLogin">Login</a>
        </div>
    </form>

    <!-- USER OTP FORM -->
    <?php if (isset($_GET['show']) && $_GET['show'] === 'otp'): ?>
    <form id="userOtpForm" action="verify_otp.php" method="POST" class="active">
        <h2>User OTP</h2>
        <div class="otp-info">Enter the OTP sent to your email</div>
        <div class="input-box">
            <input type="text" name="otp_input" placeholder="Enter OTP" required>
        </div>
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? '', ENT_QUOTES); ?>">
        <button type="submit" class="btn">Verify OTP</button>
    </form>
    <?php endif; ?>

    <!-- DRIVER LOGIN FORM -->
    <form id="driverLoginForm" action="driver_login.php" method="POST">
        <h2>Driver Login</h2>
        <div class="input-box">
            <input type="text" name="name" placeholder="Driver Name" required>
            <i class="bx bx-user"></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class="bx bx-lock"></i>
        </div>
        <button type="submit" class="btn">Login</button>
        <div class="switch-link">
            Don't have an account? <a href="#" id="showDriverRegister">Register</a>
        </div>
    </form>

    <!-- DRIVER REGISTER FORM -->
    <form id="driverRegisterForm" action="driver_send_otp.php" method="POST">
        <h2>Driver Register</h2>
        <div class="input-box">
            <input type="text" name="name" placeholder="Driver Name" required>
            <i class="bx bx-user"></i>
        </div>
        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
            <i class="bx bx-envelope"></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class="bx bx-lock"></i>
        </div>
        <div class="input-box">
            <input type="text" name="phone" placeholder="Phone Number" required>
            <i class="bx bx-phone"></i>
        </div>
        <div class="input-box">
            <input type="text" name="license_no" placeholder="License Number" required>
            <i class="bx bx-id-card"></i>
        </div>
        <button type="submit" class="btn">Register & Get OTP</button>
        <div class="switch-link">
            Already have an account? <a href="#" id="showDriverLogin">Login</a>
        </div>
    </form>

    <!-- DRIVER OTP FORM -->
    <?php if (isset($_GET['show']) && $_GET['show'] === 'driver_otp'): ?>
    <form id="driverOtpForm" action="driver_verify_otp.php" method="POST" class="active">
        <h2>Driver OTP</h2>
        <div class="otp-info">Enter the OTP sent to your email</div>
        <div class="input-box">
            <input type="text" name="otp_input" placeholder="Enter OTP" required>
        </div>
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? '', ENT_QUOTES); ?>">
        <button type="submit" class="btn">Verify OTP</button>
    </form>
    <?php endif; ?>
</div>

<script>
    // Tab switching
    const userTab = document.getElementById('userTab');
    const driverTab = document.getElementById('driverTab');
    const userLoginForm = document.getElementById('userLoginForm');
    const userRegisterForm = document.getElementById('userRegisterForm');
    const driverLoginForm = document.getElementById('driverLoginForm');
    const driverRegisterForm = document.getElementById('driverRegisterForm');
    // Hide all forms except the active one
    function showForm(form) {
        [userLoginForm, userRegisterForm, driverLoginForm, driverRegisterForm].forEach(f => f.classList.remove('active'));
        if (form) form.classList.add('active');
    }
    userTab.onclick = () => {
        userTab.classList.add('active');
        driverTab.classList.remove('active');
        showForm(userLoginForm);
    };
    driverTab.onclick = () => {
        driverTab.classList.add('active');
        userTab.classList.remove('active');
        showForm(driverLoginForm);
    };
    document.getElementById('showUserRegister').onclick = (e) => { e.preventDefault(); showForm(userRegisterForm); };
    document.getElementById('showUserLogin').onclick = (e) => { e.preventDefault(); showForm(userLoginForm); };
    document.getElementById('showDriverRegister').onclick = (e) => { e.preventDefault(); showForm(driverRegisterForm); };
    document.getElementById('showDriverLogin').onclick = (e) => { e.preventDefault(); showForm(driverLoginForm); };
</script>
</body>
</html>