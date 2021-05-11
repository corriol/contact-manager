<?php

return [
    "database" =>
        [   "connection" => "mysql:host=mysql-server;dbname=contact-manager;charset=utf8",
            "username" => "contacts-user_db",
            "password" => "user",
            "options" => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => true]
        ]
];
