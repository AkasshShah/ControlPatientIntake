<?php
    require("account.php");
    // require("DatabaseFuncs.php");
    date_default_timezone_set('America/New_York');

    function errorReporting()
    {
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
		ini_set('display_errors' , 1);
		return;
    }

    function mysqliOOP($accType){
        $cred = getSQLCreds($accType);
        if(!$cred){
            printf("Invalid Credential Type for function getSQLCreds()");
			exit();
        }
		$mysqli = new mysqli($cred["hostname"], $cred["username"], $cred["password"], $cred["project"]);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		return($mysqli);
    }

    function tokenAccessTypeRow($token){
        $ms = mysqliOOP("token");
        $query = "SELECT * FROM `PatientIntakeTokens` WHERE `Token` = '$token';";
        $res = $ms->query($query);
        $row = $res->fetch_assoc();
        $ms->close();
        return($row);
    }

    function tokenAccessType($token, $colName){
        $ms = mysqliOOP("token");
        $query = "SELECT * FROM `PatientIntakeTokens` WHERE `Token` = '$token';";
        $res = $ms->query($query);
        $rtn = "N";
        if($res->num_rows == 1){
            $row = $result->fetch_assoc();
            $rtn = $row[$colName];
		}
        $ms->close();
        return($rtn);
    }

    function isTokenValid($token){
        $ms = mysqliOOP("token");
        $query = "SELECT * FROM `PatientIntakeTokens` WHERE `Token` = '$token';";
        $res = $ms->query($query);
        $rtn = FALSE;
        if($res->num_rows == 1){
            $rtn = TRUE;
		}
        $ms->close();
        return($rtn);
    }

    // Single Patient Information Entry
    function SPIE($data){
        $ms = mysqliOOP("data");
        $query = "INSERT INTO PATIENT VALUES (NULL,'".$ms->real_escape_string($data["patient_first_name"])."', '".$ms->real_escape_string($data["patient_middle_name"])."',
            '".$ms->real_escape_string($data["patient_last_name"])."', '".$ms->real_escape_string($data["patient_ssn"])."', '".$ms->real_escape_string($data["patient_dob"])."', '".$ms->real_escape_string($data["patient_sex"])."',
            '".$ms->real_escape_string($data["patient_emailid"])."', '".$ms->real_escape_string($data["patient_contact_number"])."', '".$ms->real_escape_string($data["patient_address_line_1"])."',
            '".$ms->real_escape_string($data["patient_address_line_2"])."', '".$ms->real_escape_string($data["patient_address_city"])."', '".$ms->real_escape_string($data["patient_address_state"])."',
            '".$ms->real_escape_string($data["patient_zip_code"])."', '".$ms->real_escape_string($data["patient_insurance_id"])."',
            '".$ms->real_escape_string($data["patient_emergency_contact_name"])."',
            '".$ms->real_escape_string($data["patient_emergency_contact_relationship"])."',
            '".$ms->real_escape_string($data["patient_emergency_contact_number"])."');";
        $res = $ms->query($query);
        if(!$res){
            $err = $ms->error;
            $ms->close();
            return([FALSE, $err]);
        }
        $inserID = $ms->insert_id;
        $ms->close();
        return([TRUE, $inserID]);
    }

    // Single Patient Insurance Information Entry
    function SPIIE($data){
        $ms = mysqliOOP("data");
        $query = "INSERT INTO INSURANCE VALUES ('".$ms->real_escape_string($data["insurance_id"])."',
            '".$ms->real_escape_string($data["insurance_company_name"])."',
            '".$ms->real_escape_string($data["insurance_contact_number"])."',
            '".$ms->real_escape_string($data["insurance_pharmacy_network"])."',
            '".$ms->real_escape_string($data["insurance_group_number"])."',
            '".$ms->real_escape_string($data["insurance_plan_name"])."');";
        $res = $ms->query($query);
        if(!$res){
            $err = $ms->error;
            $ms->close();
            return([FALSE, $err]);
        }
        $ms->close();
        return([TRUE, ""]);
    }

    // Single Patient Medical History Information Entry
    function SPMHIE($data){
        $ms = mysqliOOP("data");
        $query = "INSERT INTO MEDICAL_HISTORY VALUES (
            '".$ms->real_escape_string($data["patient_id"])."',
            '".$ms->real_escape_string($data["patient_drinker"])."',
            '".$ms->real_escape_string($data["patient_smoker"])."',
            '".$ms->real_escape_string($data["patient_diabetes"])."',
            '".$ms->real_escape_string($data["patient_cancer"])."',
            '".$ms->real_escape_string($data["patient_high_blood_pressure"])."',
            '".$ms->real_escape_string($data["patient_heart_disease"])."',
            '".$ms->real_escape_string($data["patient_currently_pregnant"])."',
            '".$ms->real_escape_string($data["patient_metal_implants"])."',
            '".$ms->real_escape_string($data["patient_pacemaker"])."',
            '".$ms->real_escape_string($data["patient_allergies"])."');";
        $res = $ms->query($query);
        if(!$res){
            $err = $ms->error;
            $ms->close();
            return([FALSE, $err]);
        }
        $ms->close();
        return([TRUE, ""]);
    }

    function SPFHIE($data){
        $ms = mysqliOOP("data");
        $query = "INSERT INTO FAMILY_HISTORY VALUES (
            '".$ms->real_escape_string($data["patient_id"])."',
            '".$ms->real_escape_string($data["family_cancer"])."',
            '".$ms->real_escape_string($data["family_diabetes"])."',
            '".$ms->real_escape_string($data["family_high_blood_pressure"])."',
            '".$ms->real_escape_string($data["family_heart_disease"])."');";
        $res = $ms->query($query);
        if(!$res){
            $err = $ms->error;
            $ms->close();
            return([FALSE, $err]);
        }
        $ms->close();
        return([TRUE, ""]);
    }
    
?>