class TaskManager {
    constructor() {
        this.apiUrl = '/api/tasks';
        this.tasksList = document.getElementById('tasksList');
        this.taskInput = document.getElementById('newTask');
        this.addTaskBtn = document.getElementById('addTaskBtn');
        
        this.init();
    }
    
    init() {
        this.loadTasks();
        this.addTaskBtn.addEventListener('click', () => this.addTask());
        this.taskInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.addTask();
        });
    }
    
    async loadTasks() {
        try {
            const response = await fetch(`${this.apiUrl}/read.php`);
            const data = await response.json();
            
            if (data.records) {
                this.renderTasks(data.records);
            }
        } catch (error) {
            console.error('Error loading tasks:', error);
        }
    }
    
    async addTask() {
        const taskText = this.taskInput.value.trim();
        if (!taskText) return;
        
        try {
            const response = await fetch(`${this.apiUrl}/create.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ title: taskText })
            });
            
            if (response.ok) {
                this.taskInput.value = '';
                this.loadTasks();
            }
        } catch (error) {
            console.error('Error adding task:', error);
        }
    }
    
    async updateTaskStatus(taskId, completed) {
        try {
            const response = await fetch(`${this.apiUrl}/update.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: taskId,
                    completed: completed
                })
            });
            
            if (!response.ok) {
                throw new Error('Failed to update task');
            }
        } catch (error) {
            console.error('Error updating task:', error);
        }
    }
    
    async deleteTask(taskId) {
        try {
            const response = await fetch(`${this.apiUrl}/delete.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: taskId })
            });
            
            if (response.ok) {
                this.loadTasks();
            }
        } catch (error) {
            console.error('Error deleting task:', error);
        }
    }
    
    renderTasks(tasks) {
        this.tasksList.innerHTML = tasks.map(task => `
            <div class="task-item" data-id="${task.id}">
                <div class="task-checkbox">
                    <input type="checkbox" id="task-${task.id}" 
                           ${task.completed ? 'checked' : ''}
                           onchange="taskManager.updateTaskStatus(${task.id}, this.checked)">
                    <label for="task-${task.id}">${task.title}</label>
                </div>
                <button class="delete-btn" onclick="taskManager.deleteTask(${task.id})">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M12 4L4 12M4 4L12 12" stroke="#FF4E6E" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Delete
                </button>
            </div>
        `).join('');
    }
}

// Initialize Task Manager
const taskManager = new TaskManager();