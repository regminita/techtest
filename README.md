# techtest
An adapter service accept user data in csv format and prepares them for import service. 

# Getting Started
## Framework Used
Codeigniter (version 3.x)
## Prerequisites 
- PHP version 5.6 or newer
- Apache server running

## Installation
 - Clone or download the project from repository
 - Copy the project to the folder (as per your apache server configuation) or to wamp\www if you are using wamp server
 
## Test 
 - You can test the api using Postman with POST request
 url: http://localhost/{projectname}/index.php/csvdataprocessor/processcsvdata
 - Sample CSV file is located at the root of the project which will be proccessed by API
 - You can also pass the csv file via POST request in Postman (KEY = 'filepath') <br/>
 			eg: key: filepath, value:  C:\\yourdirectory\\sample_user.csv
 - The API should output JSON object representing total success and error records and the location of generated success and error files
 
 # Note
 - The Api call will generate two files in the root folder <br />
   sample_users_successful.json - for success record <br />
   sample_users_failure.json - for failed records
 - You can make changes in the config file located in application/config/csv_config.php to modify the file location and other variables
 
 
 # Future Implementation
 - Read mandatory fields from config file and replace the harcoded Mandatory field check
 - Extend the File_Generation library to support conversion to different file format
 - Create an ENUM class for supported platforms
 - Create a unit test
 
   
