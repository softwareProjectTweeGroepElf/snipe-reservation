
# Manual reservation package Snipe-It 
&nbsp;
## Installation

1. Install the package via composer (`composer require sp2gr11/reservation:dev-master`) (cmd)
2. Go in the config folder to the file app.php and add `sp2gr11\reservation\providers\ReservationServiceProvider::class,` to the section vendor service providers
3. Run the vendor publish command (`php artisan vendor:publish --provider=sp2gr11\reservation\providers\ReservationServiceProvider`) (cmd)
4. Run the command (`php artisan migrate`) - this will create the tables necessary to use Reservation (cmd)

&nbsp;
## Students page 
 
On this page students can make a request for a reservation. The student gets a list with all the available assets with the information necessary for reservation. A reservation is not fixed and the professor has to accept it before it is final. When making a reservation you will need to enter your information and reasons on why you need the asset. This includes: 
-	Name 
-	Course 
-	What you are planning to do with the asset 
-	Duration of the lending period 

When the request is completed the professor will receive a notification and he then needs to accept or decline the request. When the request is approved you will see it in a list above the list with all the available assets. In the event that the request is denied you should contact the professor and ask for a reason and resend a request with better arguments on why you need the asset. 

![GitHub Logo](https://s28.postimg.org/s9kqgjskt/stud1.png)
![GitHub Logo](https://s28.postimg.org/8g8mnuf71/stud2.png)


 &nbsp;
## Professor page 
 
This page is meant for the professors and not accessible by students. The professors will see new request from students that have not been approved or denied. You can see all the information that the student has entered. Based on this the professors can decide to accept or deny to request. Once the asset is accepted it will be saved and the student is expected to come pick it up the asset on the specified date. 
&nbsp;

![GitHub Logo](https://s28.postimg.org/x5od88sq5/prof.png)
&nbsp;
## Lending page  
 
This page is used to check in or check out assets. The systems works with a barcode scanner and is mostly automatic. You will need to scan the asset and enter the students name. The system will then check if the asset is already assigned to a student. If this is the case and the asset is brought back on time it will be made accessible to lend again. If the asset is not brought back on time a fine will be added calculated based on the number of days it was brought back late. The amount that has to be paid can be changed in the configuration page. When the asset was not already assigned to a student it will be assigned to the student with the default lending period. It is of course possible to bring it  back sooner.  
&nbsp;
![GitHub Logo](https://s28.postimg.org/o83naw0a5/lending.png)
![GitHub Logo](https://s28.postimg.org/k08v24yul/lending2.png)

## Configuration page 
 
This page is only accessible by admins. They will be able to certain settings that are used on the lending page. This includes 
-	The maximum lending period. 
-	The default lending period.  
-	The different roles. 
