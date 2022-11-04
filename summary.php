<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Team</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles:wght@700&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">
</head>
<body>
<div class="title-container">
    <h1>Team</h1>
</div>
<div class="chalkboard-container">
    <div class="summary-container">
        <h1 class="u">Team Members and Responsibilities:</h1>
        <p><span class="name">Brendan Krafty:</span> Game Development and Designs</p>
        <p><span class="name">Justin Heyer:</span> User Interface, Leaderboard, Login, and Registration</p>
        <p><span class="name">Mohammad Tuffaha:</span> Project Organization and Summary</p>
    </div>
</div>

<?php
    include_once('footer.php');
?>
</body>