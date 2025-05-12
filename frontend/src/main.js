import { TaskForm } from './js/components/TaskForm.js';
import { TaskList } from './js/components/TaskList.js';
import { EditModal } from './js/components/EditModal.js';
import {
    getTasks,
    createTask,
    updateTask,
    deleteTask
} from './js/api/taskService.js';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';


class TaskManagerApp {
    constructor() {
        this.initComponents();
        this.renderApp();
        this.loadTasks();
    }

    initComponents() {
        // Formulário de criação
        this.taskForm = new TaskForm((taskData) => this.handleCreateTask(taskData));

        // Lista de tarefas
        this.taskList = new TaskList(
            (task) => this.editModal.open(task),
            (id) => this.handleDeleteTask(id),
            (id, completed) => this.handleToggleTask(id, completed)
        );

        // Modal de edição
        this.editModal = new EditModal((id, taskData) => this.handleUpdateTask(id, taskData));
    }

    renderApp() {
        const appContainer = document.querySelector('.card-body');
        this.taskForm.render(appContainer);
        this.taskList.render(appContainer);
        this.editModal.render(document.body);
    }

    async loadTasks() {
        try {
            const tasks = await getTasks();
            this.taskList.renderTasks(tasks);
        } catch (error) {
            console.error('Error loading tasks:', error);
            alert('Erro ao carregar tarefas');
        }
    }

    async handleCreateTask(taskData) {
        try {
            await createTask(taskData);
            this.loadTasks();
        } catch (error) {
            console.error('Error creating task:', error);
            alert('Erro ao criar tarefa');
        }
    }

    async handleUpdateTask(id, taskData) {
        try {
            await updateTask(id, taskData);
            this.loadTasks();
        } catch (error) {
            console.error('Error updating task:', error);
            alert('Erro ao atualizar tarefa');
        }
    }

    async handleDeleteTask(id) {
        try {
            await deleteTask(id);
            this.loadTasks();
        } catch (error) {
            console.error('Error deleting task:', error);
            alert('Erro ao excluir tarefa');
        }
    }

    async handleToggleTask(id, completed) {
        try {
            await updateTask(id, { completed });
            this.loadTasks();
        } catch (error) {
            console.error('Error toggling task:', error);
            alert('Erro ao alterar status da tarefa');
        }
    }
}

// Inicializar a aplicação quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', () => {
    new TaskManagerApp();
});