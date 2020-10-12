<?php
    require("account.php");
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
?>