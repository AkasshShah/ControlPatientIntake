<?php
    require("GeneralFuncs.php");
    errorReporting();

    header("Access-Control-Allow-Origin: *");

    $output = array(
        "Status" => "OK",
        "Data" => array()
    );

    $json = file_get_contents('php://input');
    $input = json_decode($json, TRUE);

    $token = $input["Token"];
    $type = $input["Type"];
    $data = $input["Data"];

    if(!isTokenValid($token)){
        // Token is not valid
        $output["Status"] = "InvalidToken";
        $output["Data"]["Token"] = $token;
        echo(json_encode($output));
        exit();
    }
    // Token is valid

    $permissionSymbols = array(
        "write" => "W",
        "read" => "R"
    );

    $accessType = tokenAccessTypeRow($token);

    switch($type){

        // case "something":
        //     if(strpos($accessType["column"], $permissionSymbols["permission"]) !== false){
        //         // Call function to input
        //     }
        //     else{
        //         $output["Status"] = "PermissionDenied";
        //         echo(json_encode($output));
        //         exit();
        //     }
        // break;

        // Single Patient Information Entry
        case "SPIE":
            if(strpos($accessType["PatientPermission"], $permissionSymbols["write"]) !== false){
                // Call function to input
            }
            else{
                $output["Status"] = "PermissionDenied";
                echo(json_encode($output));
                exit();
            }
        break;

        // Single Patient Insurance Information Entry
        case "SPIIE":
            if(strpos($accessType["InsurancePermission"], $permissionSymbols["write"]) !== false){
                // Call function to input
            }
            else{
                $output["Status"] = "PermissionDenied";
                echo(json_encode($output));
                exit();
            }
        break;

        // Single Patient Medical History Information Entry
        case "SPMHIE":
            if(strpos($accessType["MedicalHistoryPermission"], $permissionSymbols["write"]) !== false){
                // Call function to input
            }
            else{
                $output["Status"] = "PermissionDenied";
                echo(json_encode($output));
                exit();
            }
        break;

        // Single Patient Family History Information Entry
        case "SPFHIE":
            if(strpos($accessType["FamilyHistoryPermission"], $permissionSymbols["write"]) !== false){
                // Call function to input
            }
            else{
                $output["Status"] = "PermissionDenied";
                echo(json_encode($output));
                exit();
            }
        break;
    }
?>