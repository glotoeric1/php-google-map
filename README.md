# Php oops and MYSQL dynamically showing custom images or markers on google map from database.

---------------------------------------------------------------------------------------------------------------------------------

Read Me
In this Readme document, I am going to explain the installation and usage of this Web App.
Languages and framework in used: Bootstrap, HTML, CSS, MYSQL, PHP, JavaScript and other libraries.
Installation process
MySQL database folder name <database> with the name <similie_db>, Please import this database (similie_db) into your database and modify the following variables in db.php, userClass.php and AnimalCalss.php.
//assigning database variable values;
Private $server_name="127.0.0.1";
Private $server_user="root";
Private $server_pass="your_database_password";
Private $server_db="your_database_name";
protected $connector;

Note: this modification must be done in AnimalClass.php, UserClass.php and db.php

After importing your database and modifying these files, you can copy and paste this link in url: “ http://127.0.0.1/similie-project/similie-interview-project/login.php ” if you are on Localhost.
Please make show your server is on and running if you are using localhost (127.0.0.1) 
Make sure to add the project in your root folder or root directory of your web host or Cpanel.
 
Logging in and creating a User account
Login details: Username: admin 
                        Password: admin
To create user Account click <New Account> on the login screen.
This app has three Main menu items <Home>, <Service> and <Add species> with two child menu <Create Account> and <Logout>


Create, Update, Delete and Select (CRUD)
To insert or edit data, all fields or columns are required and the latitude and longitude must be a numeric or decimal value.
After inserting or editing data, the images will show at the appropriate latitude and longitude and if the image(s) has been clicked on, the title(s) and description will popup.

Animals Table

User Table

Login Page

Home page

Note: Your suggestions or comments will be highly welcome for code improvement.
