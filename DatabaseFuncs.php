<?php
    require("account.php");
    require("GeneralFuncs.php");
    date_default_timezone_set('America/New_York');

    function patientInput($data){
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
        if($res){
            $ms->close();
            return([TRUE, $ms->insert_id]);
        }
        else{
            $err = $mysqli->error;
            $ms->close();
            return([FALSE, $err]);
        }
    }
?>