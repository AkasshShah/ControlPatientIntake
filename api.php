<?php
    require("GeneralFuncs.php");
    errorReporting();

    // header("Access-Control-Allow-Origin: *");

    $json = file_get_contents('php://input');
    $input = json_decode($json, TRUE);

    $token = $input["Token"];
    $type = $input["Type"];
    $data = $input["Data"];

    if(!isTokenValid($token)){
        // Token is not valid
        echo("Invalid Token");
        exit();
    }
    // Token is valid

    $accessType = tokenAccessTypeRow($token);

    switch($type){

        // Single Patient Information Entry
        case "SPIE":
            if($accessType["PatientPermission"] == "W"){
                // Call function to input
            }
        break;

        // Single Patient Insurance Information Entry
        case "SPIIE":
            if($accessType["InsurancePermission"] == "W"){
                // Call function to input
            }
        break;

        // Single Patient Medical History Information Entry
        case "SPMHIE":
            if($accessType["MedicalHistoryPermission"] == "W"){
                // Call function to input
            }
        break;

        // Single Patient Family History Information Entry
        case "SPFHIE":
            if($accessType["FamilyHistoryPermission"] == "W"){
                // Call function to input
            }
        break;
    }
?>