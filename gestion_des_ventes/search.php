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

    // Retourner les données au format JSON
    return json_encode([
        'historiqueGroupByDate' => $historiqueGroupByDate,
        'somme_totale' => $sommeTotale,
    ]);
}

// Appeler la fonction et afficher le résultat
echo getHistoriqueVentes();
?>
