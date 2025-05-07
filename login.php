<?php
session_start();
require_once 'PharmacyDatabase.php';

$db = new PharmacyDatabase(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $user = $db->getUserByUsername($username);

    if ($user) {
        //  password
        if (password_verify($password, $user['password'])) {
            // user details
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type']; // pharmacist or patient

          
            if ($user['user_type'] === 'pharmacist') {
                header('Location: pharmacistDashboard.php');
            } else {
                header('Location: patientDashboard.php');
            }
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h2>Login</h2>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<form action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required><br><br>
    
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br><br>
    
    <button type="submit">Login</button>
</form>

</body>
</html>
