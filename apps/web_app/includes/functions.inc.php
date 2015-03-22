<?php
function setcookiealive($name,$value,$expires) {
    $_COOKIE[$name] = $value;
    setcookie($name,$value,$expires);
}
?>