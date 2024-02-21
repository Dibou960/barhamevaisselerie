<?php 
// session_set_cookie_params(2592000, '/', 'barhamglobalebusiness.alwaysdata.net', false, true);

session_start();
include 'historique_vente.php';
$historiqueData = getHistoriqueVentes();
$historiqueGroupByDate = $historiqueData['historiqueGroupByDate'];
$sommeTotale = $historiqueData['somme_totale'];

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION['nom_utilisateur'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barhame Vaissellerie</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;,">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/calendar-dates.css' rel='stylesheet'>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" /> -->
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-2">
        <h1 class="text-3xl font-semibold text-center ">Barhame Vaissellerie</h1>
        <!-- <p>Bienvenue, <?php echo $_SESSION['nom_utilisateur']; ?>!</p> -->
        <div class="flex justify-center mb-2">
</div>

<div class="flex justify-between">
<button class=" px-2.5 h-8  bg-black text-white rounded-full" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>
<div class="flex">
  <p class="text-2xl font-bold text-red-600"><span class="text-xl text-black">Totale:</span><?php echo isset($historiqueVentes['somme_totale']) ? $historiqueVentes['somme_totale'] : '0 FCFA'; ?><span class="text-sm text-black">FCFA</span> </p>
</div>

<button class="menu" data-bs-toggle="dropdown" aria-expanded="false" onclick="this.classList.toggle('opened');this.setAttribute('aria-expanded', this.classList.contains('opened'))" aria-label="Main Menu">
      <svg width="40" height="40" viewBox="0 0 100 100">
        <path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
        <path class="line line2" d="M 20,50 H 80" />
        <path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
      </svg>
    </button>

  <ul class="dropdown-menu">
<!--   
      <li><a class="dropdown-item" data-modal-target="default-modal" data-modal-toggle="default-modal" >Gerer les dettes</a></li>

    -->
      <li><a class="dropdown-item text-xl font-bold" href="/Produits/listedesproduits.php">Gerer mes achats</a></li>
      <li><a class="dropdown-item" href="logout.php"><span class="text-red-500 text-xl font-bold">Se déconnecter</span></a></li>
  </ul>

</div>
<div class="date-container" style="display: flex; justify-content: space-between; align-items: center;" >

    <!-- Input Date -->
    <input class="border-2 rounded-2 mb-2 pt-1 pb-1 pl-2 pr-2 bg-gray-300 text-xl hidden transition-all duration-5000 ease-in-out" type="date" id="date" name="date" placeholder="Recherche...">

    <!-- Search Icon -->
    <label class="label-icon bg-gray-300 rounded-full border-2 p-2" for="date" onclick="toggleInput()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="30px" height="30px">
            <path d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"/>
        </svg>
    </label>

    <!-- Rounded Image -->
    <a href="home.php">
        <div class="bg-gray-300 rounded-full border-2 p-2 mb-2" style="border-radius: 50%;">
     <img width="30" height="40" src="https://img.icons8.com/glyph-neue/64/return.png" alt="return"/>
        </div>
    </a>

</div>



<script>
    function toggleInput() {
        var input = document.getElementById('date');
        input.classList.toggle('hidden');
    }
</script>

<!-- Cartes pour afficher chaque vente -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 py-2" id="contenu">

<!-- Affichage des données -->
<?php foreach ($historiqueGroupByDate as $date => $historiques): ?>
    <div class="card bg-light p-4 rounded-lg shadow-md mb-4" id="carte_<?php echo $date; ?>">
    <div class="flex justify-between item-center">
    <h3 class="text-lg font-weight-bold mb-3"><?php echo $date; ?></h3>
    <button type="button" class="btn btn-primary" onclick="imprimer('<?php echo $date; ?>')">Imprimer</button>
</div>
        
        <?php foreach ($historiques as $vente): ?>
            <?php if (isset($vente['montant']) && is_numeric($vente['montant'])): ?>
                <div class="flex justify-between items-center mb-3">
                    <!-- Colonne 1 : Produit et Montant -->
                    <div class="flex flex-col">
                        <!-- Affichage du produit -->
                        <h2 class="text-lg font-weight-bold mb-2"><?php echo isset($vente['produit']) ? htmlspecialchars($vente['produit']) : ''; ?></h2>

                        <!-- Affichage du montant -->
                        <p class="text-dark"><?php echo htmlspecialchars($vente['montant']) . ' Fcfa'; ?></p>
                    </div>

                    <!-- Colonne 2 : Heure et Boutons -->
                    <div class="flex flex-col items-end">
                        <!-- Affichage de l'heure -->
                        <p class="text-sm text-muted">
                            <?php
                                // Convertir la date de la vente au format souhaité (par exemple, Y-m-d H:i:s)
                                $heureVente = isset($vente['date_vente']) ? (new DateTime($vente['date_vente']))->format('H:i:s') : 'N/A';
                                echo $heureVente;
                            ?>
                        </p>

                        <!-- Affichage des boutons à droite -->
                        <div class="flex mt-2">
                            <!-- Bouton "Modifier" avec appel à la fonction JavaScript -->
                            <button id="monBouton" type="button" class="btn btn-warning ml-2" onclick="ouvrirModalModifier('<?php echo $vente['id']; ?>', '<?php echo $vente['produit']; ?>', '<?php echo $vente['montant']; ?>')">Modifier</button>

                            <!-- Formulaire de suppression avec SweetAlert confirmation -->
                            <form method="post" action="home.php" class="delete-form ml-2">
                                <input type="hidden" name="id_a_supprimer" value="<?php echo $vente['id']; ?>">
                                <button type="button" class="btn btn-danger" onclick="confirmDelete('<?php echo $vente['id']; ?>')">Supprimer</button>
                            </form>
                            

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
</div>

<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative pt-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative pt-4 bg-white rounded-lg shadow dark:bg-gray-700 w-full">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Gestion des dettes
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4" id="cartesDettes"></div>

             <!-- Modal footer -->
             <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="default-modal" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Retour</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal ajout historique-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-2xl font-bold" id="exampleModalLabel">Ajouter historique</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter un nouvel historique -->
                <form method="post" action="insert_data.php">
                <div class="row gy-3 overflow-hidden">
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" id="produit" class="form-control text-2xl font-bold" name="produit" required>
                          <label for="produit" class="form-label text-xl font-bold">Produit</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="number" id="montant" class="form-control text-2xl font-bold" name="montant"  required>
                          <label for="montant" class="form-label text-xl font-bold">Montant</label>
                        </div>
                      </div>
                      <div class="col-12">
                      </div>
                        <div class=" flex justify-between">
                        <button type="submit" class="btn btn-dark btn-lg">Enregistrer</button>
                          <button type="button" class="btn btn-secondary btn-lg " data-bs-dismiss="modal">Fermer</button>
                       
                    </div>
                      </div>
                    </div>
 
                </form>
            </div>
           
        </div>
    </div>
</div>

<!-- Modal de Modification -->

<div class="modal" id="modifierModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier Historique</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire de modification -->
                <div class="container mx-auto my-8 p-8 bg-white max-w-md">
       <form id="formModifier" method="post" action="modifier_historique.php" class="space-y-4">
        <input type="hidden" name="id_a_modifier" id="id_a_modifier">

        <div>
            <label for="nouveau_produit" class="block text-sm font-semibold text-gray-600">Nouveau Produit:</label>
            <input type="text" name="nouveau_produit" id="nouveau_produit" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
        </div>

        <div>
            <label for="nouveau_montant" class="block text-sm font-semibold text-gray-600">Nouveau Montant:</label>
            <input type="text" name="nouveau_montant" id="nouveau_montant" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required>
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-md">Modifier</button>
    </form>
</div>
            </div>
        </div>
    </div>
</div>



<script src="./js/main.js"></script>
<script src="./js/dette.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>