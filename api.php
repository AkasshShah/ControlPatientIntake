<?php
    require("GeneralFuncs.php");
    errorReporting();

    header("Access-Control-Allow-Origin: *");

    $output = array(
        "Status" => "InvalidType",
        "ReturnData" => array(
            "error" => array()
        ),
        "Log" => array()
    );

    $json = file_get_contents('php://input');
    $input = json_decode($json, TRUE);

    $token = $input["Token"];
    $type = $input["Type"];
    $data = $input["Data"];

    if(!isTokenValid($token)){
        // Token is not valid
        $output["Status"] = "InvalidToken";
        $output["ReturnData"]["Token"] = $token;
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
        //     if(strpos($accessType["column"], $permissionSymbols["permission"])){
        //         // Call function to input
        //     }
        //     else{
        //         $output["Status"] = "PermissionDenied";
        //     }
        // break;

        // Single Patient Information Entry
        case "SPIE":
            if(strpos($accessType["PatientPermission"], $permissionSymbols["write"])){
                // Call function to input
                $rArr = SPIE($data);
                if($rArr[0]){
                    $output["Status"] = "OK";
                    $output["ReturnData"]["patient_id"] = $rArr[1];
                    $output["Log"][] = "Inserted Patient with ID " . $rArr[1];
                }
                else{
                    $output["Status"] = "InvalidData";
                    $output["ReturnData"]["error"][] = $rArr[1];
                }
            }
            else{
                $output["Status"] = "PermissionDenied";
            }
        break;

        // Single Patient Insurance Information Entry
        case "SPIIE":
            if(strpos($accessType["InsurancePermission"], $permissionSymbols["write"])){
                // Call function to input
                $rArr = SPIIE($data);
                if($rArr[0]){
                    $output["Status"] = "OK";
                    $output["Log"][] = "Inserted Insurance Information";
                }
                else{
                    $output["Status"] = "InvalidData";
                    $output["ReturnData"]["error"][] = $rArr[1];
                }
            }
            else{
                $output["Status"] = "PermissionDenied";
            }
        break;

        // Single Patient Medical History Information Entry
        case "SPMHIE":
            if(strpos($accessType["MedicalHistoryPermission"], $permissionSymbols["write"])){
                // Call function to input
                $rArr = SPMHIE($data);
                if($rArr[0]){
                    $output["Status"] = "OK";
                    $output["Log"][] = "Inserted Medical History Information";
                }
                else{
                    $output["Status"] = "InvalidData";
                    $output["ReturnData"]["error"][] = $rArr[1];
                }
            }
            else{
                $output["Status"] = "PermissionDenied";
            }
        break;

        // Single Patient Family History Information Entry
        case "SPFHIE":
            if(strpos($accessType["FamilyHistoryPermission"], $permissionSymbols["write"])){
                // Call function to input
                $rArr = SPFHIE($data);
                if($rArr[0]){
                    $output["Status"] = "OK";
                    $output["Log"][] = "Inserted Family History Information";
                }
                else{
                    $output["Status"] = "InvalidData";
                    $output["ReturnData"]["error"][] = $rArr[1];
                }
            }
            else{
                $output["Status"] = "PermissionDenied";
            }
        break;
        case "SPPIMHFHIE":
            if(
                strpos($accessType["PatientPermission"], $permissionSymbols["write"]) &&
                strpos($accessType["InsurancePermission"], $permissionSymbols["write"]) &&
                strpos($accessType["MedicalHistoryPermission"], $permissionSymbols["write"]) &&
                strpos($accessType["FamilyHistoryPermission"], $permissionSymbols["write"])
            ){
                // Call function to input
                $patArr = SPIE($data);
                if($patArr[0]){
                    $output["Status"] = "OK";
                    $output["ReturnData"]["patient_id"] = $patArr[1];
                    $data["patient_id"] = $output["ReturnData"]["patient_id"];
                    $output["Log"][] = "Inserted Patient with ID " . $patArr[1];
                    
                    if(!empty(trim($data["patient_insurance_id"]))){
                        $data["insurance_id"] = $data["patient_insurance_id"];
                        $insArr = SPIIE($data);
                        if($insArr[0]){
                            $output["Log"][] = "Inserted Insurance Information";
                        }
                        else{
                            $output["ReturnData"]["error"][] = $insArr[1];
                        }
                    }

                    $mhArr = SPMHIE($data);
                    if($mhArr[0]){
                        $output["Log"][] = "Inserted Medical History Information";
                    }
                    else{
                        $output["ReturnData"]["error"][] = $mhArr[1];
                    }

                    $fhArr = SPFHIE($data);
                    if($fhArr[0]){
                        $output["Log"][] = "Inserted Family History Information";
                    }
                    else{
                        $output["ReturnData"]["error"][] = $fhArr[1];
                    }
                }
                else{
                    $output["Status"] = "InvalidData";
                    $output["ReturnData"]["error"][] = $patArr[1];
                }
            }
            else{
                $output["Status"] = "PermissionDenied";
            }
        break;
    }
    echo(json_encode($output));
    exit();
?>