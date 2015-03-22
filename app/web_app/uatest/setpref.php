<?php
include_once('../includes/config.inc.php');
include_once('../includes/functions.inc.php');

$pref = (isset($_POST['SITEPREF']) ? $_POST['SITEPREF'] : $_GET['SITEPREF']);
switch ($pref) {
    case 'MOBILE':
        setcookiealive('SITEPREF','MOBILE',time()+3600);
        header("Location: ../$MOBILEURL");
        break;
    case 'IPHONE':
        setcookiealive('SITEPREF','IPHONE',time()+3600);
        header("Location: ../$IPHONEURL");
        break;
    case 'IPAD':
        setcookiealive('SITEPREF','IPAD',time()+3600);
        header("Location: ../$IPADURL");
        break;
    case 'NORMAL':
        setcookiealive('SITEPREF','NORMAL',time()+3600);
        header("Location: ../$NORMALURL");
        break;
    default:
        setcookiealive('SITEPREF','NORMAL',time()+3600);
        header("Location: ../$NORMALURL");
}
?>