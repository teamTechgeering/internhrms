<?php
header("Content-Type: application/json");

$data = [
    [
        "title" => "Website Design",
        "description" => "Custom website templates for your brand.",
        "category" => "Design",
        "unit" => "Hour",
        "rate" => "20",
        "image"=> "assets/images/web design.avif"
    ],
    [
        "title" => "SEO",
        "description" => "SEO for your websites",
        "category" => "Services",
        "unit" => "Hour",
        "rate" => "10",
        "image"=> "assets/images/seo.jpg"
    ],
    [
        "title" => "Logo Design",
        "description" => "Logo design for your brand.",
        "category" => "Design",
        "unit" => "PC",
        "rate" => "100",
        "image"=> "assets/images/logo.jpg"
    ],
    [
        "title" => "Domain .com",
        "description" => "Get a dot com domain only @ $11",
        "category" => "Services",
        "unit" => "PC",
        "rate" => "11",
        "image"=> "assets/images/domain.webp"
    ],
    [
        "title" => "Custom app development",
        "description" => "App for your business",
        "category" => "Development",
        "unit" => "PC",
        "rate" => "1000",
        "image"=> "assets/images/CAD.png"
    ],
    [
        "title" => "Content writing",
        "description" => "We write content for different types of websites, apps, etc.",
        "category" => "Services",
        "unit" => "Hour",
        "rate" => "15",
        "image"=> "assets/images/content.jpg"
    ],
    [
        "title" => "Art pictures",
        "description" => "Hand art pictures for your website.",
        "category" => "Design",
        "unit" => "PC",
        "rate" => "40",
        "image"=> "assets/images/art.jpg"
    ],
    [
        "title" => "10GB Hosting",
        "description" => "Cloud Hosting service 10GB Space<br>- Free support<br>- 24 hours up time<br>- Super fast",
        "category" => "Services",
        "unit" => "PC",
        "rate" => "100",
        "image"=> "assets/images/hosting.jpg"
    ]
];

echo json_encode($data);
