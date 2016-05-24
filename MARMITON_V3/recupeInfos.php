<?php

error_reporting(0);

/* IMPORT DE LA CLASSE ARRAY2XML */
require_once("classes/Array2XML.class.php");

/* Condition qui test la demande du client en récupérant les POST */
// Si on veut faire une recherche automatique
if(isset($_POST["demandeRecharge"]) && $_POST["demandeRecharge"] == "OK"){
	
	//appel des methodes aleatoire et enregistre xml
	enregistreXML(recetteAleatoire());
	
}else{
	
	//Si on veut faire une recherche par selection dans la liste des 20 recettes
	if(isset($_POST["selectRecette"]) && $_POST["selectRecette"] != "0"){
		
		//appel la methode qui recupe les information sur le site et enregistre en .xml
		enregistreXML(traiteSelectionUrl($_POST["selectRecette"]));
		
	}else{
		
		echo "Erreur";
		exit();
		
	}

}

//methode qui recupere les informations du site Marmitton.fr
/* @ prend en paramettre l'url du site */
function recupeInfo($url){
	
	//champs
	$tableRetourInfo = array();
	
	 $opts = array(
	 'http'=>array(
					'header' => "User-Agent:MyAgent/1.0\r\n"
					)
				);
				
		$context = stream_context_create($opts);
		$codeSource = file_get_contents($url,false,$context);
		/* CODE SOURCE NETTOYER DU HTML */
		$codeSource_N = str_replace(array("\r\n","\n"),'', $codeSource);
		
		preg_match('(<div class=\"m_bloc_cadre\".*<div id="recipePrevNext2"></div>)',$codeSource_N, $matches);
		
		$codeSourceBlocRecette = $matches[0];
		
		//on recupere le titre
		preg_match('(<h1 class=\"m_title\">.*</h1>)', $codeSourceBlocRecette, $titre);
		
	//	echo  "<h1>".strip_tags($titre[0])."</h1>";
		
		//on recupere le bloc image de la recette
		preg_match_all('(class="m_content_recette_illu">(.*?)</a>)', $codeSourceBlocRecette, $baliseImage, PREG_PATTERN_ORDER);
		
		//echo $baliseImage[1][0];
		//on recupere le lien de l'image
		preg_match('(<img(.*?)(src=(.*?))( alt=(.*))>)', $baliseImage[1][0], $image);
		
		//var_dump($image);
		
		/* on recupere les temps */
		//TEMPS DE PREPARATION
		preg_match('(<span class=\"preptime\">(.*?)<span)', $codeSourceBlocRecette, $tempsPrepa);
		$TempsPreparation = strip_tags($tempsPrepa[0]);
	//	echo "Le temps de préparation est de : ".$TempsPreparation." minutes<br/><br/>";
		//TEMPS DE CUISSON
		preg_match('(<span class=\"cooktime\">(.*?)<span)', $codeSourceBlocRecette, $tempsCuiss);
		$TempsCuisson = strip_tags($tempsCuiss[0]);
	//	echo "Le temps de cuisson est de : ".$TempsCuisson." minutes<br/><br/>";
		
		/* Recupere les ingredients */
		preg_match('(<p class=\"m_content_recette_ingredients\">(.*?)</p)', $codeSourceBlocRecette, $Ingredients);
		$ingredientsTexte = strip_tags($Ingredients[0]);
		
		$ingredientsFinale = explode("- ", $ingredientsTexte);
		
		//$ingredientsFinaleTexte = "";
		
		foreach( $ingredientsFinale as $k => $v ){
			
			if($k == 0){
		//		echo "<strong>".$v."</strong><br/><br/>";
			}else{
		//		echo $v."<br/>";	
			}
			
			//$ingredientsFinaleTexte .= $v."<br/>";
			
		}
		
		/* Recupere la recette */
		preg_match('(<div class=\"m_content_recette_todo\">(.*?)<div class)', $codeSourceBlocRecette, $Recette);
		
		$RecetteSepare = str_replace("<br/>", ";", $Recette[0]);
		
		$RecetteSepare_N = strip_tags($RecetteSepare);
		
		$RecetteFinale = explode(";", $RecetteSepare_N);
		
		//$RecetteFinaleTexte = "";
		
		foreach( $RecetteFinale as $k => $v ){
			if($k == 0){
		//		echo "<br/><strong>".$v."</strong>";
			}else{
		//		echo $v."<br/>";
			}
			
			//$RecetteFinaleTexte .= $v;
		
			
		}//fin foreach
		
		$titre = strip_tags($titre[0]);
		$image_N = strip_tags($image[3]);
		$lienIMG = str_replace("'", "", $image_N);
		$lienIMG = str_replace(" ", "", $lienIMG);
		
		if(empty($lienIMG)){
			$lienIMG = "http://galinette.webconquerant.fr/template/_gfx/no-image.png";
		}
		
		if(!empty($titre)){
			
			//REMPLI LE TABLEAU
			$tableRetourInfo["titre"] = $titre;
			$tableRetourInfo["image"] = $lienIMG;
			$tableRetourInfo["tempPrepartion"] = $TempsPreparation;
			$tableRetourInfo["tempCuisson"] = $TempsCuisson;
			$tableRetourInfo["tableIngredients"]["ingredients"] = $ingredientsFinale;
			$tableRetourInfo["tablePreparation"]["preparation"] = $RecetteFinale;
			
			//var_dump($tableRetourInfo);
			return $tableRetourInfo;
			
		}else{
			
			return 0;
			
		}
		
		
	
}//fin function

 

