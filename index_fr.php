<!DOCTYPE html>
<html>

	<head>
		<title>Carte OL Fait</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">

		<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
		<script src="https://openlayers.org/en/v4.6.5/build/ol.js"></script>
		<script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
		<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
		<script type="text/javascript" src="../CONFIG/conf.js"></script>

	</head>

	<div id="aide">
		<button id='closeAide'>X</button>
		<img class='arrow' id="arrow1" src="IMG/arrow3.png">
		<img class='arrow' id="arrow2" src="IMG/arrow4.png">
		<img class='arrow' id="arrow3" src="IMG/arrow4.png">
		<img class='arrow' id="arrow4" src="IMG/arrow.png">
		<img class='arrow' id="arrow5" src="IMG/arrow2.png">
		<p id='ap1' class='aidePolice'>Slectionnez la ou les couches. Pour<br> deslectionner l'ensemble des couches <br> cliquez sur le bouton ou changer de carte.</p>
		<p id='ap2' class='aidePolice'>Slectionnez la zone ou les zones<br> sur laquelle vous voulez discuter</p>
		<p id='ap3' class='aidePolice'>Choisissez les thême sur lequelle votre avis portera. <br>Si Aucun thème ne vous convient, choisissez libre</p>
		<p id='ap4' class='aidePolice'>Accedez à la discussion en cliquant sur le bouton. Si la page n'existe pas encore, recliquez!</p>
		<p id='ap5' class='aidePolice'>Voir les données. Pour cliquer sur <br>plusieurs zones, Maintenez SHIFT</p>
	</div>
	
	<body>
		<?php include '../CONFIG/conf.php';?>

		<header>
			<div id=logo>
			<img class="logo" src="IMG/logo.png"><img class="logo" src="IMG/irstea.png">
			</div>
			<button id="returnPage"><h1> WIKISEMIO </h1></button>
			<h2> <u>Projet:</u>&nbsp<?php echo $nameProject ?></h2>
			<button id="btnLanguage"><img src="IMG/language.png" alt="Changer de language"></button>
			<form id='language'>
			<div>
			<input type="radio" id="fr"
			name="language" value="fr" checked="checked">
			<label class='labelLanguage' for="fr">fr</label>
			<input type="radio" id="en"
			name="language" value="en">
			<label class='labelLanguage' for="en">en</label>
			</div>
			</form>
			&nbsp
			<button id="btnReload"><img src="IMG/reload.png" alt="Recharger la page"></button>
			<button id="btnAide"><img src="IMG/aide.png" alt="Voir l'aide"></button>

		</header>

		<!-- <button id="revenir">Centrer sur la zone ARA</button> -->

		<div id="main">
			<img id='northArrow' src="IMG/northArrow.png">
			<div id="search">
			  <input type="text" name="addr" value="" placeholder="Entrez un lieu" id="addr" size="20" />
			  <button type="button" onclick="addr_search();">Localiser</button><button id='recentrer'>Recentrer</button>
			  <div id="results"/></div>
			</div>
			<div id="chargement"></div>
			
			<div id="map"></div>

			<div id="controle">
				<div id="controle1">
					
					<!-- COUCHES -->
					<div class='elementform'>
						<strong><p>1: Selectionnez la/les couche(s): </p></strong>
						<div id=typeReq>Optionnel*</div>

						<form id='cartes'>
							<input type="radio" id="carte1" name="carte" value="carte1">
							<strong><label for="carte1">Carte 1</label></strong>
							<div id='chk_carte1'></div><br>

							<input type="radio" id="carte2" name="carte" value="carte2">
							<strong><label for="carte2">Carte 2</label></strong>
							<div id='chk_carte2'></div>
						</form>
						<U>Couches:</U>&nbsp<button id='supCouches'>Supprimer toutes les couches</button>
						<strong><div class='query' id="couches"></div></strong>
					</div>

					<!-- ZONE -->
					<?php include('lecture.php') ;?> 
					<div class="elementform">
						<strong><p>2: Selectionnez la/les zone(s): </p></strong>
						<div id=typeReq>Optionnel*</div>

						<form>
							<?php 
							if (trim($les_noms[0]) != "")
							{
								for($i = 0; $i < count($les_noms); $i++)
								{
							 ?>
								    <input type="radio" id=<?php echo $ma_liste[$i]; ?> name="les_zones" onclick="myFunction()"> <?php echo $les_noms[$i].'<br>'; }}?>
						</form>
						
						<div>
							<U>Zones:</U>&nbsp<button id='supZones'>Supprimer les zones</button>
							<strong><div class='query' id="zones"></div></strong>
						</div>
					</div>

					<!-- SUJET -->
					<div class="elementform">
						<strong><p>3: Choisissez le thème de la discussion: </p></strong>
						<div id=typeReq>Obligatoire*</div>
						<select id="listethemes">
						<option value="" disabled selected>Thèmes disponibles</option>
						</select><br>
						<U>Discussion:</U><strong><div class='query' id="theme"></div></strong>
					</div>
				</div>


				<div id="controle2">
					<!-- Discussions -->
					<div id='divboutonwiki'>
						<button id='boutonwiki'><p>Voir la page WIKI</p></button>
					</div>
				</div>
			</div>
		</div>


		<div id='legende'></div>
		<script type="text/javascript" src="script/reload.js"></script>
		<script type="text/javascript" src="script/aide.js"></script>
		<script type="text/javascript" src="script/btnLanguage.js"></script>
		<script type="text/javascript" src="script/changelanguage.js"></script>
		<?php include('map.php') ;?> 
		<script type="text/javascript" src="script/chargement_couches.js"></script>
		<script type="text/javascript" src="script/controle_themes.js"></script>
		<script type="text/javascript" src="script/controle_wiki.js"></script>
		<script type="text/javascript" src="script/controle_couches.js"></script>

	</body>
</html>
