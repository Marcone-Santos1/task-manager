import { TaskItem } from './TaskItem.js';

export class TaskList {
    constructor(onTaskUpdate, onTaskDelete, onTaskToggle) {
        this.onTaskUpdate = onTaskUpdate;
        this.onTaskDelete = onTaskDelete;
        this.onTaskToggle = onTaskToggle;
        this.listElement = this.createList();
    }

    createList() {
        const list = document.createElement('div');
        list.id = 'taskList';
        list.className = 'list-group';
        return list;
    }

    renderTasks(tasks) {
        this.listElement.innerHTML = '';
        tasks.forEach(task => {
            const taskItem = new TaskItem(
                task, 
                this.onTaskUpdate, 
                this.onTaskDelete, 
                this.onTaskToggle
            );
            taskItem.render(this.listElement);
        });
    }

    render(container) {
        container.appendChild(this.listElement);
    }
}