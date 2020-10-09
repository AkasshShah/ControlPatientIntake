# ControlPatientIntake
Control plane for the MVC model of our patient intake micro-service for a Patient-Doctor Portal Site.

## Control (API) Features
 - [ ] Single Patient Information Entry
 - [ ] Single Patient Insurance Information Entry
 - [ ] Single Patient Medical History Information Entry
 - [ ] Single Patient Family History Information Entry
 - [ ] Single Patient Information Retrieval
 - [ ] All Patient Information Retrieval
 - [ ] Single Patient Insurance Information Retrieval
 - [ ] Single Patient Medical History Information Retrieval
 - [ ] Single Patient Family History Information Retrieval
 - [ ] Single Patient Information Modification
 - [ ] Single Patient Insurance Information Modification
 - [ ] Single Patient Medical History Information Modification
 - [ ] Single Patient Family History Information Modification
 - [ ] ADMIN ONLY: DELETE ALL ENTRIES IN (TRUNCATE) DATABASE

## API Documentation

### Location
API can be communicated with at https://web.njit.edu/~as2757/ControlPatientIntake/api.php
This document below will further guide you to interacting with it.
_**All information will be transfered in JSON format and not XML or any other**_

# Communicating with the API

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
