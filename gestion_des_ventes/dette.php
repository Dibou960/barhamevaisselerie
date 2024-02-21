<?php
include './db/db.php';

// Récupérer les dettes au format JSON
$response = array();

try {
    $stmt = $conn->prepare("SELECT * FROM dettes ORDER BY date_creation DESC");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $dettes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retourner le JSON avec l'en-tête approprié
        header('Content-Type: application/json');
        echo json_encode($dettes, JSON_UNESCAPED_UNICODE);
    } else {
        // Aucune dette trouvée
        $response['message'] = 'Aucune dette trouvée.';
        echo json_encode($response);
    }
} catch (PDOException $e) {
    // Erreur lors de l'exécution de la requête
    $response['error'] = 'Erreur lors de l\'exécution de la requête SQL : ' . $e->getMessage();
    echo json_encode($response);
}

// Fermer la connexion
$conn = null;
?>
