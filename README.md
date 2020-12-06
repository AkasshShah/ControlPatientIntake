# ControlPatientIntake
Control plane for the MVC model of our patient intake micro-service for a Patient-Doctor Portal Site.

## Control (API) Features
 - [x] [Single Patient Information Entry](#single-patient-information-entry)
 - [x] [Single Patient Insurance Information Entry](#single-patient-insurance-information-entry)
 - [x] [Single Patient Medical History Information Entry](#single-patient-medical-history-information-entry)
 - [x] [Single Patient Family History Information Entry](#single-patient-family-history-information-entry)
 - [x] [Single Patient Reason For Visit Information Entry](#single-patient-reason-for-visit-information-entry)
 - [x] [Single Patient Patient, Insurance, Medical History, Family History and Reason For Visit Information Entry](#single-patient-patient-insurance-medical-history-family-history-and-reason-for-visit-information-entry)
 - [x] [Single Patient Information Retrieval By Patient ID](#single-patient-information-retrieval-by-patient-id)
 - [x] [All Patient Information Retrieval](#all-patient-information-retrieval)
 - [x] [Single Patient Insurance Information Retrieval](#single-patient-insurance-information-retrieval)
 - [x] [Single Patient Medical History Information Retrieval](#single-patient-medical-history-information-retrieval)
 - [x] [Single Patient Family History Information Retrieval](#single-patient-family-history-information-retrieval)
 - [ ] [Single Patient Reason For Visit Information Retrieval](#single-patient-reason-for-visit-information-retrieval)
 - [ ] Single Patient Information Modification (Type = "SPIM")
 - [ ] Single Patient Insurance Information Modification (Type = "SPIIM")
 - [ ] Single Patient Medical History Information Modification (Type = "SPMHIM")
 - [ ] Single Patient Family History Information Modification (Type = "SPFHIM")
 - [ ] ADMIN ONLY: DELETE ALL ENTRIES IN (TRUNCATE) DATABASE (Type = "BEGONE")

## API Documentation

### Location
API can be communicated with at https://web.njit.edu/~as2757/ControlPatientIntake/api.php
This document below will further guide you to interacting with it.
_**All information will be transfered in JSON format and not XML or any other**_

# Communicating with the API

The API will be looking for POST requests for higher security and larger message sizes.
Note: Everything is case-sensitive

## Sending the API a message

The message must be JSON formatted. The message will hold the following in a JSON string:
 - Token
 - Type
 - Data
 
### Token

To make a call to this API, a token key must be passed along so that the API knows whether you have read/write and other permissions. Tokens will be handed to group 1 through group 4 privately.

### Type

This will hold the information of what kind of operation you want the API to be doing. There are certain fixed values that this header can take.

### Data

Any auxillary information that the API needs for this request to be handled.

## Details of each case

All the listed detials will be enclosed in a ```dictionary``` or ```named list``` and then ```json-ified``` and sent as a ```POST``` request to the API.

### Single Patient Information Entry

Here is what the structure will look like with an example in ```PHP```.

#### SPIE Structure

 - Token => string
 - Type => ```"SPIE"```
 - Data => array
   - patient_first_name => string with a max length of 32
   - patient_middle_name => string with a max length of 32
   - patient_last_name => string with a max length of 32
   - patient_ssn => string with a length of 9
   - patient_dob => string following a YYYY-MM-DD format
   - patient_sex => string with a length of 1
   - patient_emailid => string with a max length of 64
   - patient_contact_number => string with a max length of 10
   - patient_address_line_1 => string with a max length of 32
   - patient_address_line_2 => string with a max length of 32
   - patient_address_city => string with a max length of 32
   - patient_address_state => string with a max length of 16
   - patient_zip_code => string with a length of 5
   - patient_insurance_id => string with a max length of 9
   - patient_emergency_contact_name => string with a max length of 64
   - patient_emergency_contact_relationship => string with a max length of 32
   - patient_emergency_contact_number => string with a max length of 10

####  SPIE `"ReturnData"`

`"ReturnData"` will be an array with the following keys:
 - patient_id : ID for the patient that was just inserted if information was valid

#### SPIE Example in ```PHP```

```PHP
$sendData = array(
    "Token" => "ExampleToken",
    "Type" => "SPIE",
    "Data" => array(
        "patient_first_name" => "Bob",
        "patient_middle_name" => "Llama",
        "patient_last_name" => "Alpaca",
        "patient_ssn" => "123456789",
        "patient_dob" => "1900-04-20",
        "patient_sex" => "A",
        "patient_emailid" => "llama.alpaca@bob.com",
        "patient_contact_number" => "1234567890",
        "patient_address_line_1" => "At the farm",
        "patient_address_line_2" => "Round the corner",
        "patient_address_city" => "Mountain",
        "patient_address_state" => "Solid",
        "patient_zip_code" => "12345",
        "patient_insurance_id" => "123456789",
        "patient_emergency_contact_name" => "Goat Sheep",
        "patient_emergency_contact_relationship" => "Cousin",
        "patient_emergency_contact_number" => "1234567890"
    )
);

// Make $data into a json-string and send POST request to the API
$url = 'https://web.njit.edu/~as2757/ControlPatientIntake/api.php';
$data = json_encode($sendData);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => $data
    )
);
    
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
```

### Single Patient Insurance Information Entry

#### SPIIE Structure

 - Token => string
 - Type => ```"SPIIE"```
 - Data => array
   - insurance_id => string with a max length of 9
   - insurance_company_name => string with a max length of 32
   - insurance_contact_number => string with a max length of 10
   - insurance_pharmancy_network => string with a length of 128
   - insurance_group_number => string with a max length of 32
   - insurance_plan_name  => string with a max length of 32

### Single Patient Medical History Information Entry

#### SPMHIE Structure

 - Token => string
 - Type => ```"SPMHIE"```
 - Data => array
   - patient_id => an int that refers to a certain patient (Can be obtained when doing SPIE for the patient or with a search)
   - patient_drinker => boolean (must be either 0 or 1) (Not True/False)
   - patient_smoker => boolean (must be either 0 or 1) (Not True/False)
   - patient_diabetes => boolean (must be either 0 or 1) (Not True/False)
   - patient_cancer => boolean (must be either 0 or 1) (Not True/False)
   - patient_high_blood_pressure => boolean (must be either 0 or 1) (Not True/False)
   - patient_heart_disease => boolean (must be either 0 or 1) (Not True/False)
   - patient_currently_pregnant => boolean (must be either 0 or 1) (Not True/False)
   - patient_metal_implants => boolean (must be either 0 or 1) (Not True/False)
   - patient_pacemaker => boolean (must be either 0 or 1) (Not True/False)
   - patient_allergies => string with a max length of 128

### Single Patient Family History Information Entry

 - Token => string
 - Type => ```"SPFHIE"```
 - Data => array
   - patient_id => an int that refers to a certain patient (Can be obtained when doing SPIE for the patient or with a search)
   - family_cancer => boolean (must be either 0 or 1) (Not True/False)
   - family_diabetes => boolean (must be either 0 or 1) (Not True/False)
   - family_high_blood_pressure => boolean (must be either 0 or 1) (Not True/False)
   - family_heart_conditions => boolean (must be either 0 or 1) (Not True/False)
   - family_sickle_cell_disease => boolean (must be either 0 or 1) (Not True/False)
   - family_stroke => boolean (must be either 0 or 1) (Not True/False)
   - family_heart_disease => boolean (must be either 0 or 1) (Not True/False)
   - family_bleeding_disorder => boolean (must be either 0 or 1) (Not True/False)

### Single Patient Reason For Visit Information Entry

#### SPRFVIE Structure

 - Token => string
 - Type => ```"SPRFVIE"```
 - Data => array
   - patient_id => an int that refers to a certain patient (Can be obtained when doing SPIE for the patient or with a search)
   - reason_for_visit => string with a max length of 7000

### Single Patient Patient, Insurance, Medical History, Family History and Reason For Visit Information Entry

#### SPPIMHFHRFVIE Structure

 - Token => string
 - Type => ```"SPPIMHFHRFVIE"```
 - Data => array
   - patient_first_name => string with a max length of 32
   - patient_middle_name => string with a max length of 32
   - patient_last_name => string with a max length of 32
   - patient_ssn => string with a length of 9
   - patient_dob => string following a YYYY-MM-DD format
   - patient_sex => string with a length of 1
   - patient_emailid => string with a max length of 64
   - patient_contact_number => string with a max length of 10
   - patient_address_line_1 => string with a max length of 32
   - patient_address_line_2 => string with a max length of 32
   - patient_address_city => string with a max length of 32
   - patient_address_state => string with a max length of 16
   - patient_zip_code => string with a length of 5
   - patient_insurance_id => string with a max length of 9 [Can be left blank (Empty String)]
   - patient_emergency_contact_name => string with a max length of 64
   - patient_emergency_contact_relationship => string with a max length of 32
   - patient_emergency_contact_number => string with a max length of 10
   - insurance_company_name => string with a max length of 32 [Can be left blank (Empty String)]
   - insurance_contact_number => string with a max length of 10 [Can be left blank (Empty String)]
   - insurance_pharmancy_network => string with a length of 128 [Can be left blank (Empty String)]
   - insurance_group_number => string with a max length of 32 [Can be left blank (Empty String)]
   - insurance_plan_name  => string with a max length of 32 [Can be left blank (Empty String)]
   - patient_drinker => boolean (must be either 0 or 1) (Not True/False)
   - patient_smoker => boolean (must be either 0 or 1) (Not True/False)
   - patient_diabetes => boolean (must be either 0 or 1) (Not True/False)
   - patient_cancer => boolean (must be either 0 or 1) (Not True/False)
   - patient_high_blood_pressure => boolean (must be either 0 or 1) (Not True/False)
   - patient_heart_disease => boolean (must be either 0 or 1) (Not True/False)
   - patient_currently_pregnant => boolean (must be either 0 or 1) (Not True/False)
   - patient_metal_implants => boolean (must be either 0 or 1) (Not True/False)
   - patient_pacemaker => boolean (must be either 0 or 1) (Not True/False)
   - patient_allergies => string with a max length of 128
   - family_cancer => boolean (must be either 0 or 1) (Not True/False)
   - family_diabetes => boolean (must be either 0 or 1) (Not True/False)
   - family_high_blood_pressure => boolean (must be either 0 or 1) (Not True/False)
   - family_heart_conditions => boolean (must be either 0 or 1) (Not True/False)
   - family_sickle_cell_disease => boolean (must be either 0 or 1) (Not True/False)
   - family_stroke => boolean (must be either 0 or 1) (Not True/False)
   - family_heart_disease => boolean (must be either 0 or 1) (Not True/False)
   - family_bleeding_disorder => boolean (must be either 0 or 1) (Not True/False)
   - reason_for_visit => string with a max length of 7000

####  SPPIMHFHRFVIE `"ReturnData"`

`"ReturnData"` will be an array with the following keys:
 - patient_id : ID for the patient that was just inserted if information was valid

### Single Patient Information Retrieval By Patient ID

#### SPIRBPID Structure

 - Token => string
 - Type => ```"SPIRBPID"```
 - Data => array
   - patient_id => an int that refers to a certain patient (Can be obtained when doing SPIE for the patient or with a search)

####  SPIRBPID `"ReturnData"`

`"ReturnData"` will be an array with the following keys:
 - patient_id
 - patient_first_name
 - patient_middle_name
 - patient_last_name
 - patient_ssn
 - patient_dob
 - patient_sex
 - patient_emailid
 - patient_contact_number
 - patient_address_line_1
 - patient_address_line_2
 - patient_address_city
 - patient_address_state
 - patient_zip_code
 - patient_insurance_id
 - patient_emergency_contact_name
 - patient_emergency_contact_relationship
 - patient_emergency_contact_number

### All Patient Information Retrieval

#### APIR Structure

 - Token => string
 - Type => ```"APIR"```
 - Data => Empty Array

####  APIR `"ReturnData"`

`"ReturnData"` will have a list of arrays in a key `"patients"`. Each array will have the following keys:
 - patient_id
 - patient_first_name
 - patient_middle_name
 - patient_last_name
 - patient_ssn
 - patient_dob
 - patient_sex
 - patient_emailid
 - patient_contact_number
 - patient_address_line_1
 - patient_address_line_2
 - patient_address_city
 - patient_address_state
 - patient_zip_code
 - patient_insurance_id
 - patient_emergency_contact_name
 - patient_emergency_contact_relationship
 - patient_emergency_contact_number

### Single Patient Insurance Information Retrieval

#### SPIIR Structure

 - Token => string
 - Type => ```"SPIIR"```
 - Data => array
   - insurance_id => string with a max length of 9

####  SPIIR `"ReturnData"`

`"ReturnData"` will be an array with the following keys:
 - insurance_id
 - insurance_company_name
 - insurance_pharmancy_network
 - insurance_group_number
 - insurance_plan_name

### Single Patient Medical History Information Retrieval

#### SPMHIR Structure

 - Token => string
 - Type => ```"SPMHIR"```
 - Data => array
   - patient_id => id of patient

####  SPMHIR `"ReturnData"`

`"ReturnData"` will be an array with the following keys:
 - patient_id
 - patient_drinker
 - patient_smoker
 - patient_currently_pregnant
 - patient_diabetes
 - patient_cancer
 - patient_metal_implants
 - patient_pacemaker
 - patient_allergies

### Single Patient Family History Information Retrieval

#### SPFHIR Structure

 - Token => string
 - Type => ```"SPFHIR"```
 - Data => array
   - patient_id => id of patient

`"ReturnData"` will be an array with the following keys:
 - patient_id
 - family_cancer
 - family_diabetes
 - family_high_blood_pressure
 - family_heart_conditions
 - family_sickle_cell_disease
 - family_stroke
 - family_heart_disease
 - family_bleeding_disorder

### Single Patient Reason For Visit Information Retrieval

#### SPRFVIR Structure

 - Token => string
 - Type => ```"SPRFVIR"```
 - Data => array
   - patient_id => id of patient

####  SPRFVIR `"ReturnData"`

`"ReturnData"` will have a list of arrays in a key `"ReasonForVisit"`. Each array will have the following keys:
 - patient_id
 - time_of_input
 - reason_for_visit

## Receiving a response from the API

The response from the API will be a JSON encoded array with three main keys:
 - Status
 - ReturnData
 - Log

### Status

Status will be a string. Status can take the following values:
 - `"OK"` when the API receives what is expected and the `Token` passed has valid permissions
 - `"PermissionDenied"` when the Token isn't valid or if that group doesn't have access to complete the task
 - `"InvalidData"` when the data received by the API wasn't valid, like entering a `string` of length 20 for `SSN`
 - `"InvalidType"` when the `"Type"` Doesn't match any listed in here