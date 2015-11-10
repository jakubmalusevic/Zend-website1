<?php
class Constants {
	    
	//SITE CONFIGURATION
	const MYSQL_DATE_FORMAT 	= "Y-m-d H:i:s";
	const MYSQL_DAY_FORMAT 		= "Y-m-d";		
	const MYSQL_HOUR_FORMAT		= "Y-m-d H";
	const MYSQL_MINUTE_FORMAT   = "Y-m-d H:i";
	
	//APPLICATION CONFIGURATION
	const DATE_FORMAT  				= "d-m-Y";
    const DATE_HOUR_MINUTE_FORMAT   = "d-m-Y h:i";

    // STMP Settings
    const SMTP_ACTIVATE     = '1';
    const SMTP_HOST         = 'smtp.gmail.com';
    const SMTP_PORT         = '587';
    const SMTP_AUTH         = 'login';
    const SMTP_USERNAME     = 'entropy359@gmail.com';
    const SMTP_PASSWORD     = 'chaos359';
    const SMTP_SSL          = 'tls';
    const SMTP_FROM_EMAIL   = 'ohalavi@greatnetsolutions.com';
    const SMTP_FROM_NAME    = 'Omid';
    
    // Site Administrator Email
    const ADMIN_EMAIL       = 'ohalavi@greatnetsolutions.com';
    
    // CREDENTIALS MAP
    const CR_DRIVER_LICENSE      = 1;
    const CR_RESUME              = 2;
    const CR_COSMETOLOGY_LICENSE = 3;
    
    // Vendor Status
    const VENDOR_STATUS_APPLY     = 0;
    const VENDOR_STATUS_APPROVED  = 1;

    static $VATS = array(6, 12, 21);
}
?>
