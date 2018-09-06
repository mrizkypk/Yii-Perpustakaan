<?php
$lanjutan = false;
if (isset($_GET['nama']) && isset($_GET['nis'])) {
	$_POST['nama'] = $_GET['nama'];
	$_POST['nis'] = $_GET['nis'];

	$_POST['buku_1'] = '';
	$_POST['buku_2'] = '';
	$_POST['buku_3'] = '';
	$_POST['buku_4'] = '';
	$_POST['buku_5'] = '';
	$_POST['buku_6'] = '';
	$_POST['buku_7'] = '';
	$_POST['buku_8'] = '';
	$_POST['buku_9'] = '';
	$_POST['buku_10'] = '';
	$_POST['buku_11'] = '';
	$_POST['buku_12'] = '';
	$_POST['buku_13'] = '';
	$_POST['buku_14'] = '';
	$_POST['buku_15'] = '';

	$_POST['pengarang_1'] = '';
	$_POST['pengarang_2'] = '';
	$_POST['pengarang_3'] = '';
	$_POST['pengarang_4'] = '';
	$_POST['pengarang_5'] = '';
	$_POST['pengarang_6'] = '';
	$_POST['pengarang_7'] = '';
	$_POST['pengarang_8'] = '';
	$_POST['pengarang_9'] = '';
	$_POST['pengarang_10'] = '';
	$_POST['pengarang_11'] = '';
	$_POST['pengarang_12'] = '';
	$_POST['pengarang_13'] = '';
	$_POST['pengarang_14'] = '';
	$_POST['pengarang_15'] = '';

	$_POST['tanggal_peminjaman_1'] = '';
	$_POST['tanggal_peminjaman_2'] = '';
	$_POST['tanggal_peminjaman_3'] = '';
	$_POST['tanggal_peminjaman_4'] = '';
	$_POST['tanggal_peminjaman_5'] = '';
	$_POST['tanggal_peminjaman_6'] = '';
	$_POST['tanggal_peminjaman_7'] = '';
	$_POST['tanggal_peminjaman_8'] = '';
	$_POST['tanggal_peminjaman_9'] = '';
	$_POST['tanggal_peminjaman_10'] = '';
	$_POST['tanggal_peminjaman_11'] = '';
	$_POST['tanggal_peminjaman_12'] = '';
	$_POST['tanggal_peminjaman_13'] = '';
	$_POST['tanggal_peminjaman_14'] = '';
	$_POST['tanggal_peminjaman_15'] = '';

	$_POST['tanggal_pengembalian_1'] = '';
	$_POST['tanggal_pengembalian_2'] = '';
	$_POST['tanggal_pengembalian_3'] = '';
	$_POST['tanggal_pengembalian_4'] = '';
	$_POST['tanggal_pengembalian_5'] = '';
	$_POST['tanggal_pengembalian_6'] = '';
	$_POST['tanggal_pengembalian_7'] = '';
	$_POST['tanggal_pengembalian_8'] = '';
	$_POST['tanggal_pengembalian_9'] = '';
	$_POST['tanggal_pengembalian_10'] = '';
	$_POST['tanggal_pengembalian_11'] = '';
	$_POST['tanggal_pengembalian_12'] = '';
	$_POST['tanggal_pengembalian_13'] = '';
	$_POST['tanggal_pengembalian_14'] = '';
	$_POST['tanggal_pengembalian_15'] = '';

	$_POST['denda_1'] = '';
	$_POST['denda_2'] = '';
	$_POST['denda_3'] = '';
	$_POST['denda_4'] = '';
	$_POST['denda_5'] = '';
	$_POST['denda_6'] = '';
	$_POST['denda_7'] = '';
	$_POST['denda_8'] = '';
	$_POST['denda_9'] = '';
	$_POST['denda_10'] = '';
	$_POST['denda_11'] = '';
	$_POST['denda_12'] = '';
	$_POST['denda_13'] = '';
	$_POST['denda_14'] = '';
	$_POST['denda_15'] = '';
} else {
	foreach ($_POST as $key => $value) {
		if ($key != 'nis' && $key != 'nama' && $value != '') {
			$lanjutan = true;
			break;
		}
	}
}

