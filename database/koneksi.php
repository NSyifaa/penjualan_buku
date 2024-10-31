<?php
date_default_timezone_set('Asia/Jakarta');
$koneksi = mysqli_connect('localhost','root','','tokobuku');

if(!$koneksi){
	"koneksi ke database bermasalah";
}
?>