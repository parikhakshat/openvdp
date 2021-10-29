# OpenVDP
## Open Source Vulnerability Disclosure Program
<img src="https://user-images.githubusercontent.com/68412398/139376726-ce8ebf17-3cd4-4e40-b70d-f9fb032e4945.png" width="250" height="250">
##### Created by Akshat Parikh
***
## What is this web application?
OpenVDP is a full stack web application that provides organizations with an easy way to recieve security advice. It is a bug tracking/reporting application for organizations and security researchers. This software was created due to a common problem I witnessed in the field during research. Many organizations did not have a platform where security researchers could report their findings to them, effectively rendering their issues unsolved and research useless. Hence, I created this application to provide easy access to create VDP or bug bounty programs for any organization.
## Setup
This program was tested on Ubuntu 20.04 with MysqlVer 8.0.26 and PHP 7.4.3. 
Here is the initial setup.
```bash
sudo apt-get update;
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql;
```
Clone this repository.
Connect to your mysql server and run the setup.sql file packaged in the repository.
In the index.php, login.php, register.php, reports.php, and settings.php files, you will see the following block of code. 
```
$servername = "ENTER_YOUR_DB_SERVER_NAME";
$username = "ENTER_YOUR_DB_USERNAME";
$password = "ENTER_YOUR_DB_PASSWORD";
$database = "ENTER_YOUR_DB_NAME";
```
Replace the strings in the quotes with your respective information.
I will eventually develop a bash script to install everything and setup the database server completely. 

## Screenshots
### Mainpage
![index](https://user-images.githubusercontent.com/68412398/139379893-07c491e8-8e9a-4afe-8cd0-87de6119f777.PNG)
### Settings
![settings](https://user-images.githubusercontent.com/68412398/139379943-0c4a6b12-b57a-497c-b747-6e72155fe28f.png)
### Reports
![reports php](https://user-images.githubusercontent.com/68412398/139379972-afe18f92-f480-4fa8-8551-fc4689e992fc.PNG)
## Planned Features (in order of progress)
1. Automatic Installation Script
2. Fix some visual rendering bugs.
3. Add email verification with mail services.
## Contribution/Bugs
If you find any bugs with this program, please create an issue. I will try to come up with a fix. Also, if you have any ideas on any new features or how to implement performance upgrades or the current planned features, please create a pull request or an issue with the tag (contribution).
## References/Dependencies
1. https://github.com/erusev/parsedown
