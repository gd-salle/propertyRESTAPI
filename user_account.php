<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'dbconn.php';

$data = json_decode(file_get_contents("php://input"));

// Registration
if (
    !empty($data->account_type_id) &&
    !empty($data->username) &&
    !empty($data->email) &&
    !empty($data->password)
) {
    $account_type_id = intval(htmlspecialchars(strip_tags($data->account_type_id)));
    $username = htmlspecialchars(strip_tags($data->username));
    $email = htmlspecialchars(strip_tags($data->email));
    $password = password_hash($data->password, PASSWORD_BCRYPT); // Encrypt the password

    $query = "INSERT INTO user_accounts (account_type_id, username, email, password) VALUES (:account_type_id, :username, :email, :password)";

    $stmt = $db->prepare($query);

    $stmt->bindParam(':account_type_id', $account_type_id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User could not be registered.']);
    }
} 
// Login
else if (
    !empty($data->username) &&
    !empty($data->password) &&
    !empty($data->account_type_id)
) {
    $username = htmlspecialchars(strip_tags($data->username));
    $password = htmlspecialchars(strip_tags($data->password));
    $account_type_id = intval(htmlspecialchars(strip_tags($data->account_type_id)));

    $query = "SELECT id, password FROM user_accounts WHERE username = :username AND account_type_id = :account_type_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':account_type_id', $account_type_id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode(['success' => true, 'user_id' => $user['id']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username, password, or account type']);
    }
} 
else {
    echo json_encode(['success' => false, 'message' => 'Incomplete data.']);
}
?>
