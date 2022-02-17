<?php 

$pdo= new PDO('mysql:host=localhost;dbname=site_ecommerce', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// initiation de la session
session_start();



//chemin du site (constante toujours en majuscule)
define('SITE', '/Projet/');

// variable d'affichage (principalement pour les messages d'erreur)

$contenu = '';

function debug($var) {
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}


// Note: 
// => : pour les tableau, = associée à cette valeure du tableau /// -> : pour les objets, = accède à la propriété (directement nommée) ou à la méthode (entre parenthèse)


function executeRequete($requete, $param = array()){
    //le paramètre $requete reçoit une requête sql. Le paramètre $param reçoit un tableau avec les marqueurs assoiciés à leur valeur

    //Echappement des données avec htmlspecialchars()
    foreach($param as $marqueur => $valeur)
    {
        $param[$marqueur]=htmlspecialchars($valeur);
        //On transforme les chevrons en entitée html qui neutralise les balises <style> et <script> eventuellement injectées en formulaire. Evite les failles XSS et CSS
    }


    global $pdo; //permet d'accéder à la variable $pdo de manière globale

    $resultat=$pdo->prepare($requete);// On prepare la requête reçue
    $success=$resultat->execute($param);// On exécute en lui passant le tableau des marqueurs associés à leur valeur

    //execute() renvoie toujours un boolean: true en cas de succès et false en cas d'échec

    if($success)//si $success == true donc que la requête a fonctionné
    {

        return $resultat;

    }else{

        return false;
    }

}