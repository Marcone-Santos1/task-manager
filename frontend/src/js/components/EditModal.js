import { Modal } from 'bootstrap'

export class EditModal {
    constructor(onSave) {
        this.onSave = onSave;
        this.modalElement = this.createModal();
        this.modal = new Modal(this.modalElement);
        this.bindEvents();
    }

    createModal() {
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = 'editModal';
        modal.tabIndex = '-1';
        modal.setAttribute('aria-hidden', 'true');
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Tarefa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            <input type="hidden" id="edit_id">
                            <div class="mb-3">
                                <label for="edit_title" class="form-label">Título*</label>
                                <input type="text" class="form-control" id="edit_title" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_due_date" class="form-label">Data de Vencimento*</label>
                                <input type="date" class="form-control" id="edit_due_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Descrição</label>
                                <textarea class="form-control" id="edit_description" rows="3"></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="edit_completed">
                                <label class="form-check-label" for="edit_completed">Concluída</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="saveChanges">Salvar Alterações</button>
                    </div>
                </div>
            </div>
        `;
        return modal;
    }

    bindEvents() {
        this.modalElement.querySelector('#saveChanges').addEventListener('click', () => {
            const taskData = {
                title: this.modalElement.querySelector('#edit_title').value,
                description: this.modalElement.querySelector('#edit_description').value,
                due_date: this.modalElement.querySelector('#edit_due_date').value,
                completed: this.modalElement.querySelector('#edit_completed').checked
            };
            const id = this.modalElement.querySelector('#edit_id').value;
            this.onSave(id, taskData);
            this.modal.hide();
        });
    }

    open(task) {
        this.modalElement.querySelector('#edit_id').value = task.id;
        this.modalElement.querySelector('#edit_title').value = task.title;
        this.modalElement.querySelector('#edit_description').value = task.description || '';
        this.modalElement.querySelector('#edit_due_date').value = task.due_date;
        this.modalElement.querySelector('#edit_completed').checked = task.completed;
        this.modal.show();
    }

    render(container) {
        container.appendChild(this.modalElement);
    }
}