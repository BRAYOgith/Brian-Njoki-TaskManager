<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Infinity Tasks | Modern Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f172a;
            --glass-bg: rgba(30, 41, 59, 0.75);
            --glass-border: rgba(255, 255, 255, 0.08);
            --primary: #8b5cf6;
            --primary-hover: #7c3aed;
            --accent: #3b82f6;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --danger: #ef4444;
            --danger-hover: #dc2626;
            --success: #10b981;
            --warning: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(139, 92, 246, 0.15), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(59, 130, 246, 0.15), transparent 25%);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(to right, #a78bfa, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-link {
            background: transparent;
            color: var(--text-muted);
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link.active {
            color: white;
            background: var(--primary);
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            width: 100%;
            padding: 0 20px;
            flex: 1;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.4s ease forwards;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            opacity: 0.8;
        }

        .card-header {
            margin-bottom: 25px;
            border-bottom: 1px solid var(--glass-border);
            padding-bottom: 15px;
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .card-header p {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-top: 5px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        @media(min-width: 768px) {
            .form-grid.two-cols { grid-template-columns: 1fr 1fr; }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input, select {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }

        button.btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        button.btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.5);
            background: linear-gradient(135deg, var(--primary-hover), var(--accent));
        }

        .table-responsive {
            overflow-x: auto;
        }

        .task-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .task-table th {
            text-align: left;
            padding: 16px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            border-bottom: 2px solid var(--glass-border);
        }

        .task-table td {
            padding: 16px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            vertical-align: middle;
        }

        .task-table tr {
            transition: background 0.2s;
        }

        .task-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .badge.high { background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); }
        .badge.medium { background: rgba(245, 158, 11, 0.15); color: #fcd34d; border: 1px solid rgba(245, 158, 11, 0.3); }
        .badge.low { background: rgba(16, 185, 129, 0.15); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3); }

        .status.pending { color: var(--text-muted); }
        .status.in_progress { color: var(--warning); }
        .status.done { color: var(--success); }

        .actions-cell {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .action-btn {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        .action-btn.danger {
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.2);
        }

        .action-btn.danger:hover {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }

        .filter-ribbon {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
            gap: 15px;
            align-items: center;
        }

        .filter-ribbon select {
            width: auto;
            min-width: 200px;
            padding: 10px 14px;
            font-size: 0.9rem;
        }

        .loading, .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--text-main);
            margin-bottom: 10px;
        }

        .stats-footer {
            margin-top: 20px;
            padding: 15px;
            background: rgba(0,0,0,0.2);
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .stats-footer span {
            color: var(--text-main);
            font-weight: 600;
        }

        .alert-container {
            position: fixed;
            top: 25px;
            right: 25px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .alert {
            min-width: 320px;
            max-width: 400px;
            padding: 16px 20px;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            white-space: pre-wrap;
            animation: slideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        @keyframes slideInRight {
            0% { transform: translateX(120%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.9);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.9);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body>

    <div class="alert-container" id="alert-container"></div>

    <nav class="navbar">
        <div class="brand">Infinity Tasks</div>
        <div class="nav-links">
            <button class="nav-link active" onclick="switchTab('create')">Create Task</button>
            <button class="nav-link" onclick="switchTab('list')">Task Board</button>
            <button class="nav-link" onclick="switchTab('reports')">Reports</button>
        </div>
    </nav>

    <div class="container">
        <div id="tab-create" class="tab-content active">
            <div class="card" style="max-width: 800px; margin: 0 auto;">
                <div class="card-header">
                    <h2>Deploy a New Task</h2>
                    <p>Enter the specifics below to inject a new assignment into the workflow.</p>
                </div>
                <form id="createTaskForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Task Directive</label>
                            <input type="text" id="taskTitle" required placeholder="Ex: Refactor the authentication logic...">
                        </div>
                    </div>
                    <div class="form-grid" style="margin-top: 20px;">
                        <div class="form-group">
                            <label>Deadline Date</label>
                            <input type="date" id="taskDueDate" required>
                        </div>
                    </div>
                    <div class="form-grid" style="margin-top: 20px;">
                        <div class="form-group">
                            <label>Priority Tier</label>
                            <select id="taskPriority">
                                <option value="high">High - Immediate Action</option>
                                <option value="medium">Medium - Standard Queue</option>
                                <option value="low">Low - Background Process</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary" style="margin-top: 30px;">Initialize Task</button>
                </form>
            </div>
        </div>
        <div id="tab-list" class="tab-content">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; border:none; margin-bottom: 0px;">
                    <div>
                        <h2>Primary Task Board</h2>
                        <p>Track execution status for your direct assignments.</p>
                    </div>
                    <div class="filter-ribbon" style="margin-bottom:0px;">
                        <select id="statusFilter" onchange="loadTasks()">
                            <option value="">Global Filter: All</option>
                            <option value="pending">State: Pending</option>
                            <option value="in_progress">State: In Progress</option>
                            <option value="done">State: Completed</option>
                        </select>
                        <button onclick="loadTasks()" class="action-btn">Sync Data</button>
                    </div>
                </div>
                
                <div id="tasksList">
                    <div class="loading">Establishing secure connection... fetching items.</div>
                </div>
            </div>
        </div>
        <div id="tab-reports" class="tab-content">
            <div class="card" style="margin-bottom: 30px;">
                <div class="card-header">
                    <h2>Daily Report</h2>
                    <p>View task counts by priority and status for a specific date.</p>
                </div>
                <form id="reportForm">
                    <div class="form-grid one-col">
                        <div class="form-group">
                            <label>Report Date</label>
                            <input type="date" id="reportDate">
                        </div>
                    </div>
                    <div style="display: flex; gap: 15px; margin-top: 30px;">
                        <button type="submit" class="btn-primary" style="margin-top: 0; flex: 1;">Generate Report</button>
                        <button type="button" class="btn-primary" onclick="clearReportForm()" style="margin-top: 0; background: transparent; border: 1px solid var(--glass-border); width: auto;">Clear</button>
                    </div>
                </form>
            </div>

            <div class="card" id="reportResultsCard" style="display: none;">
                <div class="card-header">
                    <h2>Report Results</h2>
                    <p id="reportDateDisplay"></p>
                </div>
                <div id="reportData"></div>
            </div>
        </div>

    </div>

    <script>
        const API_URL = '/api/tasks';
        let alertIdCounter = 0;

        document.addEventListener('DOMContentLoaded', () => {
            const today = new Date().toISOString().split('T')[0];
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowStr = tomorrow.toISOString().split('T')[0];

            document.getElementById('taskDueDate').value = tomorrowStr;
            document.getElementById('reportDate').value = today;
            
            loadTasks();
        });

        function switchTab(tabId) {
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');

            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById('tab-' + tabId).classList.add('active');

            if (tabId === 'list') {
                loadTasks();
            }
        }

        function createAlert(message, type) {
            const container = document.getElementById('alert-container');
            const alertId = 'alert-' + alertIdCounter++;
            
            const alertElement = document.createElement('div');
            alertElement.className = `alert alert-${type}`;
            alertElement.id = alertId;
            alertElement.textContent = message;

            container.appendChild(alertElement);

            setTimeout(() => {
                const el = document.getElementById(alertId);
                if (el) {
                    el.style.animation = 'slideInRight 0.4s cubic-bezier(0.16, 1, 0.3, 1) reverse forwards';
                    setTimeout(() => el.remove(), 400); // Wait for reverse animation
                }
            }, 4000);
        }

        async function loadTasks() {
            const status = document.getElementById('statusFilter').value;
            const url = status ? `${API_URL}?status=${status}` : API_URL;

            try {
                const response = await fetch(url);
                const tasks = await response.json();

                const tasksList = document.getElementById('tasksList');

                if (!tasks || tasks.length === 0) {
                    tasksList.innerHTML = `
                        <div class="empty-state">
                            <h3>No active directives</h3>
                            <p>Proceed to Create Task to deploy a new unit of work.</p>
                        </div>
                    `;
                    return;
                }

                tasksList.innerHTML = renderTasksTable(tasks, false);
            } catch (error) {
                console.error('Error loading tasks:', error);
                document.getElementById('tasksList').innerHTML = '<div class="empty-state"><p>Core Exception: Unable to synchronize matrix. Verify the link to the core server.</p></div>';
            }
        }

        function renderTasksTable(tasks, isReport = false) {
            return `
                <div class="table-responsive">
                    <table class="task-table">
                        <thead>
                            <tr>
                                <th>Directive</th>
                                <th>Deadline</th>
                                <th>Priority Context</th>
                                <th>Current State</th>
                                <th>Controls</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${tasks.map(task => `
                                <tr>
                                    <td style="font-weight: 500;">${escapeHtml(task.title)}</td>
                                    <td>${formatDate(task.due_date)}</td>
                                    <td><span class="badge ${task.priority}">${task.priority}</span></td>
                                    <td><span class="status ${task.status}">${formatStatus(task.status)}</span></td>
                                    <td>
                                        <div class="actions-cell">
                                            ${getStatusButtons(task, isReport)}
                                            ${task.status === 'done' ? `<button onclick="deleteTask(${task.id}, ${isReport})" class="action-btn danger">Purge</button>` : ''}
                                        </div>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
                <div class="stats-footer">
                    <div>Total Monitored Units: <span>${tasks.length}</span></div>
                    <div>
                        Pending: <span>${tasks.filter(t => t.status === 'pending').length}</span> &nbsp;|&nbsp; 
                        Active: <span>${tasks.filter(t => t.status === 'in_progress').length}</span> &nbsp;|&nbsp; 
                        Terminated: <span>${tasks.filter(t => t.status === 'done').length}</span>
                    </div>
                </div>
            `;
        }

        function formatStatus(status) {
            return status.replace('_', ' ').toUpperCase();
        }

        function formatDate(dateString) {
            if (!dateString) return 'Unspecified';
            const date = new Date(dateString);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);

            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }
        
        function escapeHtml(unsafe) {
            return unsafe
                 .replace(/&/g, "&amp;")
                 .replace(/</g, "&lt;")
                 .replace(/>/g, "&gt;")
                 .replace(/"/g, "&quot;")
                 .replace(/'/g, "&#039;");
        }

        function getStatusButtons(task, isReport) {
            if (task.status === 'pending') {
                return `<button onclick="updateStatus(${task.id}, 'in_progress', ${isReport})" class="action-btn">Initiate</button>`;
            } else if (task.status === 'in_progress') {
                return `<button onclick="updateStatus(${task.id}, 'done', ${isReport})" class="action-btn">Finalize</button>`;
            }
            return '<span class="status done" style="font-size:0.8rem; font-weight:600;">System Locked</span>';
        }

        async function updateStatus(id, newStatus, isReport) {
            try {
                const response = await fetch(`${API_URL}/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                const result = await response.json();

                if (response.ok) {
                    createAlert(`Directive state shifted to ${newStatus.replace('_', ' ')}!`, 'success');
                    if (isReport) {
                        document.getElementById('reportForm').dispatchEvent(new Event('submit'));
                        loadTasks();
                    } else {
                        loadTasks();
                    }
                } else {
                    createAlert(result.error || result.message || 'Exception during state transition.', 'error');
                }
            } catch (error) {
                console.error('Error updating status:', error);
                createAlert('Critical failure processing state update.', 'error');
            }
        }

        async function deleteTask(id, isReport) {
            if (!confirm('Warning: This process is irreversible. Proceed with permanent purge?')) {
                return;
            }

            try {
                const response = await fetch(`${API_URL}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    createAlert('Target successfully purged from matrix.', 'success');
                    if (isReport) {
                        document.getElementById('reportForm').dispatchEvent(new Event('submit'));
                        loadTasks();
                    } else {
                        loadTasks();
                    }
                } else {
                    createAlert(result.error || result.message || 'Exception terminating record.', 'error');
                }
            } catch (error) {
                console.error('Error deleting task:', error);
                createAlert('Target lock failure. Record persists.', 'error');
            }
        }

        document.getElementById('createTaskForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const title = document.getElementById('taskTitle').value.trim();
            const due_date = document.getElementById('taskDueDate').value;
            const priority = document.getElementById('taskPriority').value;

            if (!title) {
                createAlert('Task Directive missing. Provide syntax.', 'error');
                return;
            }

            const submitButton = e.target.querySelector('button');
            const originalText = submitButton.textContent;
            submitButton.textContent = 'Processing Payload...';
            submitButton.disabled = true;

            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ title, due_date, priority })
                });

                const result = await response.json();

                if (response.ok) {
                    createAlert('Directive successfully injected!', 'success');
                    document.getElementById('createTaskForm').reset();

                    const today = new Date().toISOString().split('T')[0];
                    const tomorrow = new Date();
                    tomorrow.setDate(tomorrow.getDate() + 1);
                    document.getElementById('taskDueDate').value = tomorrow.toISOString().split('T')[0];

                    switchTab('list'); 
                } else {
                    if (result.errors) {
                        const errors = Object.values(result.errors).flat().join('\\n');
                        createAlert(errors, 'error');
                    } else {
                        createAlert(result.message || 'Server rejected payload', 'error');
                    }
                }
            } catch (error) {
                console.error('Error creating task:', error);
                createAlert('Network exception transmitting package.', 'error');
            } finally {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        });
        
        function clearReportForm() {
            document.getElementById('reportDate').value = '';
            document.getElementById('reportResultsCard').style.display = 'none';
        }

        document.getElementById('reportForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const dateStr = document.getElementById('reportDate').value;
            const queryStr = dateStr ? `?date=${dateStr}` : '';

            try {
                const response = await fetch(`${API_URL}/report${queryStr}`);
                
                if (response.ok) {
                    const result = await response.json();
                    document.getElementById('reportDateDisplay').textContent = result.date;
                    document.getElementById('reportResultsCard').style.display = 'block';
                    
                    const summary = result.summary;
                    const priorities = ['high', 'medium', 'low'];
                    const statuses = ['pending', 'in_progress', 'done'];
                    
                    let html = `
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--glass-border);">
                                    <th style="text-align: left; padding: 12px; color: var(--text-muted);">Priority</th>
                                    <th style="text-align: center; padding: 12px; color: var(--text-muted);">Pending</th>
                                    <th style="text-align: center; padding: 12px; color: var(--text-muted);">In Progress</th>
                                    <th style="text-align: center; padding: 12px; color: var(--text-muted);">Done</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                    
                    for (const priority of priorities) {
                        const pClass = priority.charAt(0).toUpperCase() + priority.slice(1);
                        html += `
                            <tr style="border-bottom: 1px solid var(--glass-border);">
                                <td style="padding: 12px;">
                                    <span class="priority-badge ${priority}" style="padding: 4px 12px; border-radius: 6px; font-size: 13px; font-weight: 500;">${pClass}</span>
                                </td>
                                <td style="text-align: center; padding: 12px; font-size: 18px; font-weight: 600;">${summary[priority].pending}</td>
                                <td style="text-align: center; padding: 12px; font-size: 18px; font-weight: 600;">${summary[priority].in_progress}</td>
                                <td style="text-align: center; padding: 12px; font-size: 18px; font-weight: 600;">${summary[priority].done}</td>
                            </tr>
                        `;
                    }
                    
                    html += '</tbody></table>';
                    document.getElementById('reportData').innerHTML = html;
                } else {
                    createAlert('Failed to generate report.', 'error');
                }
            } catch(e) {
                createAlert('Network exception.', 'error');
            }
        });
    </script>
</body>
</html>