<?php
// This file contains all the general helper functions for the admin side of vorreiter.
// For table specific functions refer to ../helpers_by_table


function gen_random_string($length = 10)
{
    if (!$length || $length < 0) {
        $length = 10;
    }
    return substr(str_shuffle(MD5(microtime())), 0, $length);
}


function echo_failure($msg)
{
    echo json_encode(array("success" => false, "msg" => $msg));
}
