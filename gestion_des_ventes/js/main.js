document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        var loadingSkeleton = document.getElementById('loadingSkeleton');
        if (loadingSkeleton) {
            loadingSkeleton.remove();
        }
    }, 3000); 
});

function confirmDelete(id) {
    // Display a SweetAlert confirmation
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: 'Cette action est irréversible!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user clicks "OK", submit the form
            document.querySelector('.delete-form [name="id_a_supprimer"]').value = id;
            document.querySelector('.delete-form').submit();
        }
    });
}

    // Fonction pour pré-remplir le modal avec les données de l'enregistrement
    function ouvrirModalModifier(id, produit, montant) {
        // Mettez à jour les champs du formulaire dans le modal avec les données de l'enregistrement
        document.getElementById('id_a_modifier').value = id;
        document.getElementById('nouveau_produit').value = produit;
        document.getElementById('nouveau_montant').value = montant;

        // Ouvrir le modal de modification
        $('#modifierModal').modal('show');
    }
    function imprimer(date) {
        var carte = document.getElementById('carte_' + date);
    
        if (carte !== null) {
            var titre = carte.querySelector('h3').innerText;
            var contenuImprimer = "<html><head><title>" + titre + "</title>";
            contenuImprimer += '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">';
            contenuImprimer += "</head><body class='bg-white p-8 flex items-center justify-center h-screen'>"; // Utilisation de flexbox pour centrer le contenu
    
            contenuImprimer += "<div class='text-center'>";
            contenuImprimer += "<h1 class='text-2xl font-bold mb-4'>" + "Liste des factures du " + titre + "</h1>";
    
            contenuImprimer += "<table class='mx-auto border-collapse border border-gray-300 w-full'>";
            contenuImprimer += "<thead class='bg-gray-100'>";
            contenuImprimer += "<tr>";
            contenuImprimer += "<th class='border p-2'>Nom du produit</th>";
            contenuImprimer += "<th class='border p-2'>Montant</th>";
            contenuImprimer += "<th class='border p-2'>Heure</th>";
            contenuImprimer += "</tr>";
            contenuImprimer += "</thead>";
            contenuImprimer += "<tbody>";
    
            var total = 0;
    
            var ventesElements = carte.querySelectorAll('.flex.justify-between.items-center.mb-3');
            ventesElements.forEach(function (venteElement) {
                var produit = venteElement.querySelector('h2').textContent;
                var montantTexte = venteElement.querySelector('.text-dark').textContent;
                var montant = parseFloat(montantTexte.replace(' Fcfa', ''));
                var heure = venteElement.querySelector('.text-sm.text-muted').textContent;
    
                total += montant;
    
                contenuImprimer += "<tr class='border'>";
                contenuImprimer += "<td class='border p-2'>" + produit + "</td>";
                contenuImprimer += "<td class='border p-2'>" + montantTexte + "</td>";
                contenuImprimer += "<td class='border p-2'>" + heure + "</td>";
                contenuImprimer += "</tr>";
            });
    
            contenuImprimer += "</tbody>";
            contenuImprimer += "</table>";
    
            contenuImprimer += "<div class='mt-4'>";
            contenuImprimer += "<p class='text-xl font-bold'>" + "Prix total : " + total.toFixed(2) + " Fcfa</p>";
            contenuImprimer += "</div>";
    
            contenuImprimer += "</div>";
            contenuImprimer += "</body></html>";
    
            // Utilisez la méthode print de l'objet window pour imprimer la page actuelle
            window.document.write(contenuImprimer);
            window.document.close();
    
            // Attachez un gestionnaire d'événements à l'événement 'afterprint'
            window.onafterprint = function () {
                // Réinitialisez le contenu de la page pour afficher à nouveau vos données
                window.location.reload();
            };
    
            // Déclenchez l'impression
            window.print();
        } else {
            console.error("L'élément avec l'ID carte_" + date + " n'a pas été trouvé.");
        }
    }
    
    function afficherDateInstantanement() {
        const contenu = document.getElementById('contenu');
        contenu.innerHTML = createLoadingSkeleton(); // Utilisez la fonction pour créer le squelette de chargement
    
        setTimeout(() => {
            const loadingSkeleton = document.querySelector('.max-w-md'); // Remplacez par le sélecteur approprié
            if (loadingSkeleton) {
                loadingSkeleton.remove();
            }
    
    
        const dateChoisie = document.getElementById('date').value;
        const dateFormatee = formaterDate(dateChoisie);
    
        if (historiqueGroupByDate.hasOwnProperty(dateFormatee)) {
            const ventesPourDate = historiqueGroupByDate[dateFormatee];
            const dateElement = document.createElement('div');
            dateElement.className = "grid grid-cols-1 md:grid-cols-1 gap-4 py-2";
    
            const cardElement = document.createElement('div');
            cardElement.className = "card bg-light p-4 rounded-lg shadow-md mb-4";
    
            const dateHeaderElement = document.createElement('h3');
            dateHeaderElement.className = "text-lg font-weight-bold mb-3";
            dateHeaderElement.textContent = dateFormatee;
            cardElement.appendChild(dateHeaderElement);
    
            ventesPourDate.forEach(vente => {
                if (vente['montant'] !== null && vente['montant'] !== undefined && !isNaN(vente['montant'])) {
                    const venteElement = document.createElement('div');
                    venteElement.className = "flex justify-between items-center mb-3";
    
                    const colonneProduitMontantElement = document.createElement('div');
                    colonneProduitMontantElement.className = "flex flex-col";
    
                    const produitElement = document.createElement('h2');
                    produitElement.className = "text-lg font-weight-bold mb-2";
                    produitElement.textContent = vente['produit'] !== null && vente['produit'] !== undefined ? vente['produit'] : '';
                    colonneProduitMontantElement.appendChild(produitElement);
    
                    const montantElement = document.createElement('p');
                    montantElement.className = "text-dark";
                    montantElement.textContent = vente['montant'] + ' Fcfa';
                    colonneProduitMontantElement.appendChild(montantElement);
    
                    venteElement.appendChild(colonneProduitMontantElement);
    
                    const colonneHeureBoutonsElement = document.createElement('div');
                    colonneHeureBoutonsElement.className = "flex flex-col items-end";
    
                    const heureElement = document.createElement('p');
                    heureElement.className = "text-sm text-muted";
                    const heureVente = vente['date_vente'] ? (new Date(vente['date_vente'])).toLocaleTimeString('fr-FR') : 'N/A';
    
                    heureElement.textContent = heureVente;
                    colonneHeureBoutonsElement.appendChild(heureElement);
    
                    const boutonsElement = document.createElement('div');
                    boutonsElement.className = "flex mt-2";
    
                    const boutonModifierElement = document.createElement('button');
                    boutonModifierElement.type = "button";
                    boutonModifierElement.className = "btn btn-warning ml-2";
                    boutonModifierElement.textContent = "Modifier";
                    boutonModifierElement.onclick = function() {
                        ouvrirModalModifier(vente['id'], vente['produit'], vente['montant']);
                    };
                    boutonsElement.appendChild(boutonModifierElement);
    
                    const formulaireSuppressionElement = document.createElement('form');
                    formulaireSuppressionElement.method = "post";
                    formulaireSuppressionElement.action = "home.php";
                    formulaireSuppressionElement.className = "delete-form ml-2";
    
                    const inputHiddenElement = document.createElement('input');
                    inputHiddenElement.type = "hidden";
                    inputHiddenElement.name = "id_a_supprimer";
                    inputHiddenElement.value = vente['id'];
                    formulaireSuppressionElement.appendChild(inputHiddenElement);
    
                    const boutonSupprimerElement = document.createElement('button');
                    boutonSupprimerElement.type = "button";
                    boutonSupprimerElement.className = "btn btn-danger";
                    boutonSupprimerElement.textContent = "Supprimer";
                    boutonSupprimerElement.onclick = function() {
                        confirmDelete(vente['id']);
                    };
                    formulaireSuppressionElement.appendChild(boutonSupprimerElement);
    
                    boutonsElement.appendChild(formulaireSuppressionElement);
                    colonneHeureBoutonsElement.appendChild(boutonsElement);
    
                    venteElement.appendChild(colonneHeureBoutonsElement);
                    cardElement.appendChild(venteElement);
                }
                
            });
    
            dateElement.appendChild(cardElement);
            contenu.appendChild(dateElement);
        } else {
            const gifElement = document.createElement('img');
            gifElement.src = '../vide.gif'; 
            gifElement.alt = 'Chargement en cours...';
            gifElement.style.position = 'fixed';   // Utilisez une position fixe
            gifElement.style.top = '55%';           // Centrez verticalement à 50% de la hauteur de la fenêtre
            gifElement.style.left = '50%';          // Centrez horizontalement à 50% de la largeur de la fenêtre
            gifElement.style.transform = 'translate(-50%, -50%)';  // Centrez parfaitement
            gifElement.style.width = '25%';         // Ajustez la largeur (par exemple, 50% de la largeur parente)
            gifElement.style.height = 'auto';       // Ajustez la hauteur de manière proportionnelle
            gifElement.style.borderRadius = '50%';  // Arrondir les coins à moitié
        
            document.body.appendChild(gifElement); // Ajoutez l'élément au corps du document
            
            contenu.appendChild(gifElement);
            
            const messageElement = document.createElement('p');
            messageElement.textContent = "Aucune vente pour la date choisie.";
            contenu.appendChild(messageElement);
        }
        
    }, 3000); // 5000 millisecondes (5 secondes)
    
    }

