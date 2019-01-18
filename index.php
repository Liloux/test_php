<?php
// Connexion à la BDD
$link = new mysqli("localhost", "root", "", "sellbase");

// Vérification de la connexion 
if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}
mysqli_set_charset($link,"utf8");
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Test</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
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
                        <tbody><tr>
                            <?php
                            //La connexion pdo pose problème au niveau du "fetch_assoc" alors je me suis rabatu sur mysqli
                            $query = "SELECT lastname, firstname, age, city FROM sell_user_member ORDER by id ASC";

                                if($result= mysqli_query($link, $query)){
                            
                            //Parcours de la première boucle
                             while ($mb= mysqli_fetch_assoc($result)) {
                                
                                ?>       
                                <td><?php echo $mb['lastname'] ; ?></td>
                                <td><?php echo $mb['firstname'] ; ?></td>
                                <td><?php echo $mb['age'] ; ?></td>    
                                <td><?php echo $mb['city'] ; ?></td>

                            </tr>
                        
                            <?php
                            }

                            echo json_encode($mb);
                            /* Libération des résultats */
                            mysqli_free_result($result);
                             
                        } ?>
                        </tbody>
                    </table>
                    
                </div><!--onequart-->

                <div class="threequart">
                    <p>Formulaire de tri</p>
                    <form id="formulaire" action="index.php" method="POST">
                        <select class="tri" name="colonne">
                            <option value="">nom</option>
                            <?php
                            $connect= mysqli_connect("localhost", "root", "", "sellbase");
                            $column= array("firstname","lastname", "age","city");
                            $query= "
                                SELECT * FROM
                                sell_user_member";


                            $query.= "WHERE";
                           
                            ?>
                            <option value="nom">nom</option>
                            <option value="prenom">prenom</option>
                            <option value="age">age</option>
                            <option value="ville">ville</option>
                        </select>
                        <select class="tri" name="tri">
                            <option value="ASC">Croissant</option>
                            <option value="DESC">Décroissant</option>
                        </select>
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
                    if ($link){

                    if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['prenom']) && isset($_POST['age']) && is_numeric($_POST['age']) && isset($_POST['ville']) && !empty($_POST['ville']))
                    {

                    $nom= $_POST['nom'];
                    $prenom= $_POST['prenom'];
                    $age= $_POST['age'];
                    $ville= $_POST['ville'];

                    $sql="INSERT INTO sell_user_member(lastname,firstname,age,city) VALUES ('$nom','$prenom','$age','$ville')";
                    $res= mysqli_query($link, $sql);

                        }
                    }
                    
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
    </body>
    <script src="js/jquery.3.2.1.min.js"></script>
    <script src="js/script.js"></script>
</html>
