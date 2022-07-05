# Development Notes
---
Include Dev Log and simple overview of files/folders


## File List
---
### Common Participant Pages
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
* glucometer.php **feature incomplete, in development**
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
	* comes without UN and PW so users are forced to setup different PHP users at each server
* give-med.php
	* _unused_
* getid.php
	* looks up suggesions for patient ID based on patient last name
* SetSession.php
	* sets session varibles and redirects to the appraite page

### Administration Pages
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
* setglu.php **feature incomplete, in development**
	* dialog to set glucometer
* SampleDatabase.sql
	* contains the setup for the sql tables and some base data
* uploadfiles.php
	* for uploading PDFs of patient documents


## Dev Log:
---
* 7.5.22: Created log.  Updated README.md to include pdf computer instructions.
