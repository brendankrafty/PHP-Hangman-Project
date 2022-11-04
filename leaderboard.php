<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles:wght@700&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">
</head>
<body>

<div class="title-container">
    <h1>Leaderboard</h1>
</div>

<div class="chalkboard-container">
    <table class="leaderboard-table">
        <tr class="leaderboard-header">
            <th>Rank</th>
            <th>Name</th>
            <th>Wins</th>
        </tr>
        <?php
        $json_data = file_get_contents('users_info.json');
        $data = json_decode($json_data, true);
        $table_size = min(10, count($data));

        // Finds max then updates table
        for($i = 0; $i < $table_size; $i++) {
            $max_index = 0;
            $max = $data[0]['wins'];

            // Finds current max
            for($j = 1; $j < count($data); $j++) {
                if ($data[$j]['wins'] > $max) {
                    $max_index = $j;
                    $max = $data[$j]['wins'];
                }
            }
            $uid = $data[$max_index]['uid'];
            $pos = $i + 1;
            echo "<tr>
                <td>{$pos}</td>
                <td>{$uid}</td>
                <td>{$max}</td>
            </tr>";
            // Gets rid of max locally so we won't find it again
            unset($data[$max_index]);
            $data = array_values($data);
        }
        ?>
    </table>
</div>

<?php
    include_once('footer.php');
?>
</body>