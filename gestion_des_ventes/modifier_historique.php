<?php
include './db/db.php';

// Vérifier si le formulaire de modification a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_a_modifier'])) {
    // Récupérer les nouvelles données du formulaire
    $nouveau_produit = $_POST['nouveau_produit'];
    $nouveau_montant = $_POST['nouveau_montant'];
    $id_a_modifier = $_POST['id_a_modifier'];

    try {
        // Requête SQL pour mettre à jour l'historique de vente
        $sql = "UPDATE historique_ventes SET produit = :nouveau_produit, montant = :nouveau_montant WHERE id = :id_a_modifier";

        // Utiliser PDO pour préparer et exécuter la requête avec des paramètres nommés
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nouveau_produit', $nouveau_produit);
        $stmt->bindParam(':nouveau_montant', $nouveau_montant);
        $stmt->bindParam(':id_a_modifier', $id_a_modifier);

        // Exécuter la requête
        $stmt->execute();

        // Rediriger vers la page d'historique des ventes après la modification
        header("Location: home.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur de modification : " . $e->getMessage();
        // Gérer l'erreur de modification selon vos besoins
    }
} else {
    // Rediriger vers la page d'historique des ventes si le formulaire n'a pas été soumis correctement
    header("Location: home.php");
    exit();
}
?>
