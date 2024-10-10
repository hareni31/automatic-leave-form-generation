<!-- create_user_form.php -->
<?php
// Any PHP code you want to include before the HTML content can be placed here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure correct path to your CSS file -->
</head>
<body>
    <h2>Create User</h2>
   <form action="create_user.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <label for="role">Role:</label>
    <select id="role" name="role">
        <option value="admin">Admin</option>
        <option value="teacher">Teacher</option>
        <option value="student">Student</option>
    </select>
    <input type="submit" value="Create User">
</form>

        <form action="admin_dashboard.php" method="get"> <!-- Form to submit to admin dashboard -->
        <button type="submit">Return to Dashboard</button> <!-- Button to return to admin dashboard -->
    </form>
    </form>
</body>
</html>
