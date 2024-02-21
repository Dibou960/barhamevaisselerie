<?php
// session_set_cookie_params(2592000, '/', 'barhamglobalebusiness.alwaysdata.net', false, true);
session_start();

include 'db/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message_erreur = ""; // Initialisation de la variable pour stocker les messages d'erreur

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Utilisation de requêtes préparées pour éviter les attaques par injection SQL
    $query = "SELECT * FROM Utilisateurs WHERE nom_utilisateur = :nom_utilisateur AND mot_de_passe = :mot_de_passe";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nom_utilisateur', $nom_utilisateur, PDO::PARAM_STR);
    $stmt->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
    $stmt->execute();

    // Utilisation de fetch pour obtenir le résultat
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['nom_utilisateur'] = $nom_utilisateur;
        header("Location: home.php");
        exit();
    } else {
        // L'utilisateur n'est pas authentifié
        $message_erreur = "Identifiant Incorrect !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">

</head>
<body>

    <!-- Login 8 - Bootstrap Brain Component -->
<section class="bg-light p-3 p-md-4 p-xl-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-xxl-11">
        <div class="card border-light-subtle shadow-sm">
        
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
              <div class="col-12 col-lg-11 col-xl-10">
                <div class="card-body p-3 p-md-4 p-xl-5">
                  <div class="row">
                    <div class="col-12">
                      <div class="mb-5">
                        <div class="text-center mb-4">
                          <a href="#!">
                            <img src="/bgb.jpeg" alt="BootstrapBrain Logo" width="160" height="160">
                          </a>
                        </div>
                        <h4 class="text-center">Bienvenue dans Barham Global Business</h4>
                      </div>
                      <div class="col-12">
                      <?php if (!empty($message_erreur)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p><?php echo $message_erreur; ?></p>  
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="d-flex gap-3 flex-column">
                      
                      </div>
                      
                    </div>
                  </div>
                  <form action="index.php" method="post" >
                    <div class="row gy-3 overflow-hidden">
                      <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" id="nom_utilisateur" class="form-control" name="nom_utilisateur" id="email" placeholder="" required>
                          
                          <label for="nom_utilisateur" class="form-label">Nom d'utilisateur</label>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-floating mb-3">

                          <input type="password" id="mot_de_passe"  class="form-control" name="mot_de_passe" id="password" value="" placeholder="" required>
                          <label for="password" class="form-label">Mot de passe</label>
                        </div>
                      </div>
                      <div class="col-12">
                       
                      </div>
                 
                        <div class="d-grid">

                          <button class="btn btn-dark btn-lg" type="submit">Connexion</button>
                        </div>
                      </div>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-12">
                      <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

