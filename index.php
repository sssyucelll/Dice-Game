<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Zar Oyunu</title>
	<style>h1 {text-align: center;}
			p {text-align: center;}
			div {text-align: center;}

	</style>
	<?php
		session_start();
	?>
</head>
<body bgcolor="lightgray"><br><br><br>
	<center><h1>ZAR OYUNUNA HOŞGELDİNİZ</h1></center>
<div id="ana_div">
    
    <div align="center" class="div" id="div"><br>
    	
  <form method="post">
    	<font color="black" face="tahoma">1. İSİM :</font>	<input type="text" name="isim1" required><br><br>
    	<font color="black" face="tahoma">2. İSİM :</font>	<input type="text" name="isim2" required><br><br>
    	<font color="black" face="tahoma">3. İSİM :</font>	<input type="text" name="isim3" ><br><br>
    	<font color="black" face="tahoma">4. İSİM :</font>	<input type="text" name="isim4" ><br><br>
    	<font color="black" face="tahoma">5. İSİM :</font>	<input type="text" name="isim5" ><br><br>
    	<font color="black" face="tahoma">6. İSİM :</font>	<input type="text" name="isim6" ><br><br>
    	<input class="btn" type="submit">  
 </form>

    </div>


    <div class="div" id="div2">
    	<code>
    		<center><h1><u><font color="red">KURALLAR</font></u></h1><br></center>
    		1. İlk önce oyuna başlamadan önce isimlerinizi yazınız.<br> 
    		2. İlk isim solda ki zarı - ikinci isim ise sağda ki zarı temsil etmektedir.<br>
    		3. Başla butonuna bastıktan sonra oyun sayfasına yönlendirileceksiniz ve zar at butonuna basarak oyuna başlayacaksınız.<br>
    		4. En büyük sayı atan kazanır.<br>
    		5. Gelecek olan zar sayıları tamamen rastgeledir. Bol Şanslar İyi Oyunlar....<br>
    	</code>
    </div><br><br><br>

</div>
</body>
<?php
	$gamersInfo = array();

	if(isset($_POST['isim1']) && isset($_POST['isim2'])) {
		$isim1=$_POST['isim1'];
		$isim2=$_POST['isim2'];
		array_push($gamersInfo, array($_POST['isim1'], 0), array($_POST['isim2'], 0));
		if(isset($_POST['isim3']) && !empty($_POST['isim3'])) array_push($gamersInfo, array($_POST['isim3'], 0));;
		if(isset($_POST['isim4']) && !empty($_POST['isim4'])) array_push($gamersInfo, array($_POST['isim4'], 0));
		if(isset($_POST['isim5']) && !empty($_POST['isim5'])) array_push($gamersInfo, array($_POST['isim5'], 0));
		setcookie('gamers_info', json_encode($gamersInfo), time()+3600);

		class Gamer {
			public $name;
			public $point;
		
			public function __construct($name, $point){
		
				$this->name=$name;
				$this->point=$point;
			}
		}
			$gamers = array();
			$gamersInfo = json_decode($_COOKIE['gamers_info'], true);
	
			foreach ($gamersInfo as &$gamer) {
				array_push($gamers, new Gamer($gamer[0], $gamer[1]));
			}
			$_SESSION['gamers'] = $gamers;

		header("Location: game.php");
	}
?>
</html>
