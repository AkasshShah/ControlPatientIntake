# Database Tables:

## PATIENT

patient_id [varchar(32)]      <- primary key

patient_pass [varchar(32)]

patient_first_name [varchar(32)]

patient_middle_name [varchar(32)]

patient_last_name [varchar(32)]

patient_ssn [varchar(9)]

patient_dob [date]

patient_sex [char(1)]

patient_emailid [varchar(64)]

patient_contact_number [varchar(10)]

patient_address_line_1 [varchar(32)]

patient_address_line_2 [varchar(32)]

patient_address_city [varchar(32)]

patient_address_state [varchar(16)]

patient_zip_code [varchar(5)]

patient_insurance_id [varchar(9)]

patient_emergency_contact_name [varchar(64)]

patient_emergency_contact_relationship [varchar(32)]

patient_emergency_contact_number [varchar(10)]

## INSURANCE

insurance_id [varchar(9)]     <- primary key

insurance_company_name [varchar(32)]

insurance_contact_number [varchar(10)]

## MEDICAL_HISTORY

patient_id [varchar(32)]      <- primary key

patient_drinker [boolean] #drinks more than 7 drinks a week

patient_smoker [boolean]

patient_currently_pregnant [boolean]

patient_diabetes [boolean]

patient_diabetes [boolean]

patient_cancer [boolean]

patient_diabetes [boolean]

patient_metal_implants

patient_pacemaker

patient_allergies [varchar(128)]

## FAMILY_HISTORY

patient_id [varchar(32)]      <- primary key

family_cancer [boolean]

family_diabetes [boolean]

family_diabetes [boolean]

family_diabetes [boolean]