<!DOCTYPE html>
<html>
    <head>
        <title>Données Formulaire</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="fontawesome-free-5.9.0-web/css/all.css">
        <link rel="stylesheet" href="fontawesome-free-5.9.0-web/css/v4-shims.css">
    </head>
    <body>
        <h2> Enregistrer un Employé</h2>
        <div id="conteneurs">
            <form action="formulaire.php" method="POST" >
                <div class="element">
                    <?php
                    $monfichier = fopen('employes.txt','r');
                    $contenu = file_get_contents('employes.txt');
                    if(!empty($contenu))
                    {
                        while(($data = fgetcsv($monfichier, 1000, ',')) !==FALSE)
                        {
                            $num = count($data);
                            for($c = 0; $c < $num ; $c++)
                            {
                                $matricule = $data[0];
                            }
                        }
                        fclose($monfichier);
                        $matricule ++;
                    }
                    else
                    {

                        $matricule = "EM-0001";
                        fclose($monfichier);

                    }
                    
                    ?>
                    <input type="text" name="matricule" value=" <?= $matricule?>" readonly>
                </div>
                <div class="element">
                    <input type="text" name="prenom" Placeholder="Prenom" required></br>
                </div>
                <div class="element">
                    <input type="text" name="nom" placeholder="Nom" required></br>
                </div>
                <div class="element">
                    <input type="text" name="dateNaiss" placeholder="Date de Naissance: jj/mm/aaaa" required>
                </div>
                <div class="element">
                    <input type="text" name="salaire" placeholder="Salaire: [25000 - 2000000]" require> 
                </div>
                <div class="element">
                    <input type="text" name="tel" placeholder="N° Telephone" required>
                </div>
                <div class="element">
                    <input type="text" name="email" placeholder="Email" required>
                </div>
                    <div class="elementbtn">
                    <input class="btn" type="submit" name="ok" value="Enregistrer">
                    </div>
                </div>
            </form>
        </div>
        <?php
        
        
            
        function ajoutEmploye($employe)
        {
            $monfichier = fopen('employes.txt','a');
            fputcsv($monfichier,$employe);
            fclose($monfichier);
        }

        if(isset($_POST['ok']))
        {

            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $dateNaiss = trim($_POST['dateNaiss']);
            $salaire = trim((int) $_POST['salaire']);
            $tel = trim($_POST['tel']);
            $email = trim($_POST['email']);
            if(preg_match('#^([0-9]{2}/){2}[0-9]{4}$#',$dateNaiss))
            {
                 if(preg_match('#^7[0,6,7,8]([0-9]){7}$#',$tel))
                {

                    if ($salaire >= 25000 && $salaire <= 2000000)
                    {
                        
                        if(preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#',$email))
                        {
                            $employe = array(
                                'matricule' => $matricule,
                                'nom'=> $nom,
                                'prenom' => $prenom,
                                'dateNaiss' => $dateNaiss,
                                'salaire' => $salaire,
                                'tel' => $tel,
                                'email' => $email,
                            );
                            ajoutEmploye($employe);
                            
                        }
                        else
                        {
                            echo '<span class="msgError">L\'email est incorrect!!!</span>';
                        }

                    }
                    else
                    {
                        echo '<span class="msgError">Le salaire est incorrect !!!</span>';
                    }
                

                 }
                 else
                 {
                    echo '<span class="msgError">Le Numero de telephone est incorrect !!!</span>';
                 }
                
            }
            else
            {
                echo '<span class="msgError">La date est incorrecte !!!</span>';
            }
        }
        function afficheEmployes()
            {
                echo '<h2>Liste des Employés</h2>';
                echo '<div class="table">';
                echo '<table border="1px">';
                echo '<th>Matricule</th><th>Nom</th><th>Prenom</th><th>Date Naissance</th><th>Salaire</th>
                    <th>N° tel</th><th>Email</th><th colspan ="2">Actions</th>';
                if(($handle = fopen('employes.txt','r')) !==FALSE)
                {
                    while(($data = fgetcsv($handle, 1000, ',')) !==FALSE)
                    {
                        $num = count($data);
                        echo '<tr>';
                        
                        for($c = 0; $c < $num ; $c++)
                        {
                            echo '<td>'.$data[$c].'</td>';
                        }
                        echo '<td><a href="confirmDelete.php?matricule='.$data[0].'" ><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
                        </a></td>';
                        echo '<td><a href="edit.php?matricule='.$data[0].'"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
                        </a></td>';
                        echo '</tr>';
                    }
                    fclose($handle);
                }
                echo '</table>';
                echo '</div>';
            
            }
            $monfichier = fopen('employes.txt','r');
            $contenu = file_get_contents('employes.txt');
            if(!empty($contenu))
            {
                afficheEmployes();
            }
            else
            {
                echo '<span class="msgError">Le fichier est vide Enregistrer des Employés</span>';
            }
            fclose($monfichier);

        ?>
    </body>
</html>
        