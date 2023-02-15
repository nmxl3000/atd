<?php

// Built in debug...lets you see what's going on "in situ"
define("DEBUG",false); //  Should give information of what is processing
define("DEBUG_METHOD_CALLS",false); // Set to true to see trace of method calls...handy when something goes wrong
define("DEBUG_DATA",false); //Should show relevant data

// Config for local JSON files
define("USE_LOCAL_JSON_FILE_STORE",true); // Set this to true to pull content from local JSON files..these can be mined via cron every n minutes/hours
define("LOCAL_JSON_FILE_PATH",'mined_json_data');
define("LOCAL_JSON_ENGLAND_FILENAME",'en-all.json');
define("LOCAL_JSON_IRELAND_FILENAME",'ie-all.json');
define("LOCAL_JSON_GERMANY_FILENAME",'de-all.json');

// Limits the number of records returned from the API. 
define("LIMIT",100);

// URL endpoint config for each supported country
define("ENGLAND_URL",'https://global.atdtravel.com/api/products?geo=en' .'&limit=' .LIMIT);
define("IRELAND_URL",'https://global.atdtravel.com/api/products?geo=en-ie' .'&limit=' .LIMIT);
define("GERMANY_URL",'https://global.atdtravel.com/api/products?geo=de-de' .'&limit=' .LIMIT);

