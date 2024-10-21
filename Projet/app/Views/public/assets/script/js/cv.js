function editCVFields() {
    document.querySelectorAll('.hidden-input').forEach(input => input.style.display = 'block');
    document.getElementById('saveButton').style.display = 'block';
    document.getElementById('toggleVisibilityButton').style.display = 'block';
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