export class TaskForm {
    constructor(onSubmit) {
        this.onSubmit = onSubmit;
        this.formElement = this.createForm();
        this.bindEvents();
    }

    createForm() {
        const form = document.createElement('form');
        form.id = 'taskForm';
        form.className = 'mb-4';
        form.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Título*</label>
                    <input type="text" class="form-control" id="title" required>
                </div>
                <div class="col-md-6">
                    <label for="due_date" class="form-label">Data de Vencimento*</label>
                    <input type="date" class="form-control" id="due_date" required>
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control" id="description" rows="2"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Adicionar Tarefa
                    </button>
                </div>
            </div>
        `;
        return form;
    }

    bindEvents() {
        this.formElement.addEventListener('submit', (e) => {
            e.preventDefault();
            const taskData = {
                title: this.formElement.querySelector('#title').value,
                description: this.formElement.querySelector('#description').value,
                due_date: this.formElement.querySelector('#due_date').value
            };
            this.onSubmit(taskData);
            this.formElement.reset();
        });
    }

    render(container) {
        container.appendChild(this.formElement);
    }
}