<?php
header("Content-Type: application/json");

$contacts = [
    [
        "id" => 1,
        "name" => "Abe Bogisich",
        "client_name" => "Abe Bogisich",
        "job_title" => "Deburring Machine Operator",
        "email" => "abe.bogisich@demo.com",
        "phone" => "+1.534.905.5732",
        "skype" => "-"
    ],
    [
        "id" => 2,
        "name" => "Adrain Ondricka",
        "client_name" => "Adrain Ondricka",
        "job_title" => "Bill and Account Collector",
        "email" => "adrain.ondricka@demo.com",
        "phone" => "+1-510-925-0980",
        "skype" => "-"
    ],
    [
        "id" => 3,
        "name" => "Alta Cassin",
        "client_name" => "Alta Cassin",
        "job_title" => "Claims Adjuster",
        "email" => "alta.cassin@demo.com",
        "phone" => "(386) 854-3326",
        "skype" => "-"
    ]
    
];

echo json_encode($contacts);
?>
