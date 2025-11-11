<?php
$clients = [
  [
    "id" => 1,
    "name" => "Acme Corporation",
    "tagline" => "Key enterprise client",
    "organization" => "Acme Corp",
    "type" => "Business",
    "industry" => "Software",
    "contactName" => "Jane Smith",
    "phone" => "+1 555 123 4567",
    "email" => "jane.smith@acme.com",
    "address" => "123 Market St, Springfield",
    "joinedDate" => "2023-04-10",
    "status" => "Active",
    "website" => "https://acme.example.com",
    "notes" => "Important long-term client. Prefers monthly billing.",
    "projects" => 6,
    "subscriptions" => 2,
    "orders" => 14,
    "invoices" => [
      "overdue" => 1,
      "notPaid" => 2,
      "partiallyPaid" => 1,
      "fullyPaid" => 9,
      "draft" => 0,
      "totalInvoiced" => 45200,
      "payments" => 38000,
      "due" => 7200,
      "recent" => [
        [
          "number" => "2024-101",
          "title" => "Monthly Retainer",
          "date" => "2025-10-01",
          "amount" => 4000,
          "status" => "Paid"
        ],
        [
          "number" => "2025-110",
          "title" => "Onboarding Fee",
          "date" => "2025-09-15",
          "amount" => 1200,
          "status" => "Overdue"
        ],
        [
          "number" => "2025-111",
          "title" => "Integration Work",
          "date" => "2025-09-01",
          "amount" => 2000,
          "status" => "Partial"
        ]
      ]
    ],
    "tickets" => [
      ["title" => "Login issue", "status" => "Open", "date" => "2025-10-20"],
      ["title" => "Feature request", "status" => "Closed", "date" => "2025-09-05"]
    ],
    "tasks" => [
      ["title" => "Send monthly report", "dueDate" => "2025-11-10", "done" => false],
      ["title" => "Invoice follow-up", "dueDate" => "2025-11-05", "done" => true]
    ],
    "reminders" => [
      ["title" => "Contract renewal", "date" => "2025-12-01", "time" => "10:00"],
      ["title" => "Quarterly review", "date" => "2026-01-10", "time" => "15:00"]
    ],
    "events" => [
      ["date" => "2025-11-11", "title" => "Kickoff Meeting", "time" => "10:00", "location" => "Zoom", "status" => "Confirmed"],
      ["date" => "2025-11-15", "title" => "Release v2.0", "time" => "09:00", "location" => "Office", "status" => "Planned"],
      ["date" => "2025-12-01", "title" => "Contract Renewal", "time" => "10:00", "location" => "Office", "status" => "Planned"]
    ]
  ],

  [
    "id" => 5,
    "name" => "Beta Ltd.",
    "organization" => "Beta Ltd",
    "contactName" => "Ravi Kumar",
    "phone" => "+91 98765 43210",
    "email" => "ravi@beta.in",
    "address" => "Mumbai, India",
    "joinedDate" => "2024-02-20",
    "status" => "Active",
    "website" => "https://beta.example.com",
    "notes" => "Regional client.",
    "projects" => 2,
    "subscriptions" => 1,
    "orders" => 5,
    "invoices" => [
      "overdue" => 0,
      "notPaid" => 1,
      "partiallyPaid" => 0,
      "fullyPaid" => 4,
      "draft" => 0,
      "totalInvoiced" => 8200,
      "payments" => 7200,
      "due" => 1000,
      "recent" => [
        [
          "number" => "B-01",
          "title" => "Consulting",
          "date" => "2025-08-10",
          "amount" => 2000,
          "status" => "Paid"
        ]
      ]
    ],
    "tickets" => [],
    "tasks" => [],
    "reminders" => [],
    "events" => []
  ]
];

// Example usage:
echo "<pre>";
print_r($clients);
echo "</pre>";
?>
