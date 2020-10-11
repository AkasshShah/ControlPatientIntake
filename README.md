# ControlPatientIntake
Control plane for the MVC model of our patient intake micro-service for a Patient-Doctor Portal Site.

## Control (API) Features
 - [ ] Single Patient Information Entry (Type = "SPIE")
 - [ ] Single Patient Insurance Information Entry (Type = "SPIIE")
 - [ ] Single Patient Medical History Information Entry (Type = "SPMHIE")
 - [ ] Single Patient Family History Information Entry (Type = "SPFHIE")
 - [ ] Single Patient Information Retrieval (Type = "SPIR")
 - [ ] All Patient Information Retrieval (Type = "APIR")
 - [ ] Single Patient Insurance Information Retrieval (Type = "SPIIR")
 - [ ] Single Patient Medical History Information Retrieval (Type = "SPMHIR")
 - [ ] Single Patient Family History Information Retrieval (Type = "SPFHIR")
 - [ ] Single Patient Information Modification (Type = "SPIM")
 - [ ] Single Patient Insurance Information Modification (Type = "SPIIM")
 - [ ] Single Patient Medical History Information Modification (Type = "SPMHIM")
 - [ ] Single Patient Family History Information Modification (Type = "SPFHIM")
 - [ ] ADMIN ONLY: DELETE ALL ENTRIES IN (TRUNCATE) DATABASE (Type = "SPIE")

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

```PHP
$sendData = array(
    "Token" => "ExampleToken",
    "Type" => "SPIE",
    "Data" => array(
        "patient_first_name" => "Bob",
        "patient_middle_name" => "Llama",
        "patient_last_name" => "Alpaca",
        "patient_ssn" => "123456789",
        "patient_dob" => "1900-04-20", // DOB (Date of Birth) will be in YYYY-MM-DD format
        "patient_sex" => "A", // Will be a 1 character entry
        "patient_emailid" => "llama.alpaca@bob.com",
        "patient_contact_number" => "1234567890",
        "patient_address_line_1" => "At the farm",
        "patient_address_line_2" => "Round the corner",
        "patient_address_city" => "Mountain",
        "patient_address_state" => "Solid",
        "patient_zip_code" => "12345", // string of length 5
        "patient_insurance_id" => "123456789", // string of max length 9
        "patient_emergency_contact_name" => "Goat Sheep",
        "patient_emergency_contact_relationship" => "Cousin",
        "patient_emergency_contact_number" => "1234567890"
    )
);

// Make $data into a json-string and send POST request to the API
$url = 'https://web.njit.edu/~as2757/ControlPatientIntake/api.php';
$data = json_encode($sendData);
```