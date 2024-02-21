fetch('dette.php')
.then(response => {
    if (!response.ok) {
        throw new Error(`Erreur HTTP! Statut: ${response.status}`);
    }
    return response.json();
})
.then(data => {
    const cartesDettes = document.getElementById('cartesDettes');

    if (data.length > 0) {
        let datePrecedente = null; // Pour stocker la date de la dette précédente
        let carte = null; // Pour stocker la carte en cours de création

        data.forEach(dette => {
            // Si la date de la dette est différente de la date précédente, créer une nouvelle carte
            if (dette.date_creation.split(' ')[0] !== datePrecedente) {
                // Si une carte était en cours de création, l'ajouter à la grille
                if (carte) {
                    cartesDettes.appendChild(carte);
                }

                // Créer une nouvelle carte pour la nouvelle date
                carte = document.createElement('div');
                carte.classList.add('bg-light', 'p-4', 'rounded-lg', 'shadow-md', 'mb-4');

                // Ajouter la date à la carte
                const dateElement = document.createElement('p');
                dateElement.classList.add('text-lg', 'font-semibold', 'mb-2');
                dateElement.textContent = dette.date_creation.split(' ')[0];
                carte.appendChild(dateElement);
            }

            // Ajouter les détails de la dette à la carte
            const detteElement = document.createElement('div');
            detteElement.classList.add('mb-4');

            const nomMontantElement = document.createElement('p');
            nomMontantElement.classList.add('font-bold', 'mb-2');
            nomMontantElement.textContent = `${dette.nom_detteur} - Montant: ${dette.montant} Fcfa`;
            detteElement.appendChild(nomMontantElement);

            const motifElement = document.createElement('p');
            motifElement.classList.add('mb-2');
            motifElement.textContent = `Motif: ${dette.motif}`;
            detteElement.appendChild(motifElement);

            const boutonsElement = document.createElement('div');
            boutonsElement.classList.add('flex', 'justify-between');

            const boutonModifierElement = document.createElement('button');
            boutonModifierElement.type = 'button';
            boutonModifierElement.classList.add('bg-blue-500', 'text-white', 'px-4', 'py-2', 'rounded-md', 'mr-2');
            boutonModifierElement.textContent = 'Modifier';
            boutonModifierElement.onclick = function() {
                modifierDette(dette.id);
            };
            boutonsElement.appendChild(boutonModifierElement);

            const boutonSupprimerElement = document.createElement('button');
            boutonSupprimerElement.type = 'button';
            boutonSupprimerElement.classList.add('bg-red-500', 'text-white', 'px-4', 'py-2', 'rounded-md');
            boutonSupprimerElement.textContent = 'Supprimer';
            boutonSupprimerElement.onclick = function() {
                supprimerDette(dette.id);
            };
            boutonsElement.appendChild(boutonSupprimerElement);

            detteElement.appendChild(boutonsElement);
            carte.appendChild(detteElement);

            // Mettre à jour la date de la dette précédente
            datePrecedente = dette.date_creation.split(' ')[0];
        });

        // Ajouter la dernière carte à la grille (si elle existe)
        if (carte) {
            cartesDettes.appendChild(carte);
        }
    } else {
        // Si aucune dette n'est trouvée
        const messageAucuneDette = document.createElement('p');
        messageAucuneDette.textContent = 'Aucune dette trouvée.';
        cartesDettes.appendChild(messageAucuneDette);
    }
})
.catch(error => console.error('Erreur lors de la récupération des dettes :', error));

// Fonctions pour gérer les actions "Modifier" et "Supprimer"
function modifierDette(id) {
// Ajoutez ici le code pour gérer la modification de la dette avec l'ID spécifié
console.log(`Modifier la dette avec l'ID ${id}`);
}

function supprimerDette(id) {
// Ajoutez ici le code pour gérer la suppression de la dette avec l'ID spécifié
console.log(`Supprimer la dette avec l'ID ${id}`);
}