<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'dbconn.php';

$data = json_decode(file_get_contents("php://input"));

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Parse incoming data
    $data = json_decode(file_get_contents("php://input"));

    // Add a new material sheet
    if (
        isset($data->department) && !empty($data->department) &&
        isset($data->laboratory) && !empty($data->laboratory) &&
        isset($data->date) && !empty($data->date) &&
        isset($data->accountable_person) && !empty($data->accountable_person) &&
        isset($data->qty) &&
        isset($data->unit) && !empty($data->unit) &&
        isset($data->description) && !empty($data->description) &&
        isset($data->po_number) && !empty($data->po_number) &&
        isset($data->account_code) && !empty($data->account_code) &&
        isset($data->account_name) && !empty($data->account_name) &&
        isset($data->tag_number) && !empty($data->tag_number) &&
        isset($data->acquisition_date) && !empty($data->acquisition_date) &&
        isset($data->location) && !empty($data->location) &&
        isset($data->unit_price) &&
        isset($data->total) &&
        isset($data->remarks) && !empty($data->remarks) &&
        isset($data->mr_number) && !empty($data->mr_number)
    ) {
        // Sanitize and validate data
        $department = htmlspecialchars(strip_tags($data->department));
        $laboratory = htmlspecialchars(strip_tags($data->laboratory));
        $date = htmlspecialchars(strip_tags($data->date));
        $accountable_person = htmlspecialchars(strip_tags($data->accountable_person));
        $qty = intval($data->qty);
        $unit = htmlspecialchars(strip_tags($data->unit));
        $description = htmlspecialchars(strip_tags($data->description));
        $po_number = htmlspecialchars(strip_tags($data->po_number));
        $account_code = htmlspecialchars(strip_tags($data->account_code));
        $account_name = htmlspecialchars(strip_tags($data->account_name));
        $tag_number = htmlspecialchars(strip_tags($data->tag_number));
        $acquisition_date = htmlspecialchars(strip_tags($data->acquisition_date));
        $location = htmlspecialchars(strip_tags($data->location));
        $unit_price = floatval($data->unit_price);
        $total = floatval($data->total);
        $remarks = htmlspecialchars(strip_tags($data->remarks));
        $mr_number = htmlspecialchars(strip_tags($data->mr_number));

        // Database insert query
        $query = "INSERT INTO material_monitoring_sheet 
                  (department, laboratory, date, accountable_person, qty, unit, description, po_number, account_code, account_name, tag_number, acquisition_date, location, unit_price, total, remarks, mr_number)
                  VALUES 
                  (:department, :laboratory, :date, :accountable_person, :qty, :unit, :description, :po_number, :account_code, :account_name, :tag_number, :acquisition_date, :location, :unit_price, :total, :remarks, :mr_number)";

        // Prepare and execute SQL statement
        $stmt = $db->prepare($query);

        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':laboratory', $laboratory);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':accountable_person', $accountable_person);
        $stmt->bindParam(':qty', $qty, PDO::PARAM_INT);
        $stmt->bindParam(':unit', $unit);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':po_number', $po_number);
        $stmt->bindParam(':account_code', $account_code);
        $stmt->bindParam(':account_name', $account_name);
        $stmt->bindParam(':tag_number', $tag_number);
        $stmt->bindParam(':acquisition_date', $acquisition_date);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':unit_price', $unit_price);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':remarks', $remarks);
        $stmt->bindParam(':mr_number', $mr_number);

        // Execute query and respond accordingly
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(['success' => true, 'message' => 'Material sheet added successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to add material sheet']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Incomplete or invalid data']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Fetch all material sheets
        $query = "SELECT * FROM material_monitoring_sheet";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Update an existing material sheet
        if (
            !empty($data->id) &&
            !empty($data->department) &&
            !empty($data->laboratory) &&
            !empty($data->date) &&
            !empty($data->accountable_person) &&
            isset($data->qty) &&
            !empty($data->unit) &&
            !empty($data->description) &&
            !empty($data->po_number) &&
            !empty($data->account_code) &&
            !empty($data->account_name) &&
            !empty($data->tag_number) &&
            !empty($data->acquisition_date) &&
            !empty($data->location) &&
            isset($data->unit_price) &&
            isset($data->total) &&
            !empty($data->remarks) &&
            !empty($data->mr_number)
        ) {
            $id = intval($data->id);
            $department = htmlspecialchars(strip_tags($data->department));
            $laboratory = htmlspecialchars(strip_tags($data->laboratory));
            $date = htmlspecialchars(strip_tags($data->date));
            $accountable_person = htmlspecialchars(strip_tags($data->accountable_person));
            $qty = intval($data->qty);
            $unit = htmlspecialchars(strip_tags($data->unit));
            $description = htmlspecialchars(strip_tags($data->description));
            $po_number = htmlspecialchars(strip_tags($data->po_number));
            $account_code = htmlspecialchars(strip_tags($data->account_code));
            $account_name = htmlspecialchars(strip_tags($data->account_name));
            $tag_number = htmlspecialchars(strip_tags($data->tag_number));
            $acquisition_date = htmlspecialchars(strip_tags($data->acquisition_date));
            $location = htmlspecialchars(strip_tags($data->location));
            $unit_price = floatval($data->unit_price);
            $total = floatval($data->total);
            $remarks = htmlspecialchars(strip_tags($data->remarks));
            $mr_number = htmlspecialchars(strip_tags($data->mr_number));

            $query = "UPDATE material_monitoring_sheet SET
                      department = :department,
                      laboratory = :laboratory,
                      date = :date,
                      accountable_person = :accountable_person,
                      qty = :qty,
                      unit = :unit,
                      description = :description,
                      po_number = :po_number,
                      account_code = :account_code,
                      account_name = :account_name,
                      tag_number = :tag_number,
                      acquisition_date = :acquisition_date,
                      location = :location,
                      unit_price = :unit_price,
                      total = :total,
                      remarks = :remarks,
                      mr_number = :mr_number
                      WHERE id = :id";

            $stmt = $db->prepare($query);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':department', $department);
            $stmt->bindParam(':laboratory', $laboratory);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':accountable_person', $accountable_person);
            $stmt->bindParam(':qty', $qty);
            $stmt->bindParam(':unit', $unit);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':po_number', $po_number);
            $stmt->bindParam(':account_code', $account_code);
            $stmt->bindParam(':account_name', $account_name);
            $stmt->bindParam(':tag_number', $tag_number);
            $stmt->bindParam(':acquisition_date', $acquisition_date);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':unit_price', $unit_price);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':remarks', $remarks);
            $stmt->bindParam(':mr_number', $mr_number);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Material sheet updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Material sheet could not be updated.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Incomplete data or invalid request.']);
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Delete a material sheet
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['id'])) {
            $id = $data['id'];

            $query = "DELETE FROM material_monitoring_sheet WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Material sheet deleted successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to delete material sheet']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
