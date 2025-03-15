function navigateToMenu() {
    document.getElementById('landing-page').classList.add('hidden');
    document.getElementById('menu-page').classList.remove('hidden');
}

function navigateToLanding() {
    document.getElementById('menu-page').classList.add('hidden');
    document.getElementById('landing-page').classList.remove('hidden');
}

function searchPredications() {
    const searchTerm = document.getElementById('search-field').value;
    // Simuler une recherche (à remplacer par une requête API réelle)
    const predications = []; // Remplacer par les données réelles
    const grid = document.getElementById('predications-grid');
    grid.innerHTML = '';

    if (predications.length === 0) {
        document.getElementById('no-results').classList.remove('hidden');
    } else {
        document.getElementById('no-results').classList.add('hidden');
        predications.forEach(predication => {
            const card = document.createElement('div');
            card.className = 'predication-card';
            card.innerHTML = `
                <img src="image.jpg" alt="Predication Image">
                <h3>${predication.theme}</h3>
                <p>${predication.contenu.substring(0, 50)}...</p>
                <p>${predication.dated}</p>
            `;
            card.onclick = () => showPredicationDetail(predication);
            grid.appendChild(card);
        });
    }
}

function showPredicationDetail(predication) {
    document.getElementById('menu-page').classList.add('hidden');
    document.getElementById('detail-page').classList.remove('hidden');
    document.getElementById('predication-theme').textContent = predication.theme;
    document.getElementById('predication-text').textContent = predication.texte;
    document.getElementById('predication-date').textContent = predication.dated;
    document.getElementById('predication-content').textContent = predication.contenu;
}

function navigateToMenuFromDetail() {
    document.getElementById('detail-page').classList.add('hidden');
    document.getElementById('menu-page').classList.remove('hidden');
}