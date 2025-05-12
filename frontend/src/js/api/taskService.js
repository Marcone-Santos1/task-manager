const API_URL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1/api/tasks';
export const getTasks = async () => {
    const response = await fetch(API_URL);
    return await response.json();
};

export const createTask = async (taskData) => {
    const response = await fetch(API_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(taskData)
    });
    return await response.json();
};

export const updateTask = async (id, taskData) => {
    const response = await fetch(`${API_URL}/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(taskData)
    });
    return await response.json();
};

export const deleteTask = async (id) => {
    const response = await fetch(`${API_URL}/${id}`, {
        method: 'DELETE'
    });
    return response.ok;
};