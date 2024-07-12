<?php 
// Prepare the SQL statement
include_once('database_con.php');
$stmt = $con->prepare("SELECT checkout.*, user_db.* FROM checkout JOIN user_db ON checkout.USER_ID = user_db.USER_ID ORDER BY checkout.USER_ID ASC");

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

echo "<table>";
echo "<tr><th>USER_ID</th><th>ITEM_DESC</th></tr>"; // Add more headers as needed

// Fetch the data
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['USER_ID']) . "</td>";
    echo "<td>" . htmlspecialchars($row['ITEM_DESC']) . "</td>";
    // Add more data cells as needed
    echo "</tr>";
}

echo "</table>";

// Close the statement
$stmt->close();
?>      