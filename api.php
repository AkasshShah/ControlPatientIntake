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
        //     if(strpos($accessType["column"], $permissionSymbols["permission"]) !== FALSE){
        //         // Call function to input
        //     }
        //     else{
        //         $output["Status"] = "PermissionDenied";
        //     }
        // break;

        // Single Patient Information Entry
        case "SPIE":
            if(strpos($accessType["PatientPermission"], $permissionSymbols["write"]) !== FALSE){
                // Call function to input
                $rArr = SPIE($data);
                if($rArr[0] === TRUE){
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
            if(strpos($accessType["InsurancePermission"], $permissionSymbols["write"]) !== FALSE){
                // Call function to input
                $rArr = SPIIE($data);
                if($rArr[0] === TRUE){
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
            if(strpos($accessType["MedicalHistoryPermission"], $permissionSymbols["write"]) !== FALSE){
                // Call function to input
                $rArr = SPMHIE($data);
                if($rArr[0] === TRUE){
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
            if(strpos($accessType["FamilyHistoryPermission"], $permissionSymbols["write"]) !== FALSE){
                // Call function to input
                $rArr = SPFHIE($data);
                if($rArr[0] === TRUE){
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

        // Single Patient Reason For Visit Information Entry
        case "SPRFVIE":
            if(strpos($accessType["MedicalHistoryPermission"], $permissionSymbols["write"]) !== FALSE){
                // Call function to input
                $rArr = SPRFVIE($data);
                if($rArr[0] === TRUE){
                    $output["Status"] = "OK";
                    $output["Log"][] = "Inserted Reason For Visit Information";
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

        // Single Patient Patient, Insurance, Medical History, Family History and Reason For Visit Information Entry
        case "SPPIMHFHRFVIE":
            if(
                strpos($accessType["PatientPermission"], $permissionSymbols["write"])  !== FALSE &&
                strpos($accessType["InsurancePermission"], $permissionSymbols["write"])  !== FALSE &&
                strpos($accessType["MedicalHistoryPermission"], $permissionSymbols["write"])  !== FALSE &&
                strpos($accessType["FamilyHistoryPermission"], $permissionSymbols["write"]) !== FALSE
            ){
                // Call function to input
                $patArr = SPIE($data);
                if($patArr[0] === TRUE){
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
                            $output["ReturnData"]["error"]["Insurance"] = $insArr[1];
                        }
                    }

                    $mhArr = SPMHIE($data);
                    if($mhArr[0] === TRUE){
                        $output["Log"][] = "Inserted Medical History Information";
                    }
                    else{
                        $output["ReturnData"]["error"]["MedicalHistory"] = $mhArr[1];
                    }

                    $fhArr = SPFHIE($data);
                    if($fhArr[0] === TRUE){
                        $output["Log"][] = "Inserted Family History Information";
                    }
                    else{
                        $output["ReturnData"]["error"]["FamilyHistory"] = $fhArr[1];
                    }

                    $rfvArr = SPRFVIE($data);
                    if($rfvArr[0] === TRUE){
                        $output["Log"][] = "Inserted Reason For Visit Information";
                    }
                    else{
                        $output["ReturnData"]["error"]["ReasonForVisit"] = $rfvArr[1];
                    }
                }
                else{
                    $output["Status"] = "InvalidData";
                    $output["ReturnData"]["error"]["Patient"] = $patArr[1];
                }
            }
            else{
                $output["Status"] = "PermissionDenied";
            }
        break;

        // Single Patient Information Retrieval By Patient ID
        case "SPIRBPID":
            if(strpos($accessType["PatientPermission"], $permissionSymbols["read"]) !== FALSE){
                // Call function to input
                $rArr = SPIRBPID($data);
                if($rArr[0] === TRUE){
                    $output["Status"] = "OK";
                    foreach($rArr[1] as $key => $val){
                        $output["ReturnData"][$key] = $val;
                    } 
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

        // All Patient Information Retrieval
        case "APIR":
            if(strpos($accessType["PatientPermission"], $permissionSymbols["read"]) !== FALSE){
                $output["Status"] = "OK";
                $output["ReturnData"]["patients"] = APIR();
            }
            else{
                $output["Status"] = "PermissionDenied";
            }
        break;
    }
    echo(json_encode($output));
    exit();
?>