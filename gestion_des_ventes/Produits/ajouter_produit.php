<?php

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION['nom_utilisateur'])) {
    header("Location: ../home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

    <title>Ajouter un Produit</title>
</head>

<body>
    <div class="flex justify-between">
    <button type="button" class="bg-black text-white btn-primary mx-2 my-2 add flex items-center" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"><span class="pl-0.5 pb-1.5 text-gray-400 font-bold text-4xl">+</span></button>


    <div class="relative">
    <form id="searchForm">
        <input type="search" id="searchInput" placeholder="Rechercher" class="rounded-4 mt-2.5 px-4 py-2 mr-2 bg-gray-100 focus:outline-none focus:shadow-outline border-2 border-black focus:border-blue-500 transition-all duration-300 transform focus:scale-105">
        <button type="submit" class="absolute right-0 top-0 mt-3.5 pt-1.5 mr-4 transition-all duration-300 transform hover:scale-110">
            <i class="fas fa-search text-gray-500"></i>
        </button>
    </form>
</div>


</div>
<div class="flex justify-end pr-2">
<a href="../home.php">
        <div class="bg-gray-300 rounded-full border-2 p-2 mb-2" style="border-radius: 50%;">
     <img width="30" height="40" src="https://img.icons8.com/glyph-neue/64/return.png" alt="return"/>
        </div>
    </a>
    </div>
</div> 
</div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Nouveau Produit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  
      <div class="w-full max-w-lg mx-auto p-8">
  
  
        <form action="addproduit.php" method="post" enctype="multipart/form-data">
      
        <div class="grid grid-cols-2 gap-6">
                
                <div class="col-span-2 sm:col-span-1 mt-5">
                <label for="nom_produit" class="form-label">Nom du Produit:</label>
                <input type="text" name="nom_produit" id="nom_produit" placeholder="Produit" class="w-full py-3 px-4 border border-gray-400 rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>
                
                <div class="col-span-2 sm:col-span-1 relative">
                <label for="imageInput" title="Click pour telecharger" class="cursor-pointer flex items-center gap-4 px-6 py-4 before:border-gray-400/60 hover:before:border-gray-300 group dark:before:bg-darker dark:hover:before:border-gray-500 before:bg-gray-100 dark:before:border-gray-600 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">

                <div class="w-max relative">
    <img id="previewImage" class="w-36 h-36 object-cover rounded-full" src="https://static.thenounproject.com/png/2532839-200.png" alt="file upload icon">
</div>

        </div>
    </label>
    <input hidden type="file" name="image" id="imageInput" accept="image/*" required>

</div>
                <div class="col-span-2 sm:col-span-1">
                    
                    <label for="prix" class="form-label block text-sm font-medium text-gray-700 mb-2">Prix du Produit</label>
                    <input type="number" name="prix" id="prix" placeholder="000" class="w-full py-3 px-4 border border-gray-400 rounded-lg focus:outline-none focus:border-blue-500" required>
              
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="quantite" class="form-label block text-sm font-medium text-gray-700 mb-2">Quantité du Produit</label>
                    <input type="number" name="quantite" id="quantite" placeholder="Quantité" class="w-full py-3 px-4 border border-gray-400 rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>
            </div>
            <div class="mt-8">
                
                <button type="submit" class="w-full bg-green-500 hover:bg-blue-600 text-white font-medium py-3 rounded-lg focus:outline-none">Ajouter</button>
            </div>
        </form>
        <div class="flex justify-end pt-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
    </div>
    </div>
</div>
    

    
    </div>
  </div>
</div>

<!-- Modal de mise à jour -->
<div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">Modifier le produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="updateProductForm" action="updateproduct.php" method="post" enctype="multipart/form-data">
                    <!-- Champ pour stocker l'ID du produit -->
                    <input type="hidden" name="id_produit" id="updateProductId">

                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2 sm:col-span-1 mt-5">
                            <label for="updateProductName" class="form-label">Nom du Produit:</label>
                            <input type="text" name="nom_produit" id="updateProductName" class="w-full py-3 px-4 border border-gray-400 rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>

                        <div class="col-span-2 sm:col-span-1 relative">
                            <label for="updateImageInput" title="Click pour telecharger" class="cursor-pointer flex items-center gap-4 px-6 py-4 before:border-gray-400/60 hover:before:border-gray-300 group dark:before:bg-darker dark:hover:before:border-gray-500 before:bg-gray-100 dark:before:border-gray-600 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">
                                <div class="w-max relative">
                                    <!-- Affichage de l'image actuelle du produit -->
                                    <img id="updatePreviewImage" class="w-36 h-36 object-cover rounded-full" src="https://static.thenounproject.com/png/2532839-200.png" alt="file upload icon">
                                </div>
                            </label>
                            <input hidden type="file" name="image" id="updateImageInput" accept="image/*">
                        </div>

                        <div class="col-span-2 sm:col-span-1">
                            <label for="updateProductPrice" class="form-label block text-sm font-medium text-gray-700 mb-2">Prix du Produit</label>
                            <input type="number" name="prix" id="updateProductPrice" placeholder="000" class="w-full py-3 px-4 border border-gray-400 rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="updateProductQuantity" class="form-label block text-sm font-medium text-gray-700 mb-2">Quantité du Produit</label>
                            <input type="number" name="quantite" id="updateProductQuantity" placeholder="Quantité" class="w-full py-3 px-4 border border-gray-400 rounded-lg focus:outline-none focus:border-blue-500" required>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full bg-green-500 hover:bg-blue-600 text-white font-medium py-3 rounded-lg focus:outline-none">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function (event) {
        const previewImage = document.getElementById('previewImage');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImage.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 

</body>
</html>