/* Methode qui cherche des recette aleatoirment et retourne un tableau */
function recetteAleatoire(){
	
	$tableUrl = array();
	
	for($i = 10000; $i <= 11000; $i = $i + 100){
		
		$tableUrl[$i] = 'http://www.marmiton.org/recettes/recette_soupe-a-l-oignon_'.rand(1000, 20000).'.aspx';
		
	}
	
	$tableRecette = array();
	$tableInfoRecette = array();
	
	foreach($tableUrl as $k => $v){
		
		$tableRetour = recupeInfo($v);
		
			if($tableRetour != 0){
			
				//appel de la methode qui recupereLes information @params : url ou $v
				$tableInfoRecette[$k]  = recupeInfo($v);

			}
		
	}
	
	$tableRecette["Recette"] = $tableInfoRecette;
	
	return $tableRecette;
	
}//fin function

/* Methode qui recupere l'url et appel la methode qui recupere les informations sur le site et retourne la table des recettes */
function traiteSelectionUrl($url){
	
	$tableRecette["Recette"] = recupeInfo($url);
	
	return $tableRecette;
	
}


/* Methode qui serialse un array(tableau) en xml en utilisant la librairy Array2XML */
function enregistreXML($tableRecette){
	
	//Array2XML::init($version /* ='1.0' */, $encoding /* ='UTF-8' */);

	$xml = Array2XML::createXML('copieMarmitton', $tableRecette);
	
	//creating an xslt adding processing line
	$xslt = $xml->createProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="XSL.xsl"');
	//$xml->appendChild($xslt);
	
	$premiereBalise = $xml->getElementsByTagName("copieMarmitton")->item(0);
	$section = $xml->insertBefore($xslt,$premiereBalise);
	
	//echo $xml->saveXML();
	$Date = date("Y_m_d");
	$xml->save('XML_recette/Recette_'.$Date.'.xml');//Sauvegarde dans un fichier xml
	
	//renvoie au client 
	//echo 'XML_recette/Recette_'.$Date.'.xml';
	//$_SERVER['HTTP_HOST'].''.dirname($_SERVER['PHP_SELF']).
	echo 'XML_recette/Recette_'.$Date.'.xml';//aressy-interactive.net/barath2/MARMITTON/recupeInfos.php
	
}


?>