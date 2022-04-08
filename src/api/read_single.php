<?php

// Initialize database connection and included dependencies.
require_once('../config/initialize.php');

// Send headers.
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$company = new Company($db);

// Retrieve parameter for account_no from request.
$company->account_id = $_GET['account_id'] ?? die();

// Execute the request.  If successful, return company details.
if ($company->read_single()) {

    $company_arr = array(
        'id' => $company->id,
        'company' => $company->name,
        'account_id' => $company->account_id
    );

    echo json_encode($company_arr);

}
    else {

        // Company not found.
        http_response_code(404);

        echo json_encode(array('message' => 'Company not found'));

    }

