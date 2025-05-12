export class TaskItem {
    constructor(task, onEdit, onDelete, onToggle) {
        this.task = task;
        this.onEdit = onEdit;
        this.onDelete = onDelete;
        this.onToggle = onToggle;
        this.element = this.createElement();
        this.bindEvents();
    }

    createElement() {
        const dueDate = new Date(this.task.due_date);
        const formattedDate = dueDate.toLocaleDateString('pt-BR');
        const now = new Date();
        const isOverdue = !this.task.completed && dueDate < now;

        const element = document.createElement('div');
        element.className = `list-group-item task-item ${this.task.completed ? 'completed' : ''}`;
        element.id = `task-${this.task.id}`;
        element.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 task-title">${this.task.title}</h5>
                    <p class="mb-1">${this.task.description || 'Sem descrição'}</p>
                    <small class="text-muted due-date">
                        <span class="badge ${isOverdue ? 'bg-danger' : 'badge-due'} me-2">
                            ${formattedDate}
                        </span>
                        ${this.task.completed ? '<span class="badge badge-completed">Concluída</span>' : ''}
                    </small>
                </div>
                <div class="task-actions">
                    <button class="btn btn-sm btn-outline-primary me-1 edit-btn">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger delete-btn">
                        <i class="bi bi-trash"></i>
                    </button>
                    <button class="btn btn-sm ${this.task.completed ? 'btn-success' : 'btn-outline-success'} toggle-btn">
                        <i class="bi ${this.task.completed ? 'bi-check-circle-fill' : 'bi-check-circle'}"></i>
                    </button>
                </div>
            </div>
        `;
        return element;
    }

    bindEvents() {
        this.element.querySelector('.edit-btn').addEventListener('click', () => {
            this.onEdit(this.task);
        });

        this.element.querySelector('.delete-btn').addEventListener('click', () => {
            if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
                this.onDelete(this.task.id);
            }
        });

        this.element.querySelector('.toggle-btn').addEventListener('click', () => {
            this.onToggle(this.task.id, !this.task.completed);
        });
    }

    render(container) {
        container.appendChild(this.element);
    }
}