extract($_POST);
// Include classes 
include_once('tbs' . DIRECTORY_SEPARATOR. 'tbs_class.php'); // Load the TinyButStrong template engine 
include_once('tbs' . DIRECTORY_SEPARATOR. 'plugins' . DIRECTORY_SEPARATOR . 'tbs_plugin_opentbs.php'); // Load the OpenTBS plugin 

// prevent from a PHP configuration problem when using mktime() and date() 
if (version_compare(PHP_VERSION,'5.1.0')>=0) { 
    if (ini_get('date.timezone')=='') { 
        date_default_timezone_set('UTC'); 
    } 
}

function limitstring($str, $limit) {
	if (strlen($str) > $limit) {
		return $str = substr($str, 0, strrpos(substr($str, 0, $limit - 3), ' ')) . '...';
	} else {
		return $str;
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
$TBS->VarRef['nama'] = $nama;
$TBS->VarRef['nis'] = $nis;

$TBS->VarRef['judul_buku_1'] = limitstring($buku_1, 47);
$TBS->VarRef['judul_buku_2'] = limitstring($buku_2, 47);
$TBS->VarRef['judul_buku_3'] = limitstring($buku_3, 47);
$TBS->VarRef['judul_buku_4'] = limitstring($buku_4, 47);
$TBS->VarRef['judul_buku_5'] = limitstring($buku_5, 47);
$TBS->VarRef['judul_buku_6'] = limitstring($buku_6, 47);
$TBS->VarRef['judul_buku_7'] = limitstring($buku_7, 47);
$TBS->VarRef['judul_buku_8'] = limitstring($buku_8, 47);
$TBS->VarRef['judul_buku_9'] = limitstring($buku_9, 47);
$TBS->VarRef['judul_buku_10'] = limitstring($buku_10, 47);
$TBS->VarRef['judul_buku_11'] = limitstring($buku_11, 47);
$TBS->VarRef['judul_buku_12'] = limitstring($buku_12, 47);
$TBS->VarRef['judul_buku_13'] = limitstring($buku_13, 47);
$TBS->VarRef['judul_buku_14'] = limitstring($buku_14, 47);
$TBS->VarRef['judul_buku_15'] = limitstring($buku_15, 47);

$TBS->VarRef['pengarang_1'] = limitstring($pengarang_1, 34);
$TBS->VarRef['pengarang_2'] = limitstring($pengarang_2, 34);
$TBS->VarRef['pengarang_3'] = limitstring($pengarang_3, 34);
$TBS->VarRef['pengarang_4'] = limitstring($pengarang_4, 34);
$TBS->VarRef['pengarang_5'] = limitstring($pengarang_5, 34);
$TBS->VarRef['pengarang_6'] = limitstring($pengarang_6, 34);
$TBS->VarRef['pengarang_7'] = limitstring($pengarang_7, 34);
$TBS->VarRef['pengarang_8'] = limitstring($pengarang_8, 34);
$TBS->VarRef['pengarang_9'] = limitstring($pengarang_9, 34);
$TBS->VarRef['pengarang_10'] = limitstring($pengarang_10, 34);
$TBS->VarRef['pengarang_11'] = limitstring($pengarang_11, 34);
$TBS->VarRef['pengarang_12'] = limitstring($pengarang_12, 34);
$TBS->VarRef['pengarang_13'] = limitstring($pengarang_13, 34);
$TBS->VarRef['pengarang_14'] = limitstring($pengarang_14, 34);
$TBS->VarRef['pengarang_15'] = limitstring($pengarang_15, 34);

$TBS->VarRef['p_1'] = $tanggal_peminjaman_1;
$TBS->VarRef['p_2'] = $tanggal_peminjaman_2;
$TBS->VarRef['p_3'] = $tanggal_peminjaman_3;
$TBS->VarRef['p_4'] = $tanggal_peminjaman_4;
$TBS->VarRef['p_5'] = $tanggal_peminjaman_5;
$TBS->VarRef['p_6'] = $tanggal_peminjaman_6;
$TBS->VarRef['p_7'] = $tanggal_peminjaman_7;
$TBS->VarRef['p_8'] = $tanggal_peminjaman_8;
$TBS->VarRef['p_9'] = $tanggal_peminjaman_9;
$TBS->VarRef['p_10'] = $tanggal_peminjaman_10;
$TBS->VarRef['p_11'] = $tanggal_peminjaman_11;
$TBS->VarRef['p_12'] = $tanggal_peminjaman_12;
$TBS->VarRef['p_13'] = $tanggal_peminjaman_13;
$TBS->VarRef['p_14'] = $tanggal_peminjaman_14;
$TBS->VarRef['p_15'] = $tanggal_peminjaman_15;

$TBS->VarRef['k_1'] = $tanggal_pengembalian_1;
$TBS->VarRef['k_2'] = $tanggal_pengembalian_2;
$TBS->VarRef['k_3'] = $tanggal_pengembalian_3;
$TBS->VarRef['k_4'] = $tanggal_pengembalian_4;
$TBS->VarRef['k_5'] = $tanggal_pengembalian_5;
$TBS->VarRef['k_6'] = $tanggal_pengembalian_6;
$TBS->VarRef['k_7'] = $tanggal_pengembalian_7;
$TBS->VarRef['k_8'] = $tanggal_pengembalian_8;
$TBS->VarRef['k_9'] = $tanggal_pengembalian_9;
$TBS->VarRef['k_10'] = $tanggal_pengembalian_10;
$TBS->VarRef['k_11'] = $tanggal_pengembalian_11;
$TBS->VarRef['k_12'] = $tanggal_pengembalian_12;
$TBS->VarRef['k_13'] = $tanggal_pengembalian_13;
$TBS->VarRef['k_14'] = $tanggal_pengembalian_14;
$TBS->VarRef['k_15'] = $tanggal_pengembalian_15;

$TBS->VarRef['d_1'] = $denda_1;
$TBS->VarRef['d_2'] = $denda_2;
$TBS->VarRef['d_3'] = $denda_3;
$TBS->VarRef['d_4'] = $denda_4;
$TBS->VarRef['d_5'] = $denda_5;
$TBS->VarRef['d_6'] = $denda_6;
$TBS->VarRef['d_7'] = $denda_7;
$TBS->VarRef['d_8'] = $denda_8;
$TBS->VarRef['d_9'] = $denda_9;
$TBS->VarRef['d_10'] = $denda_10;
$TBS->VarRef['d_11'] = $denda_11;
$TBS->VarRef['d_12'] = $denda_12;
$TBS->VarRef['d_13'] = $denda_13;
$TBS->VarRef['d_14'] = $denda_14;
$TBS->VarRef['d_15'] = $denda_15;
// ----------------- 
// Load the template 
// ----------------- 
if ($lanjutan) {
	$template = 'template_kartu_riwayat_perpus_lanjutan.docx'; 	
} else {
	$template = 'template_kartu_riwayat_perpus.docx'; 	
}
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document). 

// Delete comments 
$TBS->PlugIn(OPENTBS_DELETE_COMMENTS); 
    // Output the result as a file on the server. 
$TBS->Show(OPENTBS_DOWNLOAD, 'kartu_riwayat_santri_' . $nis . '.docx'); // Also merges all [onshow] automatic fields. 
    // The script can continue. 
exit(); 
// ----------------- 
// Output the result 
// ----------------- 