<?php
return [
  "admin" => [
    "allow" => ["admin.*"],
    "deny" => []
  ],

  "sales" => [
    "allow" => ["admin.*"],
    "deny" => []
  ],

  "user" => [
    "allow" => [
      'admin.index',
      'admin.users.index'
    ],
    "deny" => ["admin.*"]
  ]
];
