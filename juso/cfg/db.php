<?php
/*
 +-------------------------------------------------------------------------+
| Copyright (C) 2022 ye5ni                             |
+-------------------------------------------------------------------------+
프로젝트  : 2022 건물 DB 프로젝트
작  성  자: 김예원
프로그램명: 도로명 주소 검색 페이지
모  듈  명: roadCode.php
작  성  일: 2022.05.11
최종수정일:
최종수정자:
수정이력:
+-------------------------------------------------------------------------+
| ye5ni@mk.co.kr                                                            |
+-------------------------------------------------------------------------+
*/

$dbServer = "green.mk.co.kr";
$dbUser = "juso";
$dbPassword = "jo!324";
$dbSid = "green";
//putenv("NLS_LANG=KOREAN_KOREA.KO16MSWIN949");
putenv("NLS_LANG=KOREAN_KOREA.UTF8");
putenv("NLS_LANG=KOREAN_KOREA.AL32UTF8");


$conn = oci_connect ( $dbUser, $dbPassword, "$dbServer/$dbSid" );
if (!$conn) {
	$e = oci_error ();
	trigger_error ( htmlentities ( $e ['message'], ENT_QUOTES ), E_USER_ERROR );
}

function getConnection() {
	global $dbServer, $dbUser, $dbPassword, $dbSid;

	$conn = oci_connect ( $dbUser, $dbPassword, "$dbServer/$dbSid" );
	if (! $conn) {
		$e = oci_error ();
		trigger_error ( htmlentities ( $e ['message'], ENT_QUOTES ), E_USER_ERROR );
	}

	return $conn;
}

function runParse($query){
	global $conn;

	$stid = oci_parse($conn, $query);
	if (!$stid) {
		$e = oci_error($conn);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	return $stid;
}

function oparse($query){
	global $conn;

	$stid = oci_parse($conn, $query);
	if (!$stid) {
		$e = oci_error($conn);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	return $stid;
}

function checkConnection() {
	global $conn;

	if ($conn) {
		return true;
	} else {
		return false;
	}
}

function closeConnection(){
	global $conn;
	oci_close($conn);
}

?>
