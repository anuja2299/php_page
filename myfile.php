<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation with PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            padding: 0;
        }
        .form-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Sign Up</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
        <span class="error"><?php echo $usernameErr ?? ''; ?></span><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
        <span class="error"><?php echo $emailErr ?? ''; ?></span><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <span class="error"><?php echo $passwordErr ?? ''; ?></span><br>

        <input type="submit" value="Submit">
    </form>
</div>

<?php
// Initialize error variables
$usernameErr = $emailErr = $passwordErr = "";
$username = $email = $password = "";

// Form validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Username validation
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = clean_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $usernameErr = "Only letters and numbers allowed";
        }
    }

    // Email validation
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = clean_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Password validation
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = clean_input($_POST["password"]);
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters";
        }
    }

    // If no errors, process the form data
    if (empty($usernameErr) && empty($emailErr) && empty($passwordErr)) {
        echo "<h3>Form Submitted Successfully!</h3>";
        echo "Username: " . $username . "<br>";
        echo "Email: " . $email . "<br>";
    }
}

// Function to clean user input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

</body>
</html>
