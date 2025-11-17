<?php
// client.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // allow cross-origin requests for testing tools like Thunder Client

echo <<<'JSON'
[
  {
    "id":17,
    "title":"WordPress Plugin Development",
    "client":"-",
    "price":"-",
    "start_date":"15-09-2025",
    "deadline":"03-11-2025",
    "deadline_alert":true,
    "progress":45,
    "status":"Open"
  },
  {
    "id":19,
    "title":"Website Maintenance and Updates",
    "client":"Birdie Erdman",
    "price":"$3,500.00",
    "start_date":"03-10-2025",
    "deadline":"07-11-2025",
    "deadline_alert":true,
    "progress":35,
    "status":"Upcoming"
  },
  {
    "id":28,
    "title":"Virtual Reality Experience Design",
    "client":"-",
    "price":"-",
    "start_date":"07-11-2025",
    "deadline":"14-11-2025",
    "deadline_alert":false,
    "progress":55,
    "status":"Completed"
  },
  {
    "id":8,
    "title":"UI/UX Design for Web App",
    "client":"Howard Halvorson",
    "price":"-",
    "start_date":"05-10-2025",
    "deadline":"16-12-2025",
    "deadline_alert":false,
    "progress":60,
    "status":"Upcoming"
  },
  {
    "id":13,
    "title":"Social Media Influencer Collaboration",
    "client":"Alta Cassin",
    "price":"$2,500.00",
    "start_date":"16-11-2025",
    "deadline":"02-09-2023",
    "deadline_alert":true,
    "progress":5,
    "status":"Completed"
  },
  {
    "id":7,
    "title":"SEO Optimization Strategy",
    "client":"Abshire-Swaniawski",
    "price":"$4,000.00",
    "start_date":"14-09-2025",
    "deadline":"09-11-2025",
    "deadline_alert":true,
    "progress":40,
    "status":"Open"
  },
  {
    "id":12,
    "title":"Product Photography and Cataloging",
    "client":"Demo Client",
    "price":"$4,000.00",
    "start_date":"25-10-2025",
    "deadline":"13-12-2025",
    "deadline_alert":false,
    "progress":70,
    "status":"Open"
  },
  {
    "id":24,
    "title":"Product Packaging Design",
    "client":"Hettinger, Ziemann and Murphy",
    "price":"$2,500.00",
    "start_date":"24-09-2025",
    "deadline":"03-12-2025",
    "deadline_alert":false,
    "progress":50,
    "status":"Open"
  },
  {
    "id":23,
    "title":"Online Course Creation and Launch",
    "client":"Zoila Hauck",
    "price":"-",
    "start_date":"17-11-2025",
    "deadline":"29-11-2025",
    "deadline_alert":false,
    "progress":10,
    "status":"Open"
  },
  {
    "id":16,
    "title":"Motion Graphics and Explainer Videos",
    "client":"Abe Bogisich",
    "price":"-",
    "start_date":"29-10-2025",
    "deadline":"12-11-2025",
    "deadline_alert":true,
    "progress":30,
    "status":"Open"
  },
  {
    "id":20,
    "title":"E-commerce Platform Migration",
    "client":"Gordon Hickle",
    "price":"$6,000.00",
    "start_date":"01-10-2025",
    "deadline":"20-11-2025",
    "deadline_alert":false,
    "progress":65,
    "status":"Open"
  },
  {
    "id":21,
    "title":"Mobile App Beta Testing",
    "client":"Sandy Doyle",
    "price":"$1,200.00",
    "start_date":"05-11-2025",
    "deadline":"25-11-2025",
    "deadline_alert":false,
    "progress":15,
    "status":"Open"
  },
  {
    "id":22,
    "title":"Brand Strategy Workshop",
    "client":"Travis Kertzmann",
    "price":"$3,000.00",
    "start_date":"10-10-2025",
    "deadline":"02-12-2025",
    "deadline_alert":false,
    "progress":85,
    "status":"Completed"
  },
  {
    "id":25,
    "title":"Corporate Identity Refresh",
    "client":"Kessler LLC",
    "price":"$5,000.00",
    "start_date":"22-09-2025",
    "deadline":"14-12-2025",
    "deadline_alert":false,
    "progress":45,
    "status":"Upcoming"
  },
  {
    "id":26,
    "title":"Email Campaign Automation",
    "client":"Ruthanne Shanahan",
    "price":"$900.00",
    "start_date":"12-10-2025",
    "deadline":"05-11-2025",
    "deadline_alert":true,
    "progress":25,
    "status":"Open"
  },
  {
    "id":27,
    "title":"Analytics Dashboard Build",
    "client":"Demo Analytics",
    "price":"$7,500.00",
    "start_date":"30-09-2025",
    "deadline":"30-11-2025",
    "deadline_alert":false,
    "progress":50,
    "status":"Open"
  },
  {
    "id":29,
    "title":"Influencer Outreach Program",
    "client":"Loren Collier",
    "price":"$2,200.00",
    "start_date":"18-11-2025",
    "deadline":"02-12-2025",
    "deadline_alert":false,
    "progress":5,
    "status":"Open"
  },
  {
    "id":30,
    "title":"Landing Page Conversion Optimization",
    "client":"PixelWorks",
    "price":"$1,800.00",
    "start_date":"02-10-2025",
    "deadline":"10-11-2025",
    "deadline_alert":true,
    "progress":90,
    "status":"Open"
  },
  {
    "id":31,
    "title":"Content Migration & QA",
    "client":"Blue Ocean Co",
    "price":"$3,200.00",
    "start_date":"08-10-2025",
    "deadline":"28-11-2025",
    "deadline_alert":false,
    "progress":55,
    "status":"Open"
  },
  {
    "id":32,
    "title":"Video Editing & Subtitling",
    "client":"A. Media Group",
    "price":"$1,100.00",
    "start_date":"20-10-2025",
    "deadline":"08-11-2025",
    "deadline_alert":true,
    "progress":35,
    "status":"Open"
  },
  {
    "id":33,
    "title":"API Integration (Payments)",
    "client":"SecurePay",
    "price":"$4,500.00",
    "start_date":"11-09-2025",
    "deadline":"22-11-2025",
    "deadline_alert":false,
    "progress":60,
    "status":"Open"
  },
  {
    "id":34,
    "title":"Accessibility Audit",
    "client":"Inclusive Ltd",
    "price":"$750.00",
    "start_date":"14-10-2025",
    "deadline":"01-12-2025",
    "deadline_alert":false,
    "progress":95,
    "status":"Completed"
  },
  {
    "id":35,
    "title":"Quarterly Roadmap Planning",
    "client":"Executive Team",
    "price":"-",
    "start_date":"01-12-2025",
    "deadline":"15-12-2025",
    "deadline_alert":false,
    "progress":0,
    "status":"Upcoming"
  }
]
JSON;