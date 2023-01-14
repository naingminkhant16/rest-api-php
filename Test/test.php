<?php
// echo base64_encode(" ");

// $arr = [
//     "name" => "nmk",
//     "age" => 21,
//     "job" => "Software Engineer"
// ];
// echo http_build_query($arr);

class Me
{
    public $name = 'nmk';
    public $age = 21;
    public $job = 'Software Enginner';
}
echo http_build_query(new Me);
