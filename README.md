# Ms. Meds
---
### introduction
Ms.Meds is a web based application designed for students in healthcare 
settings to simulate using an EHR and EMAR. It can allow students to 
view patient information in an electronic format, administer 
medications, and write care notes.

Electronic documentation is an important part of healthcare.  Scanning 
medications is a difficult part of the process that is often overlooked 
when funds prevent getting a real medication dispensing system.  Ms. 
Meds has been developed to be a low cost solution that allows students 
to make a sim centers med admin use barcodes on medications, patient ID 
bands, and student IDs to administer meds like they would in the 
hospital.

The system allows participants to login via a barcode badge, scan their 
patients ID band and scan the drugs as they dispense and administer to 
the patient  Faculty will be able to view the medications live remotely 
to double to check that participants have not made an error, or if they 
have they will be able to adjust the simulation for the incorrect 
medication.

It is recommended you have some technical know how to setup the system 
at very minimum a high degree of comfort with a computer.  Using the 
system should be very simple so any participant that can used a smart 
phone can use it.  After it has been setup the sets to maintain it are 
fairly simple, but computer familiarity is required.

## hardware requirements
---
* Linux Server PC, Recommended PC specs:
    * Processor: 10th or 11th Gen Intel Core i5, i7 or i9 Processor, or Apple M1
    * Memory (RAM): 8-16 GB of RAM
    * Storage: 240 GB drive, or larger.
    * Physically wired to the network is strongly preferred
* Client COWs(Computers on wheels)
	* Any computer/tablet that will run a modern web browser should work.
* USB bar code scanners
* Bar code labels for:
	* Drugs
	* Patient ID bands
	* User IDs

## setup overview
---
**See MsMeds-DFU-Complete.pdf for complete install directions**

1. Setup server as described in *'MsMeds-DFU-Complete.pdf'*
    1. OS install
    2. Software
    3. MySQL
    4. PhpMyAdmin
2. Copy this repo into the *'/var/www/html'* folder
3. Import SampleDatabase.sql in this repo into PhpMyAdmin


## administration
---
**See MsMeds-DFU-Complete.pdf for complete install directions**


## TODO
---
* add section about turning off indexing directories in apache
* improved file upload with deletion capabity
