// Projet/app/Views/public/assets/script/js/project.js

function editProject(projectId) {
    const project = projects.find(p => p.id === projectId);
    document.getElementById('project_id').value = project.id;
    document.getElementById('title').value = project.title;
    document.getElementById('description').value = project.description;
    document.querySelector('.project-form').style.display = 'block';
}

function addNewProject() {
    document.getElementById('project_id').value = '';
    document.getElementById('title').value = '';
    document.getElementById('description').value = '';
    document.querySelector('.project-form').style.display = 'block';
}

function cancelEdit() {
    document.querySelector('.project-form').style.display = 'none';
}