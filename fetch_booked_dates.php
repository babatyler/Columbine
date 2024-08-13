<?php
// fetch_booked_dates.php

// Connect to the database
$pdo = new PDO('mysql:host=localhost;dbname=guesthouse', 'username', 'password');

// Query to fetch unavailable dates
$query = "SELECT check_in_date, check_out_date FROM bookings WHERE status = 'booked'";
$stmt = $pdo->prepare($query);
$stmt->execute();

$events = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $period = new DatePeriod(
        new DateTime($row['check_in_date']),
        new DateInterval('P1D'),
        new DateTime($row['check_out_date'])
    );
    
    foreach ($period as $date) {
        $events[] = ['title' => 'Booked', 'start' => $date->format('Y-m-d')];
    }
}

header('Content-Type: application/json');
echo json_encode($events);
?>
