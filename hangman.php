<?php
session_start();
    if (!isset($_SESSION['user']))
    {
        header("location: log_in.php");
        exit();
    }

    if (isset($_GET['logout']))
    {
        unset($_SESSION['user']);
        header("location: log_in.php");
        exit();
    }
?>

<?php
/*______Initialize Variables______*/

$complete = false;
$newWord = "";
$blanks = "";
$guesses = [""];
$animFrames = ["blank", "head", "body", "leg1", "leg2", "arm1", "arm2", "dead"];
$words1 = ["HELLO", "BANANA", "SCHOOL", "FRIEND", "GROUP"];
$words2 = ["EYEBROW", "JOYSTICK", "HOSPITAL", "MULTIPLY", "PASSWORD"];
$words3 = ["HYPERTEXT", "UNIVERSITY", "DEVELOPMENT", "RESTAURANT", "ORIENTATION"];
$words4 = ["CONSTITUENCY", "REHABILITATION", "EXTRATERRESTRIAL", "INFRASTRUCTURE", "BIB"];
$keyboard = "QWERTYUIOPASDFGHJKLZXCVBNM";
$level = "Select";

/*_____________Logic______________*/

if(isset($_GET['pressed']))
{
    $key = $_GET['pressed'] ? : null;
    if(tryLetter($key) && !isDead() && !gameOver())
    {
        setLetter($key);
        if(isComplete())
        {
            $complete = true;
            setGameOver();
        }
    }
    else
    {
        if(!isDead()) 
        {
            setAnimFrame();
            if(isDead())
            {
                setGameOver();
            }
        }
        else
        {
            setGameOver();
        }
    }
}

if (isset($_GET['newGame']))
{
    newGame();
}

if (isset($_POST['level']))
{
    $level = $_POST['level'];
}


/*_____________Getters_______________*/


function getFrames()
{
    global $animFrames;
    return isset($_SESSION["frames"]) ? $_SESSION["frames"] : $animFrames;
}

function getAnimFrame($frame)
{
    return "img/" . $frame . ".png";
}

function getNextAnim()
{
    $i = 0;
    $anims = getFrames();
    return $anims[$i];
}

function getGuesses()
{
    return isset($_SESSION["guesses"]) ? $_SESSION["guesses"] : [];
}

function getWord()
{
    global $level, $words1, $words2, $words3, $words4;
    if(!isset($_SESSION["word"]))
    {
        if ($level == "Easy")
        {
            $word = array_rand($words1);
            $_SESSION["word"] = $words1[$word];
        }
        elseif ($level == "Medium")
        {
            $word = array_rand($words2);
            $_SESSION["word"] = $words2[$word];
        }
        elseif ($level == "Hard")
        {
            $word = array_rand($words3);
            $_SESSION["word"] = $words3[$word];
        }
        elseif ($level == "INSANE")
        {
            $word = array_rand($words4);
            $_SESSION["word"] = $words4[$word];
        }
        else
        {
            $word = array_rand($words1);
            $_SESSION["word"] = $words1[$word];
        }
    }
    return $_SESSION["word"];
}

function getHint($word)
{
    if ($word == "HELLO")
    {
        return "_____ WORLD";
    }
    elseif ($word == "BANANA")
    {
        return "Breakfast fruit favorite";
    }
    elseif ($word == "SCHOOL")
    {
        return "Vehicle for education";
    }
    elseif ($word == "FRIEND")
    {
        return "Someone you can turn to";
    }
    elseif ($word == "GROUP")
    {
        return "Collection of individuals";
    }
    elseif ($word == "EYEBROW")
    {
        return "Facial hair";
    }
    elseif ($word == "JOYSTICK")
    {
        return "Old school game tool";
    }
    elseif ($word == "HOSPITAL")
    {
        return "In case of emergency";
    }
    elseif ($word == "MULTIPLY")
    {
        return "Adds itself to itself";
    }
    elseif ($word == "PASSWORD")
    {
        return "Only you know it... hopefully";
    }
    elseif ($word == "DEVELOPMENT")
    {
        return "A career in Web";
    }
    elseif ($word == "UNIVERSITY")
    {
        return "Georgia State is one";
    }
    elseif ($word == "HYPERTEXT")
    {
        return "The 'H' in HTML";
    }
    elseif ($word == "RESTAURANT")
    {
        return "Wine-n-dine";
    }
    elseif ($word == "ORIENTATION")
    {
        return "A beginning";
    }
    elseif ($word == "CONSTITUENCY" || "REHABILITATION" || "EXTRATERRESTRIAL" || "INFRASTRUCTURE" || "BIB")
    {
        return "Sorry. No hints in INSANE mode";
    }
    else
    {
        return "";
    }
}

