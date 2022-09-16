# Login Page
This repo shows a working Login and Registration page that communicates with a MySQL database

# Requirements
- XAMPP, or similar, or a website host
- An active database

# How to set up
1. Download the files
2. Put them onto your web server
- I used XAMPP to test the functionality. To do the same, go to your XAMPP install directory and open the htdocs folder. Put the included folders and files in to that folder.
3. Create a new database in your DBMS (name it whatever). After, create a new table in the newly created database (name it whatever) and use these columns:
- user_id    | INT     | (max value) | Auto Increment | Primary Key
- email      | varchar | 100
- username   | varchar | 100
- password   | varchar | 255
4. Go into both of the config.php files and change the variables as needed to fit the naming of your database name, table name, and database login info.
