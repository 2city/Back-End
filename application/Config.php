<?php

/**
 * Database config variables
 * Change this according to your server settings
 */

class Constants
{
	// Definitely your Database Host name
	const DB_HOST = "localhost";

	// change the user access, CPanel have user roles, when writing and reading files
	// set it to allow the certain User to read/write
	const DB_USER = "db_user3";

	// change this according to your account credentials
	const DB_PASSWORD = "2C%eycp##TAx";

	// if you wish you create your own name for 
	// Database then change the word "db_storefinder"
	const DB_DATABASE = "db_storefnder3";

	// If deployed in a web server, change this according to your configuration
	// For Example. the domain name is www.someUrl.com, then if the php files are stored in
	// a folder named as "responsive" then the complete url would be
	// www.someUrl.com/responsive/
	const ROOT_URL = "http://2city.merkabahnk.net/";

	// DO NOT CHANGE THIS
	// FOLDER DIRECTORY FOR IMAGES UPLOADED FROM
	// THE DESKTOP
	const IMAGE_UPLOAD_DIR = "upload_pic";


	// FOLDER DIRECTORY FOR JSON DATA PHP FILE
	// DONT CHANGE THIS
	const JSON_FILE = "rest/data.php";

	const NO_OF_ITEMS_PER_PAGE = 10;

}

?>