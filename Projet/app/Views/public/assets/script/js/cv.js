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