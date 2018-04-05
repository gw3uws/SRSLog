Program Name: SRS Log
Description: A simple amateur radio web based logging program
Author: Peter Barnes M0SWN
Date: 10/01/2018


Dev site: gw3uws.uk/srslog

Planned features:

-Initial Setup - MySQL tables + user accounts
-Multiple events - get rid of hardcoded events, add user wizard for creating a new event
-Callsign lookup to show country data
-Multi-page frontend, showing statistics, map etc.

Installation:

-Clone the github directory into a folder on a server running PHP >5 and MySQL
-Import my SQL tables into your server using PHPMyAdmin
-Edit srslog/users/connect.php to match your MySQL server login


