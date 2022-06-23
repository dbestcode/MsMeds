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

## File List
### Common Particpant Pages
* drugs.php
	* Displays all medications given, used for monitoring participants in real time
* home.php
	* next gen patient screen
* index.php
	* home page for login
* ioreport.php
	* lists all operative reports that have been made
* oper.php
	home page for surgical view
* patient.php
	* **Main** patient view page
* glucometer.php
	* displays glucometer result for a patient
* mkrpt.php
	* form to make operative reports
* opencase.php
	* page to reset a patient

### General Use on multable pages
* adminconn.php
	* _unused_
* conn.php
	* Edit this to hold the UN and PW to the database
* give-med.php
	* _unused_
* getid.php
	* looks up suggesions for patient ID based on patient last name
* SetSession.php
	* sets session varibles and redirects to the appraite page

### Administration
* additem.php
	* Generic form, adds item to table chosen by session varables
* adduser.php
	* Form to add basic users to system, barcode **MUST** begin with 'MedId'
* admin.php
	* Administration portal page
* delete.php
	* Prompts before deltion for a record of any kind
* displaytable.php
	* Generic display table, chosen by session varables
* edit.php
	* Generic edits records in a table, chosen by session varables
* logout.php
	* Clears session and logs out.
* setglu.php
	* dialog to set glucometer
* sudo_meds.sql
	* contains the setup for the sql tables and some base data
* uploadfiles.php
	* for uploading PDFs of patient documents

### Folders
* txt/
* css/
* csv/
* img/
* patient_files/
* php/