function tryLetter($letter)
{
    $word = getWord();
    $length = strlen($word) - 1;
    for($i = 0; $i <= $length; $i++)
    {
        if($letter == $word[$i])
        {
            return true;
        }
    }
    return false;
}

function isComplete()
{
    $word = getWord();
    $guess = getGuesses();
    $length = strlen($word) - 1;
    for($i = 0; $i <= $length; $i++)
    {
        if(!in_array($word[$i], $guess))
        {
            return false;
        }
    }
    return true;
}

function isDead()
{
    $frame = getFrames();
    if(count($frame) <= 1)
    {
        return true;
    }
    return false;
}

function gameOver()
{
    return isset($_SESSION['gameover']) ? $_SESSION['gameover'] : false;
}

/*_____________Setters_______________*/

function newGame()
{
    unset($_SESSION['frames']);
    unset($_SESSION['word']);
    unset($_SESSION['guesses']);
    $_SESSION['gameover'] = false;
}

function setAnimFrame()
{
    $frame = getFrames();
    array_shift($frame);
    $_SESSION['frames'] = $frame;
}

function setLetter($letter)
{
    $guess = getGuesses();
    $guess[] = $letter;
    $_SESSION['guesses'] = $guess;
}

function setGameOver()
{
    $_SESSION["gameover"] = true;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Hangman</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles:wght@700&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">
</head>
<body>

<div class="title-container">
    <h1>Hangman</h1>
</div>

<div class="chalkboard-container game">

    <div class="img-container">
        <img class="img" src="<?php echo getAnimFrame(getNextAnim());?>" alt="HangmanPic">
    </div>
    <div class="gameover-container">
        <?php
        function add_win() {
            // Decoding json
            $orig_json = file_get_contents('users_info.json');
            $data = json_decode($orig_json, true);
            foreach ($data as $key => $entry) {
                if ($entry['uid'] == $_SESSION['user']) {
                    $data[$key]['wins'] = $data[$key]['wins'] + 1;
                }
            }
        // Re-encode file and save it back
        $new_json = json_encode($data);
        file_put_contents('users_info.json', $new_json);
    }
    

        if(gameOver()) {
            if($complete)
            {
                add_win();
                echo '<p class="won">YOU WON</p>';
            } else {
                echo '<p class="lost">YOU LOSE</p>';
            }
        }
        ?>
    </div>

    <div class="word-container">
        <?php
        $newWord = getWord();
        $blanks = strlen($newWord) - 1;
        for ($i = 0; $i <= $blanks; $i++): $letter = getWord()[$i]; ?>
            <?php if(in_array($letter, getGuesses())): ?>
                <span class="letter"><?php echo $letter;?></span>
            <?php else: ?>
                <span class="letter">&nbsp;&nbsp;</span>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div class="level-select-container">
        <form method="post">
            <label for="levels" class="choose">Choose your difficulty level: </label>
            <select id="levels" class="ltr-btn" name="level" onchange="this.form.submit()">
                <option selected><?php echo $level?></option>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
                <option value="INSANE" class="insane">INSANE</option>
            </select>
        </form>
    </div>

    <div class="hint-container">
        <p class="hint-title">Hint:</p>
        <?php
        $hint = getHint(getWord());
        echo '<p class="hint">'. $hint . '</p>'
        ?>
    </div>

    <div class="instructions-container">
        <p>Hangman is a word guessing game with a grim theme.</p>
        <p>Choose a letter. If you've chosen correctly, it will be displayed underneath the gallows.
            Otherwise, one of Hangman's body parts will be added to the picture.</p>
        <p>Hangman has 6 body parts and 1 final breath. This means you are allowed 7
            incorrect guesses in total. Afterwards, the game will be over and must be restarted.</p>
    </div>

    <div class="hint-cover"><p class="hint-cover-text">Hover here for a hint...</p></div>

    <div class="keyboard-container">
        <form method="get">
            <?php
            $alphabet = 25;
            for ($i = 0; $i <= $alphabet; $i++)
            {
                echo '<button class="ltr-btn" type="submit" name="pressed"  value=' . $keyboard[$i] . '>' . $keyboard[$i] . '</button>';
                if ($i % 9 == 0 && $i > 0)
                {
                    echo '<br>';
                }
            }
            ?>
        </form>
        <form method="get">
            <button class="ltr-btn restart-btn" type="submit" name="newGame">New Game</button>
        </form>
    </div>

</div>

<?php
    include_once('footer.php');
?>
</body>
</html>