<?php 
// Include classes 
include_once('tbs' . DIRECTORY_SEPARATOR. 'tbs_class.php'); // Load the TinyButStrong template engine 
include_once('tbs' . DIRECTORY_SEPARATOR. 'plugins' . DIRECTORY_SEPARATOR. 'tbs_plugin_opentbs.php'); // Load the OpenTBS plugin 

// prevent from a PHP configuration problem when using mktime() and date() 
if (version_compare(PHP_VERSION,'5.1.0')>=0) { 
    if (ini_get('date.timezone')=='') { 
        date_default_timezone_set('UTC'); 
    } 
} 

// Initialize the TBS instance 
$TBS = new clsTinyButStrong; // new instance of TBS 
$TBS->SetOption('noerr', true); // delete all pathes from the TBS include_path
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin 

// ------------------------------ 
// Prepare some data for the demo 
// ------------------------------ 

// Retrieve the user name to display 
$TBS->VarRef['nama'] = $_GET['nama'];
$TBS->VarRef['nis'] = $_GET['nis'];



// ----------------- 
// Load the template 
// ----------------- 

$template = 'template_kartu_perpus.docx'; 
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document). 

$TBS->PlugIn(OPENTBS_CHANGE_PICTURE, '#barcode#', 'barcode' . DIRECTORY_SEPARATOR. 'santri' . DIRECTORY_SEPARATOR. 'barcode_santri_' . $_GET['nis'] . '.png');

// Delete comments 
$TBS->PlugIn(OPENTBS_DELETE_COMMENTS); 
    // Output the result as a file on the server. 
$TBS->Show(OPENTBS_DOWNLOAD, 'kartu_santri_' . $_GET['nis'] . '.docx'); // Also merges all [onshow] automatic fields. 
    // The script can continue. 
exit(); 
// ----------------- 
// Output the result 
// ----------------- 