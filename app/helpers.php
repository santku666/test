<?php
if (!function_exists('sanatize')) {
    function sanatize($data)
    {
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        $data=filter_var($data,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data=preg_replace('/[^A-Za-z0-9\-]/', '', $data);
        return $data;
    }
}