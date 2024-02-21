<?php
include '../db/db.php';

// Récupérer l'ID du produit à supprimer depuis la requête
$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['productId'];

try {
    // Requête SQL pour supprimer le produit
    $sql = "DELETE FROM Produit WHERE id = :productId";

    // Utiliser PDO pour préparer et exécuter la requête avec un paramètre nommé
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);

    // Exécuter la requête
    $stmt->execute();

    // Envoyer une réponse OK
    http_response_code(200);
} catch (PDOException $e) {
    // Envoyer une réponse avec une erreur interne du serveur
    http_response_code(500);
    echo "Erreur de suppression : " . $e->getMessage();
}
?>
