
document.addEventListener('DOMContentLoaded', () => {
    const dueDateInput = document.getElementById('due_date');
    if (dueDateInput) {
        dueDateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
    }
});

function showTasks(type) {
    const assignedTab = document.getElementById('assigned-tasks');
    const createdTab = document.getElementById('created-tasks');

    const assignedLabel = document.getElementById('assigned-tab');
    const createdLabel = document.getElementById('created-tab');

    if (type === 'assigned') {
        assignedTab.style.display = 'block';
        createdTab.style.display = 'none';

        assignedLabel.classList.add('active');
        createdLabel.classList.remove('active');
    } else {
        assignedTab.style.display = 'none';
        createdTab.style.display = 'block';

        createdLabel.classList.add('active');
        assignedLabel.classList.remove('active');
    }
}
