function updateColorPreview(previewId, color) {
    document.getElementById(previewId).style.backgroundColor = color;
}

function applyColors() {
    const backgroundColor = document.getElementById('backgroundColor').value;
    const sidebarColor = document.getElementById('sidebarColor').value;
    
    document.body.style.backgroundColor = backgroundColor;
    document.querySelector('.sidebar').style.backgroundColor = sidebarColor;
}

function editCVFields() {
    const hiddenInputs = document.querySelectorAll('.hidden-input');
    const saveButton = document.getElementById('saveButton');
    const toggleVisibilityButton = document.getElementById('toggleVisibilityButton');

    // Vérifie si les champs sont actuellement visibles
    const isVisible = hiddenInputs[0].style.display === 'block';

    if (isVisible) {
        // Masquer les champs
        hiddenInputs.forEach(input => input.style.display = 'none');
        saveButton.style.display = 'none';
        toggleVisibilityButton.style.display = 'none';
    } else {
        // Afficher les champs
        hiddenInputs.forEach(input => input.style.display = 'block');
        saveButton.style.display = 'block';
        toggleVisibilityButton.style.display = 'block';

        // Appliquer les couleurs lors de l'édition
        applyColors();
    }
}

function confirmVisibilityChange() {
    const visibilityInput = document.getElementById('visibility');
    const toggleButton = document.getElementById('toggleVisibilityButton');
    if (visibilityInput.value === 'private') {
        if (confirm("Êtes-vous sûr de vouloir rendre ce CV public ?")) {
            visibilityInput.value = 'public';
            toggleButton.textContent = 'Public';
        }
    } else {
        if (confirm("Êtes-vous sûr de vouloir rendre ce CV privé ?")) {
            visibilityInput.value = 'private';
            toggleButton.textContent = 'Privé';
        }
    }
}

function addField(section) {
    const container = document.getElementById(`${section}-fields`);
    const div = document.createElement('div');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = `${section}[]`;
    input.placeholder = section.charAt(0).toUpperCase() + section.slice(1);
    const button = document.createElement('button');
    button.type = 'button';
    button.textContent = 'Supprimer';
    button.onclick = function() {
        removeField(button);
    };
    div.appendChild(input);
    div.appendChild(button);
    container.appendChild(div);
}

function removeField(button) {
    button.parentElement.remove();
}