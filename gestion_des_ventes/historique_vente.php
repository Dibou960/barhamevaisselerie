<?php
include './db/db.php';


function getHistoriqueVentes() {
    global $conn;

    $historiqueVentes = [];

    // Requête SQL pour récupérer l'historique des ventes depuis la base de données
    $sql = "SELECT id, produit, montant, date_vente FROM historique_ventes ORDER BY date_vente DESC";

    try {
        // Utiliser PDO pour préparer et exécuter la requête
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Récupérer les résultats dans un tableau associatif
        $historiqueVentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Trier le tableau par date_vente de manière décroissante
        usort($historiqueVentes, function ($a, $b) {
            return strtotime($b['date_vente']) - strtotime($a['date_vente']);
        });

    } catch (PDOException $e) {
        echo "Erreur de requête : " . $e->getMessage();
    }

    // Groupement des ventes par date
    $historiqueGroupByDate = [];

    foreach ($historiqueVentes as $vente) {
        $dateVente = isset($vente['date_vente']) ? (new DateTime($vente['date_vente']))->format('d-m-Y') : 'N/A';

        if (!isset($historiqueGroupByDate[$dateVente])) {
            $historiqueGroupByDate[$dateVente] = [];
        }

        $historiqueGroupByDate[$dateVente][] = $vente;
    }

    // Ajouter la somme totale en tant qu'élément distinct dans le tableau des résultats
    $sommeTotale = array_reduce($historiqueVentes, function ($carry, $vente) {
        return $carry + $vente['montant'];
    }, 0);

    return [
        'historiqueGroupByDate' => $historiqueGroupByDate,
        'somme_totale' => $sommeTotale,
    ];
    
}



// Vérifier si le formulaire a été soumis (le bouton "Supprimer" a été cliqué)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'ID à supprimer depuis le formulaire
    $id_a_supprimer = isset($_POST['id_a_supprimer']) ? $_POST['id_a_supprimer'] : null;

    if ($id_a_supprimer !== null) {
        // Requête SQL pour supprimer un enregistrement de l'historique des ventes
        $sql = "DELETE FROM historique_ventes WHERE id = :id";

        try {
            // Utiliser PDO pour préparer et exécuter la requête avec un paramètre nommé
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id_a_supprimer);
            $stmt->execute();

            // Rediriger vers la page d'historique des ventes après la suppression
            header("Location: home.php");
            exit();
        } catch (PDOException $e) {
            echo "Erreur de suppression : " . $e->getMessage();
            // Gérer l'erreur de suppression selon vos besoins
        }
    }
}

// Récupérer l'historique des ventes après la suppression
$historiqueVentes = getHistoriqueVentes();

?>
