<?php
$conn = new mysqli(
    "localhost",
    "u736587194_tech_asia",
    "Techasia@1",
    "u736587194_Products"
);
if ($conn->connect_error) die($conn->connect_error);
