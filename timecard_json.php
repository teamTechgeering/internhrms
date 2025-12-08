<?php
header('Content-Type: application/json');

/*
  UNIFIED MEMBER PROFILE DATA
  (Same structure as team_json.php so member_view.php loads full details)
*/
$members = [
    [
        "name" => "John Doe",
        "job"  => "Admin",
        "email" => "john@example.com",
        "phone" => "+12345678971",
        "avatar" => "https://i.pravatar.cc/140?img=5",
        "social" => [
            "facebook" => "https://facebook.com/johndoe",
            "twitter" => "",
            "youtube" => "",
            "linkedin" => ""
        ]
    ],
    [
        "name" => "Sara Ann",
        "job"  => "Web Designer",
        "email" => "sara@example.com",
        "phone" => "+12345678973",
        "avatar" => "https://i.pravatar.cc/140?img=2",
        "social" => [
            "facebook" => "https://facebook.com/sara",
            "twitter" => "",
            "youtube" => "",
            "linkedin" => ""
        ]
    ],
    [
        "name" => "Richard Gray",
        "job"  => "Web Developer",
        "email" => "richard@example.com",
        "phone" => "+12345678974",
        "avatar" => "https://i.pravatar.cc/140?img=3",
        "social" => [
            "facebook" => "",
            "twitter" => "",
            "youtube" => "",
            "linkedin" => ""
        ]
    ],
    [
        "name" => "Michael Wood",
        "job"  => "Project Manager",
        "email" => "michael@example.com",
        "phone" => "+12345678972",
        "avatar" => "https://i.pravatar.cc/140?img=4",
        "social" => [
            "facebook" => "",
            "twitter" => "",
            "youtube" => "",
            "linkedin" => ""
        ]
    ],
    [
        "name" => "Mark Thomas",
        "job"  => "Web Developer",
        "email" => "mark@example.com",
        "phone" => "+12345678975",
        "avatar" => "https://i.pravatar.cc/140?img=1",
        "social" => [
            "facebook" => "",
            "twitter" => "",
            "youtube" => "",
            "linkedin" => ""
        ]
    ]
];

/* TIME ENTRIES */
$entries = [
    ['id'=>'1','member_name'=>'Michael Wood','member_email'=>'michael@example.com','in_date'=>'06-12-2025','in_time'=>'06:45:12 pm','out_date'=>'06-12-2025','out_time'=>'','duration'=>'00:00:00','hours'=>0,'note'=>''],
    ['id'=>'2','member_name'=>'Sara Ann','member_email'=>'sara@example.com','in_date'=>'06-12-2025','in_time'=>'06:45:07 pm','out_date'=>'06-12-2025','out_time'=>'','duration'=>'00:00:00','hours'=>0,'note'=>''],
    ['id'=>'3','member_name'=>'Richard Gray','member_email'=>'richard@example.com','in_date'=>'06-12-2025','in_time'=>'11:45:00 am','out_date'=>'06-12-2025','out_time'=>'05:20:00 pm','duration'=>'05:35:00','hours'=>5.58,'note'=>''],
    ['id'=>'4','member_name'=>'Mark Thomas','member_email'=>'mark@example.com','in_date'=>'06-12-2025','in_time'=>'11:30:00 am','out_date'=>'06-12-2025','out_time'=>'02:45:00 pm','duration'=>'03:15:00','hours'=>3.25,'note'=>''],
    ['id'=>'5','member_name'=>'Michael Wood','member_email'=>'michael@example.com','in_date'=>'06-12-2025','in_time'=>'10:50:00 am','out_date'=>'06-12-2025','out_time'=>'05:15:00 pm','duration'=>'06:25:00','hours'=>6.42,'note'=>''],
    ['id'=>'6','member_name'=>'Sara Ann','member_email'=>'sara@example.com','in_date'=>'06-12-2025','in_time'=>'09:40:00 am','out_date'=>'06-12-2025','out_time'=>'05:35:00 pm','duration'=>'07:55:00','hours'=>7.92,'note'=>''],
    ['id'=>'7','member_name'=>'John Doe','member_email'=>'john@example.com','in_date'=>'06-12-2025','in_time'=>'09:25:00 am','out_date'=>'06-12-2025','out_time'=>'03:15:00 pm','duration'=>'05:50:00','hours'=>5.83,'note'=>'']
];

/* SUMMARY */
$summary = [
  ['name'=>'Sara Ann','email'=>'sara@example.com','duration'=>'06:45:00','hours'=>6.75],
  ['name'=>'Richard Gray','email'=>'richard@example.com','duration'=>'02:40:00','hours'=>2.67],
  ['name'=>'Michael Wood','email'=>'michael@example.com','duration'=>'07:30:00','hours'=>7.5],
  ['name'=>'Mark Thomas','email'=>'mark@example.com','duration'=>'07:40:00','hours'=>7.67],
  ['name'=>'John Doe','email'=>'john@example.com','duration'=>'10:10:00','hours'=>10.17]
];

/* SUMMARY DETAILS */
$summary_details = [
  ['name'=>'John Doe','email'=>'john@example.com','date'=>'02-12-2025','duration'=>'07:05:00','hours'=>7.08],
  ['name'=>'John Doe','email'=>'john@example.com','date'=>'03-12-2025','duration'=>'03:05:00','hours'=>3.08],
  ['name'=>'Mark Thomas','email'=>'mark@example.com','date'=>'02-12-2025','duration'=>'07:40:00','hours'=>7.67],
  ['name'=>'Michael Wood','email'=>'michael@example.com','date'=>'02-12-2025','duration'=>'07:30:00','hours'=>7.5],
  ['name'=>'Richard Gray','email'=>'richard@example.com','date'=>'02-12-2025','duration'=>'02:40:00','hours'=>2.67],
  ['name'=>'Sara Ann','email'=>'sara@example.com','date'=>'02-12-2025','duration'=>'06:45:00','hours'=>6.75]
];

/* MEMBERS CLOCKED IN */
$members_clocked_in = [
  ['name'=>'John Doe','email'=>'john@example.com','in_date'=>'06-12-2025','in_time'=>'09:25:00 am']
];

/* CLOCK IN/OUT STATUS */
$clock_in_out = [
  ['name'=>'John Doe','email'=>'john@example.com','status'=>'Not clocked in yet'],
  ['name'=>'Mark Thomas','email'=>'mark@example.com','status'=>'Not clocked in yet'],
  ['name'=>'Michael Wood','email'=>'michael@example.com','status'=>'Not clocked in yet'],
  ['name'=>'Richard Gray','email'=>'richard@example.com','status'=>'Not clocked in yet'],
  ['name'=>'Sara Ann','email'=>'sara@example.com','status'=>'Not clocked in yet']
];

echo json_encode([
  'members' => $members,      // <-- IMPORTANT for member_view.php
  'entries' => $entries,
  'summary' => $summary,
  'summary_details' => $summary_details,
  'members_clocked_in' => $members_clocked_in,
  'clock_in_out' => $clock_in_out
]);
