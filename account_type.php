<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'dbconn.php';

try {
    // Create the query to fetch account types
    $query = "SELECT id, name FROM account_type";
    $stmt = $db->prepare($query);
    $stmt->execute();

    // Get the result set
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any results
    if ($result) {
        // Return the results as JSON
        echo json_encode($result);
    } else {
        // Return an empty JSON array if no results
        echo json_encode([]);
    }
} catch (PDOException $e) {
    // Return an error message in case of failure
    echo json_encode(['error' => $e->getMessage()]);
}
?>
