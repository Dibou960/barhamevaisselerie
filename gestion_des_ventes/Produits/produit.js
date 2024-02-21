let data;
document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("searchInput");
  searchInput.addEventListener("input", handleSearch);

  // Écouter l'événement "submit" du formulaire
  searchForm.addEventListener("submit", (event) => {
    // Empêcher la soumission par défaut du formulaire
    event.preventDefault();
  });

  const outputDiv = document.getElementById("output");

  // Afficher le skeleton loader initial
  showSkeletonLoader();

  fetch("getproduits.php")
    .then((response) => response.json())
    .then((responseData) => {
      data = responseData;
      // Retirer le skeleton loader avant d'afficher les données réelles
      hideSkeletonLoader();
      updateDisplay(data);
    })
    .catch((error) => {
      console.error("Erreur lors de la récupération des données:", error);
      // En cas d'erreur, masquer le skeleton loader
      hideSkeletonLoader();
    });

  function showSkeletonLoader() {
    outputDiv.innerHTML = "";

    const gridContainer = document.createElement("div");
    gridContainer.classList.add(
      "grid",
      "grid-cols-2",
      "md:grid-cols-6",
      "gap-2",
      "py-2",
      "pr-2",
      "pl-2",
    );

    for (let i = 0; i < 12; i++) {
      const skeletonCard = document.createElement("div");
      skeletonCard.classList.add(
        "card",
        "bg-gray-300",
        "animate-pulse",
        "p-2",
        "rounded-3",
        "shadow-md",
      );
      const skeletonContent = `
        <div class="w-full h-36 bg-gray-300 rounded-3 animate-pulse"></div>
        <div class="p-2">
            <div class="text-xl flex justify-center font-bold mb-2 bg-gray-300 h-8 animate-pulse"></div>
            <div class="text-gray-400 mb-2 font-semibold bg-gray-300 h-6 animate-pulse"></div>
            <div class="text-gray-400 mb-2 font-semibold bg-gray-300 h-6 animate-pulse"></div>
            <div class="flex justify-between">
            <div>
            <button type="button" class=" bg-gray-300 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg px-2 py-0.5 text-center me-2 mb-2 text-gray-300 ">+</button>
  
            <button type="button" class=" bg-gray-300 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg px-2 py-0.5 text-center me-2 mb-2 text-gray-300 ">+</button>
           
            </div>
                <div class="btn-group dropup">
                    <button class="bg-gray-300 h-8 w-8 rounded-full animate-pulse"></button>
                </div>
            </div>
        </div>
      `;
      skeletonCard.innerHTML = skeletonContent;
      gridContainer.appendChild(skeletonCard);
    }

    outputDiv.appendChild(gridContainer);
  }

  function hideSkeletonLoader() {
    outputDiv.innerHTML = "";
  }

  function updateDisplay(products) {
    const gridContainer = document.createElement("div");
    gridContainer.classList.add(
      "grid",
      "grid-cols-2",
      "md:grid-cols-6",
      "gap-2",
      "pr-2",
      "pl-2",

    );

    products.forEach((produit) => {
      const productCard = document.createElement("div");
      productCard.classList.add(
        "card",
        "bg-light",
        "p-2",
        "rounded-3",
        "shadow-md"
      );

      const cardContent = `
        <img class="w-full h-full object-cover rounded-3 " src="${
          produit.image_path_relative
        }" alt="${produit.nom_produit}">
        <div class="p-2">
          <h2 class="text-xl flex justify-center font-bold mb-2">${produit.nom_produit.toUpperCase()}</h2>
          <p class="text-gray-600 mb-2 font-semibold ">Prix: <span class="text-2xl">${
            produit.prix
          }<span></p>
          <p class="text-gray-600 mb-2 font-semibold">Quantité: <span class="text-2xl">${
            produit.quantite
          }<span></p>
          <div class="flex justify-between">
            <div>
              <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xl font-bold px-2 py-0.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">+</button>
              <button type="button" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xl font-bold px-2 py-0.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">-</button>
            </div>
            <!-- Default dropup button -->
            <div class="btn-group dropup">
              <button dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                  <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                </svg>
              </button>
              <ul class="dropdown-menu">
                <li>
                  <i class="fas fa-edit text-blue-500 cursor-pointer mr-2 pl-2" onclick="openUpdateModal(${
                    produit.id
                  })"> Modifier</i>
                </li>
                <li>
                  <i class="fas fa-trash-alt text-red-500 cursor-pointer mr-2 pl-2" onclick="deleteProduct(${
                    produit.id
                  })"> Supprimer</i>
                </li>
              </ul>
            </div>
          </div>
        </div>
      `;

      productCard.innerHTML = cardContent;
      gridContainer.appendChild(productCard);
    });

    outputDiv.appendChild(gridContainer);

    if (products.length === 0) {
      // Aucun produit trouvé, afficher l'icône d'animation
      const noResultsContainer = document.createElement("div");
      noResultsContainer.classList.add("text-center", "flex", "justify-center");
  
      const noResultsImage = document.createElement("img");
      noResultsImage.src = "notfound.gif";
      noResultsImage.alt = "Aucun résultat trouvé";
      noResultsImage.style.width = "20%";  // Ajustez la taille selon vos besoins
      noResultsImage.style.height = "10%"; // Ajustez la taille selon vos besoins
      noResultsImage.style.borderRadius = "100%"; // Ajustez la taille selon vos besoins
      noResultsImage.style.marginTop = "10%"; // Ajustez la taille selon vos besoins
  
     
      noResultsContainer.appendChild(noResultsImage);
  
      outputDiv.appendChild(noResultsContainer);
  
      // Arrêter l'exécution de la fonction ici, car il n'y a rien d'autre à afficher
      return;
    }
  

  }

  function handleSearch() {
    const searchTerm = searchInput.value.toLowerCase();

    // Afficher le skeleton loader pendant la recherche
    showSkeletonLoader();

    // Vérifier si le champ de recherche est vide
    if (searchTerm.length === 0) {
      // Afficher les données initiales
      hideSkeletonLoader();
      updateDisplay(data);
    } else if (searchTerm.length >= 3) {
      hideSkeletonLoader();
      // Effectuer la recherche
      const filteredData = data.filter(
        (produit) =>
          produit.nom_produit.toLowerCase().includes(searchTerm) ||
          produit.prix.toString().includes(searchTerm)
      );

      // Afficher le skeleton loader pendant la recherche
      updateDisplay(filteredData);
    }
  }
});

