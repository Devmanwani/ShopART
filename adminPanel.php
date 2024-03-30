<?php
require_once("assets/includes/header.php");
require_once("assets/includes/config.php");

if(!(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin')){
    echo "You don't have Administration Rights!";
    exit();
}

class adminPanel {
    public function displayUsers() {
        global $con;

        $query = $con->prepare("SELECT * FROM users");
        $query->execute();

        echo "<table  id='AdminTable' border='1'>"; // Opening table tag

        while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr class='Udetails'>";
            echo "<td>User ID: " . $user['id'] . "</td>";
            echo "<td>Username: " . $user['username'] . "</td>";
            echo "<td><a href='?action=delete&id=" . $user['id'] . "'>Delete</a></td>";
            echo "<td><a href='settings.php?username=" . $user['username'] . "'>Edit</a></td>"; // Edit button
            echo "</tr>";
        }

        echo "</table>"; // Closing table tag
    }

    public function deleteUser($userId) {
        global $con;

        $query = $con->prepare("DELETE FROM users WHERE id = :id");
        $query->bindParam(':id', $userId);
        $query->execute();
        // You can add error handling and validation here if needed
    }
}

// Example usage:
$admin = new adminPanel();

// Check for delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $userId = $_GET['id'];
    $admin->deleteUser($userId);
}

// Display users
$admin->displayUsers();
?>
