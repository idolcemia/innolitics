<?php

/*
 * Insert new company into table.
 */

// Initialize database connection and included dependencies.
require_once('../config/initialize.php');


// Send HTTP headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, X-Requested-With');

// Instantiate class for company table.
$company = new Company($db);

// Retrieve post data.
$data = json_decode(file_get_contents("php://input"));

// Queue post data.
$company->name = $data->name;
$company->account_id = $data->account_id;

// Endeavor to insert new company.  If fails table constraints, manage.
try {
    $company->insert();
} catch (Exception $e) {

    http_response_code(404);
    echo 'Caught exception: ' . $e->getMessage();

    die();
}

// Success.  Retrieve primary key, "id".
$company->read_single();

// Write response.
echo json_encode(
    array(
        'id' => $company->id,
        'name' => $company->name
    )
);
