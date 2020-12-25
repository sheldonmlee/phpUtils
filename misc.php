<?php
// Function to strip $get arguments from url.
function stripArgs($str)
{
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] = '$') {
            return substr($str, 0, i+1);
        }
    }
}
?>
