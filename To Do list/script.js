const todoList = [];

renderTodoList();

function renderTodoList() {
    let todoListHTML = '';

    todoList.forEach((todoObject, index) => {
        const { name, dueDate } = todoObject;
        const html = `
        <div>${name}</div>
        <div>${dueDate}</div>
        <button class="delete-todo-button js-delete-todo-button">Delete</button> 
      `;
        todoListHTML += html;
    });

    document.querySelector('.js-todo-list')
        .innerHTML = todoListHTML;

    document.querySelectorAll('.js-delete-todo-button')
        .forEach((deleteButton, index) => {
            deleteButton.addEventListener('click', () => {
                todoList.splice(index, 1);
                renderTodoList();
            });
        });
}

document.querySelector('.js-add-todo-button')
    .addEventListener('click', () => {
        addTodo();
    });

document.querySelector('.js-due-date-input')
    .addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            addTodo();
        }
    });

function addTodo() {
    const inputElement = document.querySelector('.js-name-input');
    const name = inputElement.value.trim();

    const dateInputElement = document.querySelector('.js-due-date-input');
    const dueDate = dateInputElement.value;

    if (!name && !dueDate) {
        alert('Please enter a todo and a due date!');
        return;
    }
    if (!name) {
        alert('Please enter a todo!');
        return;
    }
    if (!dueDate) {
        alert('Please enter a due date!');
        return;
    }

    todoList.push({ name, dueDate });

    inputElement.value = '';
    dateInputElement.value = '';

    renderTodoList();
}