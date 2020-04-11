<?php
// Connexion à la BDD
try{
    $pdo = new PDO('mysql:host=localhost; dbname=sellbase', 'root', '',
    [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ]);
   } catch(PDOException $e) {
        die('Database connexion failed '. $e->getMessage());
   }

$query = 'SELECT lastname, firstname, age, city FROM sell_user_member ORDER BY id ASC';

//$membres = [];

if ($results= $pdo->query($query)) {
    //on récupère les membres
    $membres = $results->fetchAll();
    $membreTri = $membres;
}

//insertion d'un nouveau membre
if ($pdo){

            if(!empty($_POST['nom']) && !empty($_POST['prenom']) && is_numeric($_POST['age']) && !empty($_POST['ville']))
                    {


                    $query= $pdo->prepare("INSERT INTO sell_user_member(lastname,firstname,age,city) VALUES (:lastname, :firstname, :age, :city)");
                    $query->execute(['lastname' => $_POST['nom'], 'firstname' => $_POST['prenom'], 'age' => $_POST['age'], 'city' => $_POST['ville']]);

                   }     
                   //on quitte le script 
                   //exit();
                }

// trier les tableaux
$colonne = '';
$tri = '';

if (!empty($_POST['tri']) && !empty($_POST['colonne'])) {
    $tri = $_POST['tri'];
    $colonne = $_POST['colonne'];
    $query = "SELECT lastname, firstname, age, city FROM sell_user_member ORDER BY $colonne $tri";
    $stmt = $pdo->query($query);
    if ($stmt) {
        $membreTri = $stmt->fetchAll();
    }
}
/*$link = new mysqli("localhost", "root", "", "sellbase");

 Vérification de la connexion 
if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}
mysqli_set_charset($link,"utf8");*/
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Test</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
       
    </head>
    <body>
        <div class="mainView">
            <div class="headerView">
                <img src="img/logo.png">
            </div>
            <div class="contentView">
                <div class="onequart">
                    <p>Liste des membres</p>
                    <table id="membre_table">
                        <thead>
                            <tr class="row">
                                <th>NOM</th>
                                <th>PRÉNOM</th>
                                <th>AGE</th>
                                <th>VILLE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                foreach ($membres as $membre):
                                ?>
                            <tr>       
                                <td><?= $membre->lastname; ?></td>
                                <td><?= $membre->firstname; ?></td>
                                <td><?= $membre->age; ?></td>    
                                <td><?= $membre->city; ?></td>
                                
                            </tr>
                            
                            <?php
                            /* Libération des résultats 
                            mysqli_free_result($results);*/
                             
                        endforeach; ?>
                        </tbody>
                    </table>
                    
                </div><!--onequart-->

                <div class="threequart">
                    <p>Formulaire de tri</p>
                    <form id="formulaire" action="index.php" method="POST">
                        <select class="tri" name="colonne" id="colonne" onchange="this.form.submit()">

                            <option value="lastname" <?php if($colonne=== "lastname"){echo "selected";} ?>>nom</option>
                            <option value="firstname" <?php if($colonne=== "firstname"){echo "selected";} ?>>prenom</option>
                            <option value="age" <?php if($colonne=== "age"){echo "selected";} ?>>age</option>
                            <option value="city" <?php if($colonne=== "city"){echo "selected";} ?>>ville</option>
                        </select>
                        <select class="tri" name="tri" id="tri" onchange="this.form.submit()">
                            <option value="ASC" <?php if($tri=== "ASC"){echo "selected";} ?>>Croissant</option>
                            <option value="DESC" <?php if($tri=== "DESC"){echo "selected";} ?>>Décroissant</option>
                        </select>
                        <?php
                        
                        ?>
                        
                    </form>
                    <table id="table_tri">
                        <thead>
                            <tr>
                                <th>NOM</th>
                                <th>PRÉNOM</th>
                                <th>AGE</th>
                                <th>VILLE</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        <?php foreach ($membreTri as $membre): ?> 
                            <tr>      
                                <td><?= $membre->lastname; ?></td>
                                <td><?= $membre->firstname; ?></td>
                                <td><?= $membre->age; ?></td>    
                                <td><?= $membre->city; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p>Nouveau membre</p>
                    <form id="addMembre" action="index.php" method="POST" onsubmit="return Validate()" name="addMembre">
                        <p>Nom <input type="text" class="input" name="nom" id="nom"> 
                        Prénom <input type="text" class="input" name="prenom" id="prenom"> 
                        Age <input type="number" min="20" max="100" class="input" name="age" id="age"> 
                        Ville <input type="text" class="input" name="ville" id="ville"></p>
                        <button type="submit" name="register" id="envoyer">Valider</button>
                    </form>
                    <?php
                    
                 
                ?>
                    <div class="message" id="message"></div>
                </div><!--threequart-->
            </div><!--contentview-->
            <div class="clear"></div>
            <div class="footerView">
                <ul>
                    <li><img src="img/facebook.png"></li>
                    <li><img src="img/twitter.png"></li>
                    <li><img src="img/google.png"></li>
                </ul>
            </div><!--footerview-->
        </div>
            <script src="js/jquery.3.2.1.min.js"></script>
            <script src="js/script.js"></script>
    </body>

</html>
