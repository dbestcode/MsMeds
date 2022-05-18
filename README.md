# Ms. Meds
---
#### Overview
Ms.Meds is a web based applcation is designed for students in healthcare setting to simulate using an EHR and EMR.  It can allow students to admiter medications,

Electronic documenation is n important part of healthcare.  Scanning medications is a difficult part of the process that is often overlooked when funds 
prevent getting a real medication dispensing system.  Ms. Meds has been devloped to be a low cost solution that allows students to make a sim centers med 
admin use barcodes on medications, patient ID bands, and student IDs to administer meds like they would in the hospital.

The system allows participants to login via a barcode badge, scan their patients ID band and scan the drugs as they dispense and administer to the patient.  
Faculty will be able to view the medications live remotely to double to check that participants have not made an error, or if they have they will be able to 
adjust the simulation for the incorrect medication.

In this session you will learn what you need to purchase for this system, how to install it and how to operate and maintain it.  It is recommended you have 
some technical know how to setup the system, but it is very simple so any participant that can used a smart phone can use it.  After it has been setup the 
sets to maintain it are fairly simple, though it can be customized if you are brave.

## Hardware Requirments
---
* Linux Server PC
* Client COWs(Computers on wheels)
	* Any computer/tablet that will run a modern web browser should work.
* USB barode scanners
* Barcoded labels
	* Drugs
	* patient ID bands
	* User ID badges

## Installation and setup
---
It is runs on a LAMP(Linux, Apache, MySql, PHP) server.

[Tutorial](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04)

Install overview:
* Fresh Linux PC install
* Update before you install anything
```sh
sudo apt update
Sudo apt upgrade
```
* Install the following(note: *This list may not be complete*):
```sh
sudo apt install net-tools apache2 mysql-server php libapache2-mod-php php-mysql
```
	* net-tools
	* apache2
	* mysql-server
	* php
	* libapache2-mod-php
	* php-mysql


#### mysql
---
* Setup mysql user acount for administration and one for the app to make use of.
* sudo_meds is the sample database that needs imported to make the application have sql data to work with
* tables:
	* drugs
	* patients
	* users
	* patient_files
	* drugs_admins
	* nurse_notes


## Administration
---
The 'Admin Portal' gives access to upload patient files and edit the data tables.

There are 4 directly editable data tables.

1. Patients  
	Contains patients and their information
2. Users  
	Contains all users.  Pins are not stored but hashes of them are.  Access levels are 1 for student,   
	2 for faculty who can view all actity, and 3 for Administration
3. Drugs  
	All medications
4. Patient_Files  
	Non standard files, such as diagnotics tests, extened patient hisotry office visit summary, etc...

### File List
* additem.php
	* Generic form, adds item to table chosen by session varables
* adduser.php
	* Form to add basic users to system, barcode **MUST** begin with 'MedId'
* adminconn.php
	* _Unused_
* admin.php
	* Administration portal page
* conn.php
	* Edit this to hold the UN and PW to the database
* delete.php
	* Prompts before deltion for a record of any kind
* displaytable.php
	* Generic display table, chosen by session varables
* drugs.php
* edit.php
* getid.php
* give-med.php
* glucometer.php
* HELP.md
* home.php
* index.php
* ioreport.php
* logout.php
* mkrpt.php
* opencase.php
* oper.php
* patient_files
* patient.php
* php
* README.md
* setglu.php
* SetSession.php
* sudo_meds.sql
* uploadfiles.php
* validate.js

* archive/
* txt/
* css/
* csv/
* img/

