<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Management API — Demo</title>
    <style>
        :root {
            --bg: #f4f4f1;
            --surface: #ffffff;
            --border: #e3e3e0;
            --text: #1b1b18;
            --muted: #706f6c;
            --accent: #f53003;
            --accent-hover: #d42a02;
            --success: #1a7f37;
            --warning: #9a6700;
            --info: #0969da;
            --radius: 8px;
            --shadow: 0 1px 2px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(26, 26, 0, 0.08);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
        }

        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1.25rem 3rem;
        }

        header {
            margin-bottom: 1.5rem;
        }

        header h1 {
            margin: 0 0 0.35rem;
            font-size: 1.75rem;
            font-weight: 600;
        }

        header p {
            margin: 0;
            color: var(--muted);
            max-width: 52rem;
        }

        .layout {
            display: grid;
            gap: 1.25rem;
        }

        @media (min-width: 900px) {
            .layout {
                grid-template-columns: 320px 1fr;
                align-items: start;
            }
        }

        .panel {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.25rem;
        }

        .panel h2 {
            margin: 0 0 1rem;
            font-size: 1rem;
            font-weight: 600;
        }

        label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            margin-bottom: 0.35rem;
        }

        input, select, textarea {
            width: 100%;
            padding: 0.55rem 0.65rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            font: inherit;
            background: #fff;
            margin-bottom: 0.85rem;
        }

        textarea {
            min-height: 4.5rem;
            resize: vertical;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        button {
            font: inherit;
            cursor: pointer;
            border: none;
            border-radius: 6px;
            padding: 0.55rem 0.9rem;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
            width: 100%;
            font-weight: 500;
        }

        .btn-primary:hover { background: var(--accent-hover); }

        .btn-secondary {
            background: #fff;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover { background: #fafaf9; }

        .btn-small {
            padding: 0.35rem 0.65rem;
            font-size: 0.8125rem;
        }

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: end;
            margin-bottom: 1rem;
        }

        .toolbar .field { flex: 1; min-width: 120px; }
        .toolbar label { margin-bottom: 0.25rem; }
        .toolbar input, .toolbar select { margin-bottom: 0; }

        .task-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .task-card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem;
            background: #fff;
        }

        .task-card.selected {
            border-color: var(--accent);
            box-shadow: 0 0 0 1px var(--accent);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            align-items: start;
        }

        .task-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .task-meta {
            margin: 0.35rem 0 0;
            font-size: 0.8125rem;
            color: var(--muted);
        }

        .badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
            justify-content: end;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.15rem 0.5rem;
            border-radius: 999px;
            white-space: nowrap;
        }

        .badge-priority-low { background: #ddf4ff; color: var(--info); }
        .badge-priority-medium { background: #fff8c5; color: var(--warning); }
        .badge-priority-high { background: #ffebe9; color: var(--accent); }
        .badge-status-todo { background: #f6f8fa; color: var(--muted); }
        .badge-status-inprogress { background: #ddf4ff; color: var(--info); }
        .badge-status-done { background: #dafbe1; color: var(--success); }

        .task-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }

        .empty-state {
            text-align: center;
            padding: 2.5rem 1rem;
            color: var(--muted);
            border: 1px dashed var(--border);
            border-radius: var(--radius);
        }

        .edit-panel {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .edit-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.25rem;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .alert-error {
            background: #ffebe9;
            color: #82071e;
            border: 1px solid #ffcecb;
        }

        .alert-success {
            background: #dafbe1;
            color: #116329;
            border: 1px solid #aceebb;
        }

        .alert-info {
            background: #ddf4ff;
            color: #0550ae;
            border: 1px solid #b6e3ff;
        }

        .api-note {
            margin-top: 1.25rem;
            font-size: 0.8125rem;
            color: var(--muted);
        }

        .api-note code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.75rem;
            background: #f6f8fa;
            padding: 0.1rem 0.35rem;
            border-radius: 4px;
        }

        .hidden { display: none !important; }
    </style>
</head>
<body>
    <div class="page">
        <header>
            <h1>Task Management API</h1>
            <p>
                Interactive demo for the GitHub Copilot for Laravel course.
                This page calls the same <code>/api/tasks</code> endpoints delegates will build on in Module 3.
                Data is stored in memory — it resets when the server restarts.
            </p>
        </header>

        <div id="message" class="alert hidden" role="status"></div>

        <div class="layout">
            <aside>
                <section class="panel">
                    <h2>Create task</h2>
                    <form id="create-form">
                        <label for="create-title">Title</label>
                        <input id="create-title" name="title" required maxlength="100" placeholder="Write course slides">

                        <label for="create-description">Description</label>
                        <textarea id="create-description" name="description" placeholder="Optional details"></textarea>

                        <div class="row">
                            <div>
                                <label for="create-priority">Priority</label>
                                <select id="create-priority" name="priority">
                                    <option value="Low">Low</option>
                                    <option value="Medium" selected>Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                            <div>
                                <label for="create-owner">Owner ID</label>
                                <input id="create-owner" name="owner_id" type="number" value="1" min="1" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-primary">Create task</button>
                    </form>
                </section>

                <p class="api-note">
                    Delete is intentionally missing from the API — a good PRD-driven exercise in Module 4.
                </p>
            </aside>

            <main class="panel">
                <h2>Tasks</h2>

                <div class="toolbar">
                    <div class="field">
                        <label for="filter-owner">Owner ID</label>
                        <input id="filter-owner" type="number" value="1" min="1">
                    </div>
                    <div class="field">
                        <label for="filter-priority">Priority</label>
                        <select id="filter-priority">
                            <option value="">All priorities</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <button type="button" class="btn-secondary" id="refresh-btn">Refresh</button>
                </div>

                <div id="task-list" class="task-list">
                    <div class="empty-state">Loading tasks…</div>
                </div>

                <section id="edit-section" class="edit-panel hidden">
                    <h2>Edit task <span id="edit-id-label"></span></h2>
                    <form id="edit-form">
                        <label for="edit-title">Title</label>
                        <input id="edit-title" name="title" required maxlength="100">

                        <label for="edit-description">Description</label>
                        <textarea id="edit-description" name="description"></textarea>

                        <div class="row">
                            <div>
                                <label for="edit-priority">Priority</label>
                                <select id="edit-priority" name="priority">
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                            <div>
                                <label for="edit-status">Status</label>
                                <select id="edit-status" name="status">
                                    <option value="Todo">Todo</option>
                                    <option value="InProgress">In progress</option>
                                    <option value="Done">Done</option>
                                </select>
                            </div>
                        </div>

                        <div class="edit-actions">
                            <button type="submit" class="btn-primary btn-small">Save changes</button>
                            <button type="button" class="btn-secondary btn-small" id="cancel-edit">Cancel</button>
                        </div>
                    </form>
                </section>
            </main>
        </div>
    </div>

    <script>
        const apiBase = '/api/tasks';
        let selectedTaskId = null;

        const messageEl = document.getElementById('message');
        const taskListEl = document.getElementById('task-list');
        const editSection = document.getElementById('edit-section');
        const editIdLabel = document.getElementById('edit-id-label');

        function showMessage(text, type = 'info') {
            messageEl.textContent = text;
            messageEl.className = `alert alert-${type}`;
            messageEl.classList.remove('hidden');

            if (type === 'success') {
                window.setTimeout(() => messageEl.classList.add('hidden'), 3500);
            }
        }

        function hideMessage() {
            messageEl.classList.add('hidden');
        }

        function unwrapCollection(payload) {
            if (Array.isArray(payload)) {
                return payload;
            }

            if (payload && Array.isArray(payload.data)) {
                return payload.data;
            }

            return [];
        }

        function unwrapResource(payload) {
            if (payload && payload.data && typeof payload.data === 'object') {
                return payload.data;
            }

            return payload;
        }

        async function apiRequest(url, options = {}) {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    ...(options.headers || {}),
                },
                ...options,
            });

            const text = await response.text();
            const payload = text ? JSON.parse(text) : null;

            if (!response.ok) {
                const errorText = payload?.message
                    || payload?.error
                    || (payload?.errors ? Object.values(payload.errors).flat().join(' ') : null)
                    || `Request failed (${response.status})`;
                throw new Error(errorText);
            }

            return payload;
        }

        function priorityClass(priority) {
            return `badge badge-priority-${priority.toLowerCase()}`;
        }

        function statusClass(status) {
            return `badge badge-status-${status.toLowerCase()}`;
        }

        function formatDate(value) {
            if (!value) {
                return '—';
            }

            return new Date(value).toLocaleString();
        }

        function renderTasks(tasks) {
            if (!tasks.length) {
                taskListEl.innerHTML = '<div class="empty-state">No tasks yet. Create one using the form on the left.</div>';
                return;
            }

            taskListEl.innerHTML = tasks.map(task => `
                <article class="task-card${selectedTaskId === task.id ? ' selected' : ''}" data-id="${task.id}">
                    <div class="task-header">
                        <div>
                            <h3 class="task-title">${escapeHtml(task.title)}</h3>
                            <p class="task-meta">
                                #${task.id} · Owner ${task.owner_id}
                                ${task.description ? ` · ${escapeHtml(task.description)}` : ''}
                            </p>
                            <p class="task-meta">
                                Created ${formatDate(task.created_at)}
                                ${task.completed_at ? ` · Completed ${formatDate(task.completed_at)}` : ''}
                            </p>
                        </div>
                        <div class="badges">
                            <span class="${priorityClass(task.priority)}">${escapeHtml(task.priority)}</span>
                            <span class="${statusClass(task.status)}">${escapeHtml(task.status)}</span>
                        </div>
                    </div>
                    <div class="task-actions">
                        <button type="button" class="btn-secondary btn-small" data-action="edit">Edit</button>
                        <button type="button" class="btn-secondary btn-small" data-action="view">View JSON</button>
                    </div>
                </article>
            `).join('');
        }

        function escapeHtml(value) {
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#39;');
        }

        async function loadTasks() {
            hideMessage();

            const ownerId = document.getElementById('filter-owner').value;
            const priority = document.getElementById('filter-priority').value;
            const params = new URLSearchParams({ owner_id: ownerId });

            if (priority) {
                params.set('priority', priority);
            }

            taskListEl.innerHTML = '<div class="empty-state">Loading tasks…</div>';

            try {
                const payload = await apiRequest(`${apiBase}?${params.toString()}`);
                renderTasks(unwrapCollection(payload));
            } catch (error) {
                taskListEl.innerHTML = '<div class="empty-state">Could not load tasks.</div>';
                showMessage(error.message, 'error');
            }
        }

        async function openEdit(taskId) {
            try {
                const payload = await apiRequest(`${apiBase}/${taskId}`);
                const task = unwrapResource(payload);

                selectedTaskId = task.id;
                editIdLabel.textContent = `#${task.id}`;
                document.getElementById('edit-title').value = task.title;
                document.getElementById('edit-description').value = task.description || '';
                document.getElementById('edit-priority').value = task.priority;
                document.getElementById('edit-status').value = task.status;
                editSection.classList.remove('hidden');
                await loadTasks();
                editSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } catch (error) {
                showMessage(error.message, 'error');
            }
        }

        function closeEdit() {
            selectedTaskId = null;
            editSection.classList.add('hidden');
            loadTasks();
        }

        document.getElementById('create-form').addEventListener('submit', async (event) => {
            event.preventDefault();
            hideMessage();

            const form = event.currentTarget;

            try {
                await apiRequest(apiBase, {
                    method: 'POST',
                    body: JSON.stringify({
                        title: form.title.value.trim(),
                        description: form.description.value.trim() || null,
                        priority: form.priority.value,
                        owner_id: Number(form.owner_id.value),
                    }),
                });

                form.title.value = '';
                form.description.value = '';
                document.getElementById('filter-owner').value = form.owner_id.value;
                showMessage('Task created.', 'success');
                await loadTasks();
            } catch (error) {
                showMessage(error.message, 'error');
            }
        });

        document.getElementById('edit-form').addEventListener('submit', async (event) => {
            event.preventDefault();
            hideMessage();

            if (!selectedTaskId) {
                return;
            }

            try {
                await apiRequest(`${apiBase}/${selectedTaskId}`, {
                    method: 'PATCH',
                    body: JSON.stringify({
                        title: document.getElementById('edit-title').value.trim(),
                        description: document.getElementById('edit-description').value.trim() || null,
                        priority: document.getElementById('edit-priority').value,
                        status: document.getElementById('edit-status').value,
                    }),
                });

                showMessage('Task updated.', 'success');
                await loadTasks();
            } catch (error) {
                showMessage(error.message, 'error');
            }
        });

        document.getElementById('cancel-edit').addEventListener('click', closeEdit);
        document.getElementById('refresh-btn').addEventListener('click', loadTasks);
        document.getElementById('filter-owner').addEventListener('change', loadTasks);
        document.getElementById('filter-priority').addEventListener('change', loadTasks);

        taskListEl.addEventListener('click', async (event) => {
            const button = event.target.closest('button[data-action]');
            if (!button) {
                return;
            }

            const card = button.closest('.task-card');
            const taskId = Number(card.dataset.id);

            if (button.dataset.action === 'edit') {
                await openEdit(taskId);
                return;
            }

            if (button.dataset.action === 'view') {
                try {
                    const payload = await apiRequest(`${apiBase}/${taskId}`);
                    showMessage(JSON.stringify(unwrapResource(payload), null, 2), 'info');
                } catch (error) {
                    showMessage(error.message, 'error');
                }
            }
        });

        loadTasks();
    </script>
</body>
</html>
