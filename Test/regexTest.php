<?php
//regex for Bearer Token Auth
// var_dump(preg_match('/Bearer\s(\S+)/', "Bearer dsf3532fw4f", $matches));

//regex for email validation
var_dump(preg_match('/([A-Za-z0-9]+)@([a-zA-Z0-9]+)\.([a-zA-Z0-9]+)/', "admin@gmail.com", $matches));
print_r($matches);
