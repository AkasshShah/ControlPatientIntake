# ControlPatientIntake
Control plane for the MVC model of our patient intake micro-service for a Patient-Doctor Portal Site.

## Control (API) Features
 - [ ] [Single Patient Information Entry](#single-patient-information-entry)
 - [ ] [Single Patient Insurance Information Entry](#single-patient-insurance-information-entry)
 - [ ] [Single Patient Medical History Information Entry](#single-patient-medical-history-information-entry)
 - [ ] [Single Patient Family History Information Entry](#single-patient-family-history-information-entry)
 - [ ] [Single Patient Information Retrieval By Patient ID](#single-patient-information-retrieval-by-patient-id)
 - [ ] All Patient Information Retrieval (Type = "APIR")
 - [ ] Single Patient Insurance Information Retrieval (Type = "SPIIR")
 - [ ] Single Patient Medical History Information Retrieval (Type = "SPMHIR")
 - [ ] Single Patient Family History Information Retrieval (Type = "SPFHIR")
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
   - insurance_pharmancy_network => string with a length of 32
   - insurance_group_number => string with a max length of 32
   - insurance_plan_name  => string with a max length of 32

### Single Patient Medical History Information Entry

#### SPMHIE Structure

 - Token => string
 - Type => ```"SPMHIE"```
 - Data => array
   - patient_id => an int that refers to a certain patient (Can be obtained when doing SPIE for the patient or with a search)
   - patient_drinker => boolean
   - patient_smoker => boolean
   - patient_currently_pregnant => boolean
   - patient_diabetes => boolean
   - patient_cancer => boolean
   - patient_metal_implants => boolean
   - patient_pacemaker => boolean
   - patient_allergies => string with a max length of 128

### Single Patient Family History Information Entry

 - Token => string
 - Type => ```"SPFHIE"```
 - Data => array
   - patient_id => an int that refers to a certain patient (Can be obtained when doing SPIE for the patient or with a search)
   - family_cancer => boolean
   - family_diabetes => boolean
   - family_heart_conditions => boolean
   - family_bleeding_disorder => boolean
   - family_stroke => boolean
   - family_sickle_cell_disease => boolean

### Single Patient Information Retrieval By Patient ID

#### SPIR Structure

 - Token => string
 - Type => ```"SPIRBPID"```
 - Data => array
   - patient_id => an int that refers to a certain patient (Can be obtained when doing SPIE for the patient or with a search)