function openUpdateModal(productId) {
  // Recherchez le produit correspondant dans les données chargées
  const productToUpdate = data.find((produit) => produit.id === productId);

  // Remplissez les champs du formulaire avec les données du produit
  document.getElementById("updateProductId").value = productToUpdate.id;
  document.getElementById("updateProductName").value =
    productToUpdate.nom_produit;
  document.getElementById("updateProductPrice").value = productToUpdate.prix;
  document.getElementById("updateProductQuantity").value =
    productToUpdate.quantite;

  // Mettez à jour l'aperçu de l'image avec l'image actuelle du produit
  const updatePreviewImage = document.getElementById("updatePreviewImage");
  updatePreviewImage.src = productToUpdate.image_path_relative;
  // Récupérez l'élément input de type file pour la modification d'image
  const updateImageInput = document.getElementById("updateImageInput");

  // Ajoutez un gestionnaire d'événements pour détecter le changement de fichier
  updateImageInput.addEventListener("change", function () {
    // Mettez à jour l'aperçu de l'image avec le nouveau fichier sélectionné
    const file = updateImageInput.files[0];
    const reader = new FileReader();
    reader.onload = function (e) {
      updatePreviewImage.src = e.target.result;
    };
    reader.readAsDataURL(file);
  });

  // Ouvrez le modal de mise à jour
  const updateProductModal = new bootstrap.Modal(
    document.getElementById("updateProductModal")
  );
  updateProductModal.show();
}

function deleteProduct(productId) {
  Swal.fire({
    title: "Êtes-vous sûr?",
    text: "Vous ne pourrez pas récupérer ce produit!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Oui, supprimer!",
  }).then((result) => {
    if (result.isConfirmed) {
      // Si l'utilisateur clique sur le bouton "Oui", effectuez la suppression
      performDelete(productId);
    }
  });
}

function performDelete(productId) {
  fetch("delete_product.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ productId: productId }),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur lors de la suppression du produit.");
      }
      // Actualiser la page ou mettre à jour l'interface utilisateur après la suppression
      location.reload();
    })
    .catch((error) => {
      console.error("Erreur de suppression:", error);
    });
}
