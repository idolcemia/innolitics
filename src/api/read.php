<?php

/*
 * Retrieve all companies
 */

// Initialize database connection and included dependencies.
require_once('../config/initialize.php');


// Send HTTP header
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


// Instantiate class for company table.
$company = new Company($db);

$result = $company->read();

$rows = $result->rowCount();

// If found any companies ...
if ($rows > 0) {

    $company_arr = array();
    $company_arr['data'] = array();

    // Retrieve all.
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $company_item = array(
            'id' => $id,
            'name' => $name,
            'account_id' => $account_id
        );

        array_push($company_arr['data'], $company_item);

    }

    // Array populated.  Write.
    echo json_encode($company_arr);

} else {

    // Unlikely, but empty table.
    echo json_encode(array('message' => 'No companies found'));

}