// Fonction pour formater la date au format jj-mm-aaaa
function formaterDate(date) {
    const dateObj = new Date(date);
    const jour = dateObj.getDate();
    const mois = dateObj.getMonth() + 1; // Les mois commencent à 0, donc on ajoute 1
    const annee = dateObj.getFullYear();

    // Ajouter un zéro devant le jour et le mois si nécessaire
    const jourFormatte = (jour < 10) ? `0${jour}` : jour;
    const moisFormatte = (mois < 10) ? `0${mois}` : mois;

    // Retourner la date formatée
    return `${jourFormatte}-${moisFormatte}-${annee}`;
}

// Récupérer l'élément de date
const champDate = document.getElementById('date');
// Ajouter un écouteur d'événements pour l'input de la date
champDate.addEventListener('input', afficherDateInstantanement);

// Fonction pour récupérer les données depuis le serveur PHP
function getHistoriqueVentes() {
    // Exemple de récupération des données avec fetch
    fetch('search.php')
        .then(response => response.json())
        .then(data => {
            console.log(data.historiqueGroupByDate);

            // Stocker les données historiques pour référence future
            historiqueGroupByDate = data.historiqueGroupByDate;
        })
        .catch(error => console.error('Erreur lors de la récupération des données:', error));
}

// Appeler la fonction pour récupérer les données
getHistoriqueVentes();

function createLoadingSkeleton() {
    return `
        <div role="status" class="max-w-md p-4 space-y-4 border border-gray-200 divide-y divide-gray-200 rounded animate-pulse dark:divide-gray-700 md:p-6 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
            </div>
            <div class="flex items-center justify-between pt-4">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
            </div>
            <div class="flex items-center justify-between pt-4">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
            </div>
            <div class="flex items-center justify-between pt-4">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
            </div>
            <div class="flex items-center justify-between pt-4">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
            </div>
            <div class="flex items-center justify-between pt-4">
            <div>
                <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
                <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            </div>
            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
        </div> <div class="flex items-center justify-between pt-4">
        <div>
            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
            <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
        </div>
        <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
    </div>
            <span class="sr-only">Loading...</span>
        </div>
    `;
}

