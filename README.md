# Ms. Meds

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

* Linux Server PC
* Client COWs(Computers on wheels)
	* Any computer/tablet that will run a modern web browser should work.
* USB barode scanners
* Barcoded labels
	* Drugs
	* patient ID bands
	* User ID badges

## Installation and setup

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

* Setup mysql user acount for administration and one for the app to make use of.

