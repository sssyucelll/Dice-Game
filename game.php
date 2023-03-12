<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <?php
        session_start();
        class Gamer {
			public $name;
			public $point;
            public $status = 'active';
		
			public function __construct($name, $point){
		
				$this->name=$name;
				$this->point=$point;
			}
		}
        if(isset($_SESSION['winner'])) {
            $win = $_SESSION['winner'];
        }
        else {
            $win = '';
        }
?>
</head>
<body>
    <div id="container">
        <div id="gamers">
            <?php 
                foreach($_SESSION['gamers'] as &$gamer){
                    $strGamer = json_encode($gamer);
                    echo "
                        <div>
                            <h3>Oyuncu: $gamer->name</h3>
                            <form method='post'>
                                <input name='$strGamer' hidden/>
                                <input id='zar' type='submit' class='button' name='zar' value='Zar at' />
                                <input id='pas' type='submit' class='button' name='pas' value='Pas' />
                            </form>
                            <h3>Puan: $gamer->point</h3>
                        </div>
                    ";
                }
            ?>
        </div>
        <div>
            <form method='post'>
                <input type='submit' class='button' name='destroy' value='Bitir' />
            </form>
            <h3>
                <?php echo "Kazanan: $win" ?>
            </h3>
        </div>
    </div>
</body>
<?php
    foreach($_SESSION['gamers'] as &$gamer) {
        if (isset($_POST[json_encode($gamer)])) {
            if(isset($_POST['zar'])) {
                zar($gamer);
            }
            else {
                pas($gamer);
            }
        }
    }
    if(isset($_POST['destroy'])) {
        session_destroy();
        header("Location: /index.php");
    }

    function zar($gamer) {
        if($gamer->status == 'active') {
            $index = array_search($gamer, $_SESSION['gamers']);
            $_SESSION['gamers'][$index]->point += rand(1,100);
            if($_SESSION['gamers'][$index]->point == 11) {
                $gamer->status = 'winner';
            }
            if($_SESSION['gamers'][$index]->point > 11) {
                $gamer->status = 'big';
            }
            endGame();
            header("Refresh:0");
        }
    }

    function pas($gamer) {
        $gamer->status = 'inactive';
        endGame();
        header("Refresh:0");
    }

    function endGame() {
        $biggerPoint = 0;
        $isEnd = 0;
        foreach($_SESSION['gamers'] as &$gamer) {
            if($gamer->point == 11) {
                $_SESSION['winner'] = $gamer->name;
            }
            else if($gamer->point > 11) {
                $gamer->status = 'big';
            }
            else {
                if($gamer->point > $biggerPoint && ($gamer->status == 'active' || $gamer->status == 'inactive')) {
                    $biggerPoint = $gamer->point;
                    $_SESSION['winner'] = $gamer->name;
                }
            }
        }
    }
?>
</html>
