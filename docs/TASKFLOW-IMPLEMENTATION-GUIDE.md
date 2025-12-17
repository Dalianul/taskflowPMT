# 🚀 TaskFlow - Complete Implementation Guide for Claude Code

## Project Overview

**Project:** TaskFlow - Project Management Tool (Trello/Asana Clone)
**Purpose:** Upwork Portfolio Project to demonstrate full-stack web development skills

### Tech Stack
- **Backend:** Laravel 11, PHP 8.3, MySQL 8, Redis
- **Frontend:** Next.js 14, React 18, TypeScript, Tailwind CSS
- **Real-time:** Laravel Reverb (WebSockets)
- **Authentication:** Laravel Sanctum
- **State Management:** Zustand + React Query
- **Drag & Drop:** @hello-pangea/dnd

### Project URLs
- **Backend API:** http://taskflow-backend.test
- **Frontend:** http://localhost:3000
- **WebSocket:** ws://localhost:8080
- **phpMyAdmin:** http://localhost:8080/phpmyadmin

### Project Structure
```
D:\ProjectsWebDev\taskflow\
├── backend\          # Laravel 11 API
├── frontend\         # Next.js 14 App
├── docs\             # Documentation
└── README.md
```

---

## Git Workflow

### Branch Naming Convention
```
main                    # Production-ready code
develop                 # Development branch
feature/[phase]-[name]  # Feature branches
bugfix/[description]    # Bug fixes
```

### Before Starting Any Phase
```bash
git checkout develop
git pull origin develop
git checkout -b feature/[branch-name]
```

### After Completing Any Phase
```bash
git add .
git commit -m "feat: [description]"
git push origin feature/[branch-name]
git checkout develop
git merge feature/[branch-name]
git push origin develop
```

---

# 📋 PHASE 1: Backend Foundation

## Branch: `feature/phase1-backend-foundation`

```bash
git checkout -b feature/phase1-backend-foundation
```

---

## Step 1.1: Create Eloquent Models with Relationships

### Instructions for Claude Code: 

```
Create all Eloquent models for TaskFlow project management application. 

Location: D:\ProjectsWebDev\taskflow\backend\app\Models\

Create these models with their relationships:

1. **User. php** (update existing)
   - hasMany: workspaces (as owner)
   - belongsToMany: workspaces (as member through workspace_members)
   - hasMany: tasks (as creator)
   - hasMany: comments
   - hasMany:  activities
   - Add:  name, email, password, avatar (nullable)

2. **Workspace.php**
   - belongsTo: owner (User)
   - belongsToMany: members (Users through workspace_members with role)
   - hasMany: projects
   - hasMany:  labels
   - Add: name, description, slug, color, owner_id

3. **WorkspaceMember.php**
   - belongsTo:  workspace
   - belongsTo: user
   - Add: workspace_id, user_id, role (enum: owner, admin, member, viewer)

4. **Project.php**
   - belongsTo: workspace
   - hasMany: boards
   - Add: workspace_id, name, description, slug, color, status

5. **Board. php**
   - belongsTo: project
   - hasMany:  columns (ordered by position)
   - Add: project_id, name, description, is_default

6. **Column. php**
   - belongsTo: board
   - hasMany: tasks (ordered by position)
   - Add: board_id, name, color, position, task_limit

7. **Task. php**
   - belongsTo: column
   - belongsTo: creator (User)
   - belongsToMany: assignees (Users through task_assignees)
   - belongsToMany: labels (through task_labels)
   - hasMany: comments
   - hasMany:  activities (morphMany)
   - Add:  column_id, created_by, title, description, position, priority, due_date, completed_at

8. **Label. php**
   - belongsTo: workspace
   - belongsToMany: tasks
   - Add: workspace_id, name, color

9. **Comment. php**
   - belongsTo: task
   - belongsTo: user
   - Add:  task_id, user_id, content

10. **Activity. php**
    - belongsTo: user
    - morphTo: subject
    - Add: user_id, subject_type, subject_id, action, changes (json)

Run these commands first:
php artisan make:model Workspace
php artisan make:model WorkspaceMember
php artisan make:model Project
php artisan make:model Board
php artisan make:model Column
php artisan make:model Task
php artisan make: model Label
php artisan make:model Comment
php artisan make:model Activity

Then implement all relationships in each model.
```

---

## Step 1.2: Setup Laravel Sanctum Authentication

### Instructions for Claude Code:

```
Setup Laravel Sanctum authentication for TaskFlow API.

Location: D:\ProjectsWebDev\taskflow\backend\

Tasks: 
1. Sanctum is already installed.  Configure it properly. 

2. Update config/cors.php:
   - Set 'paths' to ['api/*', 'sanctum/csrf-cookie']
   - Set 'allowed_origins' to ['http://localhost:3000']
   - Set 'supports_credentials' to true

3. Update config/sanctum.php:
   - Add 'localhost: 3000' to stateful domains

4. Create app/Http/Controllers/Api/AuthController.php with methods:
   - register(Request $request): Create user, return token
   - login(Request $request): Validate credentials, return token
   - logout(Request $request): Revoke current token
   - me(Request $request): Return authenticated user

5. Create routes in routes/api.php:
   - POST /auth/register
   - POST /auth/login
   - POST /auth/logout (protected)
   - GET /auth/me (protected)

6. Create Form Requests:
   - app/Http/Requests/Auth/RegisterRequest.php
   - app/Http/Requests/Auth/LoginRequest. php

7. Create app/Http/Resources/UserResource.php

Test endpoints with these curl commands:
- Register: POST /api/auth/register {name, email, password, password_confirmation}
- Login: POST /api/auth/login {email, password}
- Me: GET /api/auth/me (with Bearer token)
- Logout: POST /api/auth/logout (with Bearer token)
```

---

## Step 1.3: Create API Controllers

### Instructions for Claude Code:

```
Create all API controllers for TaskFlow. 

Location: D:\ProjectsWebDev\taskflow\backend\app\Http\Controllers\Api\

Create these controllers with full CRUD operations: 

1. **WorkspaceController.php**
   - index(): List user's workspaces (owned + member of)
   - store(): Create workspace, add creator as owner
   - show($workspace): Get workspace with members
   - update($workspace): Update workspace details
   - destroy($workspace): Delete workspace (owner only)
   - inviteMember($workspace): Invite user by email
   - removeMember($workspace, $user): Remove member
   - updateMemberRole($workspace, $user): Change role

2. **ProjectController.php**
   - index($workspace): List projects in workspace
   - store($workspace): Create project with default board
   - show($project): Get project details
   - update($project): Update project
   - destroy($project): Delete project

3. **BoardController.php**
   - index($project): List boards in project
   - store($project): Create board with default columns
   - show($board): Get board with columns and tasks
   - update($board): Update board
   - destroy($board): Delete board

4. **ColumnController.php**
   - store($board): Create column
   - update($column): Update column
   - destroy($column): Delete column (move tasks first)
   - reorder($board): Reorder all columns (receive positions array)

5. **TaskController.php**
   - store($column): Create task
   - show($task): Get task with assignees, labels, comments
   - update($task): Update task details
   - destroy($task): Delete task
   - move($task): Move task to different column/position
   - reorder($column): Reorder tasks in column
   - assignUser($task, $user): Assign user to task
   - unassignUser($task, $user): Remove user from task
   - addLabel($task, $label): Add label to task
   - removeLabel($task, $label): Remove label from task

6. **CommentController.php**
   - index($task): List comments on task
   - store($task): Add comment
   - update($comment): Edit comment (owner only)
   - destroy($comment): Delete comment (owner only)

7. **LabelController.php**
   - index($workspace): List workspace labels
   - store($workspace): Create label
   - update($label): Update label
   - destroy($label): Delete label

8. **ActivityController.php**
   - index($task): List activities for a task
   - workspaceActivities($workspace): Recent workspace activities

All controllers should: 
- Use proper authorization (policies)
- Return JSON responses using Resources
- Handle errors gracefully
- Log activities where appropriate
```

---

## Step 1.4: Define API Routes

### Instructions for Claude Code:

```
Define all API routes for TaskFlow.

Location: D:\ProjectsWebDev\taskflow\backend\routes\api.php

Create these routes:

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController:: class, 'logout']);
    Route::get('/auth/me', [AuthController:: class, 'me']);

    // Workspaces
    Route::apiResource('workspaces', WorkspaceController::class);
    Route::post('/workspaces/{workspace}/invite', [WorkspaceController::class, 'inviteMember']);
    Route::delete('/workspaces/{workspace}/members/{user}', [WorkspaceController::class, 'removeMember']);
    Route::patch('/workspaces/{workspace}/members/{user}/role', [WorkspaceController::class, 'updateMemberRole']);

    // Projects (nested under workspaces)
    Route::apiResource('workspaces. projects', ProjectController:: class)->shallow();

    // Boards (nested under projects)
    Route::apiResource('projects.boards', BoardController::class)->shallow();

    // Columns
    Route::apiResource('boards.columns', ColumnController::class)->shallow();
    Route::post('/boards/{board}/columns/reorder', [ColumnController::class, 'reorder']);

    // Tasks
    Route::apiResource('columns.tasks', TaskController::class)->shallow();
    Route::post('/tasks/{task}/move', [TaskController:: class, 'move']);
    Route::post('/columns/{column}/tasks/reorder', [TaskController::class, 'reorder']);
    Route::post('/tasks/{task}/assignees/{user}', [TaskController::class, 'assignUser']);
    Route::delete('/tasks/{task}/assignees/{user}', [TaskController::class, 'unassignUser']);
    Route::post('/tasks/{task}/labels/{label}', [TaskController::class, 'addLabel']);
    Route::delete('/tasks/{task}/labels/{label}', [TaskController::class, 'removeLabel']);

    // Comments
    Route::apiResource('tasks.comments', CommentController::class)->shallow();

    // Labels
    Route::apiResource('workspaces.labels', LabelController::class)->shallow();

    // Activities
    Route::get('/tasks/{task}/activities', [ActivityController::class, 'index']);
    Route::get('/workspaces/{workspace}/activities', [ActivityController::class, 'workspaceActivities']);
});

Import all controllers at the top of the file. 
```

---

## Step 1.5: Create Form Requests & Validation

### Instructions for Claude Code:

```
Create Form Request classes for validation.

Location: D:\ProjectsWebDev\taskflow\backend\app\Http\Requests\

Create these Form Requests:

1. **Auth/RegisterRequest.php**
   - name: required, string, max: 255
   - email: required, email, unique:users
   - password: required, min:8, confirmed

2. **Auth/LoginRequest.php**
   - email:  required, email
   - password: required

3. **Workspace/StoreWorkspaceRequest.php**
   - name: required, string, max:255
   - description: nullable, string
   - color: nullable, string, hex color

4. **Workspace/UpdateWorkspaceRequest.php**
   - name:  sometimes, string, max: 255
   - description: nullable, string
   - color: nullable, string

5. **Project/StoreProjectRequest. php**
   - name: required, string, max:255
   - description: nullable, string
   - color: nullable, string

6. **Project/UpdateProjectRequest.php**
   - name: sometimes, string, max:255
   - description: nullable, string
   - color: nullable, string
   - status: sometimes, in: active,archived,completed

7. **Board/StoreBoardRequest.php**
   - name: required, string, max:255
   - description: nullable, string

8. **Column/StoreColumnRequest.php**
   - name: required, string, max:255
   - color: nullable, string
   - task_limit: nullable, integer, min:1

9. **Task/StoreTaskRequest.php**
   - title: required, string, max:255
   - description: nullable, string
   - priority: sometimes, in: low,medium,high,urgent
   - due_date: nullable, date

10. **Task/UpdateTaskRequest.php**
    - title: sometimes, string, max:255
    - description: nullable, string
    - priority: sometimes, in: low,medium,high,urgent
    - due_date: nullable, date

11. **Task/MoveTaskRequest.php**
    - column_id: required, exists:columns,id
    - position: required, integer, min:0

12. **Comment/StoreCommentRequest.php**
    - content: required, string

Run:  php artisan make: request [RequestName] for each one. 
```

---

## Step 1.6: Create API Resources

### Instructions for Claude Code:

```
Create API Resource classes for JSON transformation.

Location: D:\ProjectsWebDev\taskflow\backend\app\Http\Resources\

Create these Resources:

1. **UserResource.php**
   - id, name, email, avatar, created_at

2. **WorkspaceResource.php**
   - id, name, description, slug, color, owner_id
   - owner (UserResource)
   - members (UserResource collection with pivot. role)
   - projects_count, members_count

3. **ProjectResource.php**
   - id, workspace_id, name, description, slug, color, status
   - boards_count, tasks_count

4. **BoardResource.php**
   - id, project_id, name, description, is_default
   - columns (ColumnResource collection when loaded)

5. **ColumnResource.php**
   - id, board_id, name, color, position, task_limit
   - tasks (TaskResource collection when loaded)
   - tasks_count

6. **TaskResource.php**
   - id, column_id, title, description, position
   - priority, due_date, completed_at
   - creator (UserResource)
   - assignees (UserResource collection)
   - labels (LabelResource collection)
   - comments_count, created_at

7. **LabelResource.php**
   - id, name, color

8. **CommentResource.php**
   - id, task_id, content, created_at
   - user (UserResource)

9. **ActivityResource.php**
   - id, action, changes, created_at
   - user (UserResource)
   - subject_type, subject_id

Run: php artisan make:resource [ResourceName] for each one. 
```

---

## Step 1.7: Create Policies for Authorization

### Instructions for Claude Code:

```
Create Policy classes for authorization. 

Location: D:\ProjectsWebDev\taskflow\backend\app\Policies\

Create these Policies:

1. **WorkspacePolicy.php**
   - viewAny($user): true (user can list their workspaces)
   - view($user, $workspace): user is member
   - create($user): true
   - update($user, $workspace): user is owner or admin
   - delete($user, $workspace): user is owner
   - invite($user, $workspace): user is owner or admin
   - removeMember($user, $workspace): user is owner or admin

2. **ProjectPolicy.php**
   - viewAny($user, $workspace): user is workspace member
   - view($user, $project): user is workspace member
   - create($user, $workspace): user is owner, admin, or member
   - update($user, $project): user is owner or admin
   - delete($user, $project): user is owner or admin

3. **BoardPolicy.php**
   - Similar to ProjectPolicy, based on workspace membership

4. **TaskPolicy.php**
   - viewAny, view:  workspace member
   - create:  workspace member (not viewer)
   - update: workspace member (not viewer)
   - delete: owner, admin, or task creator

5. **CommentPolicy.php**
   - viewAny, view: workspace member
   - create: workspace member (not viewer)
   - update, delete: comment owner only

Register all policies in AuthServiceProvider. 

Run: php artisan make:policy [PolicyName] --model=[ModelName]
```

---

## Git Commit for Phase 1:

```bash
git add .
git commit -m "feat(backend): complete backend foundation with models, controllers, routes, and auth"
git push origin feature/phase1-backend-foundation
git checkout develop
git merge feature/phase1-backend-foundation
git push origin develop
```

---

# 📋 PHASE 2: Real-time Events with Laravel Reverb

## Branch: `feature/phase2-realtime-events`

```bash
git checkout develop
git checkout -b feature/phase2-realtime-events
```

---

## Step 2.1: Create Broadcast Events

### Instructions for Claude Code:

```
Create broadcast events for real-time updates.

Location: D:\ProjectsWebDev\taskflow\backend\app\Events\

Create these events that implement ShouldBroadcast:

1. **TaskCreated. php**
   - Properties: task (Task model)
   - Channel: PrivateChannel "board. {$this->task->column->board_id}"
   - Broadcast as: 'task.created'
   - Data: TaskResource

2. **TaskUpdated.php**
   - Properties:  task (Task model)
   - Channel:  PrivateChannel "board.{$this->task->column->board_id}"
   - Broadcast as: 'task. updated'
   - Data: TaskResource

3. **TaskMoved.php**
   - Properties: task, fromColumnId, toColumnId
   - Channels: broadcast to both old and new board if different
   - Broadcast as: 'task.moved'
   - Data: task, from_column_id, to_column_id, position

4. **TaskDeleted.php**
   - Properties: taskId, columnId, boardId
   - Channel: PrivateChannel "board.{$boardId}"
   - Broadcast as: 'task.deleted'
   - Data:  task_id, column_id

5. **ColumnCreated.php**
   - Properties: column
   - Channel: PrivateChannel "board.{$this->column->board_id}"
   - Broadcast as: 'column.created'

6. **ColumnUpdated.php**
   - Similar structure

7. **ColumnsReordered.php**
   - Properties:  boardId, columns (array of id => position)
   - Channel: PrivateChannel "board.{$boardId}"
   - Broadcast as:  'columns.reordered'

8. **CommentAdded.php**
   - Properties: comment
   - Channel:  PrivateChannel "task.{$this->comment->task_id}"
   - Broadcast as: 'comment.added'

Run: php artisan make:event [EventName] for each one. 

Make sure each event: 
- Implements ShouldBroadcast
- Has proper broadcastOn() method
- Has broadcastAs() method
- Has broadcastWith() method for data
```

---

## Step 2.2: Configure Broadcast Channels

### Instructions for Claude Code: 

```
Configure broadcast channel authorization.

Location: D:\ProjectsWebDev\taskflow\backend\routes\channels.php

Add these channel authorizations:

// Board channel - user must be member of workspace that owns the board
Broadcast::channel('board.{boardId}', function ($user, $boardId) {
    $board = \App\Models\Board:: find($boardId);
    if (!$board) return false;
    
    return $board->project->workspace->members()
        ->where('user_id', $user->id)
        ->exists();
});

// Task channel - for task-specific updates like comments
Broadcast::channel('task.{taskId}', function ($user, $taskId) {
    $task = \App\Models\Task::find($taskId);
    if (!$task) return false;
    
    return $task->column->board->project->workspace->members()
        ->where('user_id', $user->id)
        ->exists();
});

// Workspace channel - for workspace-wide notifications
Broadcast::channel('workspace.{workspaceId}', function ($user, $workspaceId) {
    return \App\Models\WorkspaceMember::where('workspace_id', $workspaceId)
        ->where('user_id', $user->id)
        ->exists();
});
```

---

## Step 2.3: Dispatch Events in Controllers

### Instructions for Claude Code:

```
Update controllers to dispatch broadcast events. 

Modify TaskController. php: 

1. In store() method - after creating task: 
   event(new TaskCreated($task->load(['creator', 'assignees', 'labels'])));

2. In update() method - after updating task:
   event(new TaskUpdated($task->fresh()->load(['creator', 'assignees', 'labels'])));

3. In move() method - after moving task:
   event(new TaskMoved($task, $originalColumnId, $task->column_id));

4. In destroy() method - before deleting: 
   $boardId = $task->column->board_id;
   $columnId = $task->column_id;
   $taskId = $task->id;
   $task->delete();
   event(new TaskDeleted($taskId, $columnId, $boardId));

Modify ColumnController.php:

1. In store() - dispatch ColumnCreated
2. In update() - dispatch ColumnUpdated
3. In reorder() - dispatch ColumnsReordered

Modify CommentController.php:

1. In store() - dispatch CommentAdded
```

---

## Git Commit for Phase 2:

```bash
git add . 
git commit -m "feat(realtime): add Laravel Reverb broadcast events for tasks, columns, comments"
git push origin feature/phase2-realtime-events
git checkout develop
git merge feature/phase2-realtime-events
git push origin develop
```

---

# 📋 PHASE 3: Frontend Foundation

## Branch: `feature/phase3-frontend-foundation`

```bash
git checkout develop
git checkout -b feature/phase3-frontend-foundation
```

---

## Step 3.1: Setup Core Infrastructure

### Instructions for Claude Code:

```
Setup core frontend infrastructure for TaskFlow.

Location: D:\ProjectsWebDev\taskflow\frontend\

1. **Create src/lib/api.ts** - Axios client: 
   - Base URL: process.env.NEXT_PUBLIC_API_URL
   - withCredentials: true
   - Request interceptor: add Bearer token from localStorage
   - Response interceptor: handle 401 errors, redirect to login

2. **Create src/lib/echo.ts** - Laravel Echo setup:
   - Import Echo and Pusher
   - Configure for Reverb: 
     - broadcaster: 'reverb'
     - key:  NEXT_PUBLIC_REVERB_APP_KEY
     - wsHost:  NEXT_PUBLIC_REVERB_HOST
     - wsPort: NEXT_PUBLIC_REVERB_PORT
   - Export initializeEcho() function
   - Export getEcho() function

3. **Create src/lib/utils.ts**: 
   - cn() function using clsx and tailwind-merge
   - formatDate() function using date-fns
   - formatRelativeTime() function

4. **Create src/providers/QueryProvider.tsx**:
   - Setup React Query with QueryClient
   - Configure default options (staleTime, cacheTime)
   - Wrap children with QueryClientProvider

5. **Create src/providers/ToastProvider.tsx**: 
   - Setup react-hot-toast Toaster component

6. **Update src/app/layout.tsx**: 
   - Wrap with QueryProvider
   - Add ToastProvider

7. **Create src/types/index.ts**:
   - User, Workspace, Project, Board, Column, Task, Label, Comment, Activity interfaces
   - API response types
   - Pagination types
```

---

## Step 3.2: Create UI Components

### Instructions for Claude Code:

```
Create reusable UI components for TaskFlow.

Location: D:\ProjectsWebDev\taskflow\frontend\src\components\ui\

Create these components with TypeScript and Tailwind CSS:

1. **Button.tsx**
   - Variants: primary, secondary, danger, ghost, outline
   - Sizes: sm, md, lg
   - Props: isLoading, leftIcon, rightIcon, disabled
   - Use forwardRef for ref forwarding

2. **Input.tsx**
   - Props: label, error, helperText
   - Support for different types (text, email, password)
   - Focus states and error styling

3. **Textarea.tsx**
   - Similar to Input but for multiline text
   - Auto-resize option

4. **Select.tsx**
   - Custom styled select dropdown
   - Support for options array
   - Placeholder support

5. **Modal.tsx**
   - Use @headlessui/react Dialog
   - Props: isOpen, onClose, title, size (sm, md, lg, xl)
   - Backdrop click to close
   - Escape key to close
   - Focus trap

6. **Dropdown.tsx**
   - Use @headlessui/react Menu
   - Support for items array with icons
   - Dividers support

7. **Avatar.tsx**
   - Show image or initials
   - Sizes: xs, sm, md, lg
   - Online indicator option

8. **Badge.tsx**
   - Variants: default, success, warning, danger
   - Custom color support (for labels)
   - Sizes: sm, md

9. **Card. tsx**
   - Container with padding, shadow, rounded corners
   - Header and Footer slots

10. **Spinner.tsx**
    - Loading spinner with sizes
    - Optional label

11. **EmptyState.tsx**
    - Icon, title, description, action button
    - For empty lists

12. **Tooltip.tsx**
    - Hover tooltip using @headlessui/react or custom
    - Positions: top, bottom, left, right

Create index.ts to export all components. 
```

---

## Step 3.3: Create Layout Components

### Instructions for Claude Code:

```
Create layout components for TaskFlow dashboard.

Location: D:\ProjectsWebDev\taskflow\frontend\src\components\layout\

1. **Sidebar.tsx**
   - Fixed left sidebar (w-64)
   - Logo at top
   - Navigation links: 
     - Dashboard
     - My Tasks
     - Workspaces (expandable with workspace list)
   - User menu at bottom
   - Collapsible on mobile

2. **Header.tsx**
   - Sticky top header
   - Breadcrumbs
   - Search bar (global search)
   - Notifications dropdown
   - User avatar dropdown (profile, settings, logout)

3. **DashboardLayout.tsx**
   - Combines Sidebar + Header + main content area
   - Responsive:  sidebar collapses on mobile
   - Main content has proper padding

4. **AuthLayout.tsx**
   - Centered card layout for login/register
   - Background gradient or pattern
   - Logo at top

5. **WorkspaceSwitcher.tsx**
   - Dropdown to switch between workspaces
   - Shows current workspace
   - "Create new workspace" option

6. **Breadcrumbs.tsx**
   - Dynamic breadcrumbs based on route
   - Workspace > Project > Board format

Create these in proper files with TypeScript.
```

---

## Step 3.4: Create Store (Zustand)

### Instructions for Claude Code: 

```
Create Zustand stores for state management.

Location: D:\ProjectsWebDev\taskflow\frontend\src\stores\

1. **authStore.ts**
   - State: user, token, isAuthenticated, isLoading
   - Actions: 
     - setAuth(user, token)
     - logout()
     - updateUser(user)
   - Persist to localStorage

2. **workspaceStore. ts**
   - State: currentWorkspace, workspaces
   - Actions: 
     - setCurrentWorkspace(workspace)
     - setWorkspaces(workspaces)
     - addWorkspace(workspace)
     - updateWorkspace(id, data)
     - removeWorkspace(id)

3. **boardStore.ts**
   - State: currentBoard, columns (normalized)
   - Actions:
     - setBoard(board)
     - updateColumn(columnId, data)
     - reorderColumns(columnIds)
     - addTask(columnId, task)
     - updateTask(taskId, data)
     - moveTask(taskId, fromColumnId, toColumnId, position)
     - removeTask(taskId)

4. **uiStore.ts**
   - State:  isSidebarOpen, isTaskModalOpen, selectedTaskId
   - Actions:
     - toggleSidebar()
     - openTaskModal(taskId)
     - closeTaskModal()
```

---

## Step 3.5: Create API Hooks (React Query)

### Instructions for Claude Code: 

```
Create React Query hooks for API calls.

Location: D:\ProjectsWebDev\taskflow\frontend\src\hooks\

1. **useAuth.ts**
   - useLogin(): useMutation for login
   - useRegister(): useMutation for register
   - useLogout(): useMutation for logout
   - useMe(): useQuery for current user

2. **useWorkspaces.ts**
   - useWorkspaces(): useQuery list workspaces
   - useWorkspace(id): useQuery single workspace
   - useCreateWorkspace(): useMutation
   - useUpdateWorkspace(): useMutation
   - useDeleteWorkspace(): useMutation
   - useInviteMember(): useMutation

3. **useProjects.ts**
   - useProjects(workspaceId): useQuery
   - useProject(id): useQuery
   - useCreateProject(): useMutation
   - useUpdateProject(): useMutation
   - useDeleteProject(): useMutation

4. **useBoards.ts**
   - useBoard(id): useQuery with columns and tasks
   - useCreateBoard(): useMutation
   - useUpdateBoard(): useMutation

5. **useTasks.ts**
   - useTask(id): useQuery single task with details
   - useCreateTask(): useMutation
   - useUpdateTask(): useMutation
   - useMoveTask(): useMutation
   - useDeleteTask(): useMutation
   - useAssignUser(): useMutation
   - useUnassignUser(): useMutation

6. **useComments.ts**
   - useComments(taskId): useQuery
   - useCreateComment(): useMutation
   - useDeleteComment(): useMutation

7. **useRealtime.ts**
   - useBoardChannel(boardId): subscribe to board events
   - Handle task. created, task.updated, task.moved, task.deleted
   - Update React Query cache on events

All hooks should: 
- Handle loading and error states
- Invalidate related queries on mutations
- Show toast notifications on success/error
```

---

## Git Commit for Phase 3:

```bash
git add . 
git commit -m "feat(frontend): setup core infrastructure, UI components, layouts, stores, and API hooks"
git push origin feature/phase3-frontend-foundation
git checkout develop
git merge feature/phase3-frontend-foundation
git push origin develop
```

---

# 📋 PHASE 4: Authentication Pages

## Branch: `feature/phase4-authentication`

```bash
git checkout develop
git checkout -b feature/phase4-authentication
```

---

## Step 4.1: Create Authentication Pages

### Instructions for Claude Code:

```
Create authentication pages for TaskFlow.

Location: D:\ProjectsWebDev\taskflow\frontend\src\app\

1. **Create (auth) route group:**
   - src/app/(auth)/layout.tsx - Use AuthLayout
   - src/app/(auth)/login/page.tsx
   - src/app/(auth)/register/page.tsx

2. **Login Page (login/page.tsx):**
   - Form with email and password fields
   - "Remember me" checkbox
   - Submit button with loading state
   - Link to register page
   - Link to forgot password (optional)
   - Use react-hook-form with zod validation
   - Call useLogin mutation
   - On success:  store token, redirect to dashboard
   - Show error toast on failure

3. **Register Page (register/page.tsx):**
   - Form with name, email, password, confirm password
   - Submit button with loading state
   - Link to login page
   - Use react-hook-form with zod validation
   - Call useRegister mutation
   - On success: store token, redirect to dashboard

4. **Create middleware for auth protection:**
   - src/middleware.ts
   - Check for auth token
   - Redirect to login if not authenticated
   - Redirect to dashboard if authenticated and on auth pages
   - Protect /dashboard/* routes
```

---

## Step 4.2: Create Auth Guard Component

### Instructions for Claude Code:

```
Create authentication guard for protected routes.

Location: D:\ProjectsWebDev\taskflow\frontend\src\components\

1. **AuthGuard.tsx**
   - Check if user is authenticated
   - Show loading spinner while checking
   - Redirect to login if not authenticated
   - Render children if authenticated

2. **GuestGuard.tsx**
   - Opposite of AuthGuard
   - Redirect to dashboard if already authenticated
   - For login/register pages

3. **Update (auth)/layout.tsx:**
   - Wrap with GuestGuard

4. **Create (dashboard) route group:**
   - src/app/(dashboard)/layout.tsx
   - Use DashboardLayout
   - Wrap with AuthGuard

5. **Create dashboard home page:**
   - src/app/(dashboard)/page.tsx
   - Simple welcome message for now
   - Will add dashboard content in Phase 7
```

---

## Git Commit for Phase 4:

```bash
git add . 
git commit -m "feat(auth): add login, register pages with auth guards and protected routes"
git push origin feature/phase4-authentication
git checkout develop
git merge feature/phase4-authentication
git push origin develop
```

---

# 📋 PHASE 5: Workspace & Project Management

## Branch: `feature/phase5-workspaces-projects`

```bash
git checkout develop
git checkout -b feature/phase5-workspaces-projects
```

---

## Step 5.1: Workspace Pages

### Instructions for Claude Code:

```
Create workspace management pages.

Location: D:\ProjectsWebDev\taskflow\frontend\src\app\(dashboard)\

1. **Workspaces List Page:**
   - src/app/(dashboard)/workspaces/page. tsx
   - Grid of workspace cards
   - Each card shows: name, color, members count, projects count
   - Click to navigate to workspace
   - "Create Workspace" button

2. **Create Workspace Modal:**
   - src/components/workspaces/CreateWorkspaceModal.tsx
   - Form:  name, description, color picker
   - Submit creates workspace
   - Close on success

3. **Workspace Detail Page:**
   - src/app/(dashboard)/workspaces/[workspaceId]/page.tsx
   - Header with workspace name, edit button
   - Tabs: Projects, Members, Settings
   - Projects grid (default tab)

4. **Workspace Members Tab:**
   - src/components/workspaces/WorkspaceMembers.tsx
   - List of members with role badges
   - Invite member button
   - Remove member button (for admins)
   - Change role dropdown (for admins)

5. **Invite Member Modal:**
   - src/components/workspaces/InviteMemberModal.tsx
   - Email input field
   - Role selector (member, admin)
   - Send invitation

6. **Workspace Settings Tab:**
   - src/components/workspaces/WorkspaceSettings. tsx
   - Edit name, description, color
   - Delete workspace (with confirmation)
```

---

## Step 5.2: Project Pages

### Instructions for Claude Code:

```
Create project management pages. 

Location: D:\ProjectsWebDev\taskflow\frontend\

1. **Projects List (within workspace page):**
   - src/components/projects/ProjectsGrid.tsx
   - Grid of project cards
   - Each card:  name, color, status, boards count
   - Click to navigate to project

2. **Create Project Modal:**
   - src/components/projects/CreateProjectModal. tsx
   - Form: name, description, color picker
   - Creates project with default board

3. **Project Detail Page:**
   - src/app/(dashboard)/workspaces/[workspaceId]/projects/[projectId]/page.tsx
   - Header with project name
   - Boards list/grid
   - Click board to open Kanban view

4. **Create Board Modal:**
   - src/components/boards/CreateBoardModal.tsx
   - Form: name, description
   - Option to create default columns (To Do, In Progress, Done)

5. **Update Sidebar:**
   - Show workspaces list
   - Expandable to show projects
   - Highlight current workspace/project
```

---

## Git Commit for Phase 5:

```bash
git add . 
git commit -m "feat(workspaces): add workspace and project management with CRUD operations"
git push origin feature/phase5-workspaces-projects
git checkout develop
git merge feature/phase5-workspaces-projects
git push origin develop
```

---

# 📋 PHASE 6: Kanban Board (Core Feature)

## Branch: `feature/phase6-kanban-board`

```bash
git checkout develop
git checkout -b feature/phase6-kanban-board
```

---

## Step 6.1: Kanban Board Components

### Instructions for Claude Code:

```
Create Kanban board components with drag and drop.

Location: D:\ProjectsWebDev\taskflow\frontend\src\components\boards\

1. **KanbanBoard.tsx** (Main container):
   - Fetch board data with useBoard(boardId)
   - Setup DragDropContext from @hello-pangea/dnd
   - Render columns horizontally (flex, overflow-x-auto)
   - Handle onDragEnd for reordering
   - "Add Column" button at end

2. **Column.tsx** (Droppable column):
   - Droppable wrapper from @hello-pangea/dnd
   - Column header with name, color indicator, task count
   - Column menu (edit, delete)
   - Tasks list (Draggable items)
   - "Add Task" button at bottom
   - Column limit indicator if set

3. **TaskCard.tsx** (Draggable task):
   - Draggable wrapper from @hello-pangea/dnd
   - Card showing: 
     - Title
     - Priority badge (color coded)
     - Due date (with overdue styling)
     - Assignee avatars (stacked)
     - Labels (color dots or badges)
     - Comments count icon
     - Attachments count icon
   - Click to open TaskModal
   - Hover effects

4. **AddColumnForm.tsx**:
   - Inline form or modal
   - Name input, color picker
   - Submit creates column at end

5. **AddTaskForm.tsx**:
   - Inline form at bottom of column
   - Quick add:  just title
   - Enter to submit, Escape to cancel
   - Option to open full modal for details
```

---

## Step 6.2: Drag & Drop Implementation

### Instructions for Claude Code: 

```
Implement drag and drop logic for Kanban board.

Location: D:\ProjectsWebDev\taskflow\frontend\src\components\boards\

1. **KanbanBoard.tsx - onDragEnd handler:**
   
   Handle three scenarios:
   
   a) Task moved within same column:
      - Update task positions locally (optimistic)
      - Call reorderTasks API
      - Revert on error
   
   b) Task moved to different column:
      - Remove from source column (optimistic)
      - Add to destination column at position (optimistic)
      - Call moveTask API with new column_id and position
      - Revert on error
   
   c) Column reordered:
      - Update column positions locally (optimistic)
      - Call reorderColumns API
      - Revert on error

2. **Create helper functions:**
   - reorderList(list, startIndex, endIndex): Reorder items
   - moveItem(source, destination, sourceIndex, destIndex): Move between lists

3. **Optimistic Updates:**
   - Update Zustand store immediately
   - Make API call
   - On error:  revert store, show toast
   - On success:  invalidate queries to sync

4. **Visual Feedback:**
   - Dragging card has shadow/elevation
   - Drop zone highlights when dragging over
   - Placeholder shows where item will land
```

---

## Step 6.3: Task Modal (Detail View)

### Instructions for Claude Code: 

```
Create task detail modal for viewing and editing tasks. 

Location: D:\ProjectsWebDev\taskflow\frontend\src\components\tasks\

1. **TaskModal.tsx** (Main modal):
   - Large modal (max-w-4xl)
   - Two columns layout:
     - Left (70%): Title, Description, Comments
     - Right (30%): Metadata sidebar
   - Fetch task data with useTask(taskId)
   - Close with X button or Escape

2. **Left Column Components:**

   a) **TaskTitle.tsx**: 
      - Inline editable title
      - Click to edit, blur to save
      - Auto-save on change

   b) **TaskDescription.tsx**: 
      - Rich text editor or markdown
      - Edit mode toggle
      - Save button when editing

   c) **TaskComments. tsx**:
      - List of comments with user avatar, name, time
      - Add comment form at bottom
      - Delete button on own comments

3. **Right Column (Sidebar) Components:**

   a) **TaskAssignees.tsx**:
      - List of assigned users (avatars + names)
      - Add assignee dropdown (workspace members)
      - Remove assignee X button

   b) **TaskLabels. tsx**:
      - Current labels as colored badges
      - Add label dropdown (workspace labels)
      - Remove label X button
      - Create new label option

   c) **TaskPriority.tsx**:
      - Priority dropdown (low, medium, high, urgent)
      - Color coded options

   d) **TaskDueDate.tsx**:
      - Date picker
      - Clear date option
      - Overdue indicator

   e) **TaskActions.tsx**:
      - Move to column dropdown
      - Copy task
      - Delete task (with confirmation)

4. **TaskActivity.tsx**: 
   - Timeline of task activities
   - "User moved task from X to Y"
   - "User added label X"
   - Show timestamps
```

---

## Step 6.4: Real-time Updates

### Instructions for Claude Code: 

```
Connect Kanban board to Laravel Reverb for real-time updates.

Location: D:\ProjectsWebDev\taskflow\frontend\src\

1. **Create hooks/useRealtimeBoard.ts:**
   
   - Subscribe to board channel on mount
   - Listen for events:
     - 'task.created':  Add task to column
     - 'task.updated': Update task in column
     - 'task. moved': Move task between columns
     - 'task.deleted':  Remove task from column
     - 'column. created': Add column to board
     - 'column.updated':  Update column
     - 'columns.reordered':  Reorder columns
   
   - Update React Query cache or Zustand store
   - Unsubscribe on unmount

2. **Update KanbanBoard.tsx:**
   - Call useRealtimeBoard(boardId)
   - Events automatically update the UI

3. **Prevent duplicate updates:**
   - Track pending operations
   - Ignore events for own actions
   - Use event timestamp or unique ID

4. **Show real-time indicators:**
   - "User X is viewing this board" (optional)
   - Flash animation when task updates
   - Toast for significant changes

5. **Handle reconnection:**
   - Detect WebSocket disconnect
   - Show connection status indicator
   - Auto-reconnect
   - Refetch data on reconnect
```

---

## Step 6.5: Board Page

### Instructions for Claude Code:

```
Create the board page that hosts the Kanban board.

Location: D:\ProjectsWebDev\taskflow\frontend\src\app\(dashboard)\

1. **Board Page:**
   - Path: /workspaces/[workspaceId]/projects/[projectId]/boards/[boardId]
   - src/app/(dashboard)/workspaces/[workspaceId]/projects/[projectId]/boards/[boardId]/page.tsx
   
   Components:
   - Board header:  name, project name (breadcrumb)
   - Board menu: settings, delete
   - Filter bar: by assignee, priority, label
   - KanbanBoard component (full width)

2. **Board Settings Modal:**
   - Edit board name
   - Delete board option

3. **Board Filters:**
   - Filter tasks without hiding columns
   - Dim or hide non-matching tasks
   - Clear filters button
```

---

## Git Commit for Phase 6:

```bash
git add . 
git commit -m "feat(kanban): implement full Kanban board with drag-drop, task modal, and real-time updates"
git push origin feature/phase6-kanban-board
git checkout develop
git merge feature/phase6-kanban-board
git push origin develop
```

---

# 📋 PHASE 7: Dashboard & Statistics

## Branch: `feature/phase7-dashboard`

```bash
git checkout develop
git checkout -b feature/phase7-dashboard
```

---

## Step 7.1: Dashboard Page

### Instructions for Claude Code:

```
Create the main dashboard page with statistics.

Location: D:\ProjectsWebDev\taskflow\frontend\src\

1. **Dashboard Page:**
   - src/app/(dashboard)/page.tsx
   - Welcome message with user name
   - Grid of stat cards
   - Charts section
   - Recent activity feed
   - My tasks section

2. **Dashboard API Endpoint (Backend):**
   - Create DashboardController in Laravel
   - GET /api/dashboard
   - Returns: 
     - total_tasks, completed_tasks, overdue_tasks
     - tasks_by_priority:  {low: X, medium: X, high: X, urgent: X}
     - tasks_by_status: {todo: X, in_progress:  X, done: X}
     - recent_activities (last 10)
     - my_tasks (assigned to user, not completed, limit 5)
     - upcoming_due (next 7 days)

3. **Stat Cards Component:**
   - src/components/dashboard/StatCard.tsx
   - Icon, title, value, change indicator
   - Cards for: 
     - Total Tasks
     - Completed This Week
     - Overdue Tasks (red if > 0)
     - Active Projects

4. **Charts Components:**
   - src/components/dashboard/TasksByPriorityChart.tsx
     - Pie or donut chart
     - Using recharts library
   
   - src/components/dashboard/TasksCompletedChart.tsx
     - Bar chart showing last 7 days
     - Tasks completed per day

5. **Recent Activity Feed:**
   - src/components/dashboard/ActivityFeed.tsx
   - List of recent activities
   - User avatar, action description, timestamp
   - Click to navigate to task

6. **My Tasks Widget:**
   - src/components/dashboard/MyTasksWidget. tsx
   - List of tasks assigned to current user
   - Priority indicator, due date
   - Quick actions:  mark complete, open task
   - "View All" link to full task list
```

---

## Git Commit for Phase 7:

```bash
git add . 
git commit -m "feat(dashboard): add dashboard with statistics, charts, activity feed, and my tasks"
git push origin feature/phase7-dashboard
git checkout develop
git merge feature/phase7-dashboard
git push origin develop
```

---

# 📋 PHASE 8: Search & Filters

## Branch: `feature/phase8-search-filters`

```bash
git checkout develop
git checkout -b feature/phase8-search-filters
```

---

## Step 8.1: Global Search

### Instructions for Claude Code:

```
Implement global search functionality. 

Location: D:\ProjectsWebDev\taskflow\frontend\src\

1. **Backend Search Endpoint:**
   - Create SearchController in Laravel
   - GET /api/search? q={query}
   - Search across: 
     - Tasks (title, description)
     - Projects (name)
     - Workspaces (name)
   - Return grouped results with type indicator
   - Limit 5 per type

2. **Search Component:**
   - src/components/search/GlobalSearch.tsx
   - Search input in header
   - Keyboard shortcut (Cmd+K or Ctrl+K)
   - Dropdown results as you type
   - Debounced API calls (300ms)
   - Loading state
   - Group results by type
   - Click to navigate

3. **Search Results Page (optional):**
   - src/app/(dashboard)/search/page.tsx
   - Full search results
   - Filters by type
   - Pagination
```

---

## Step 8.2: Board Filters

### Instructions for Claude Code:

```
Implement task filtering on Kanban board. 

Location: D:\ProjectsWebDev\taskflow\frontend\src\

1. **Filter Bar Component:**
   - src/components/boards/FilterBar.tsx
   - Position: above Kanban board
   - Filters: 
     - Assignee (multi-select dropdown)
     - Priority (multi-select)
     - Labels (multi-select)
     - Due date (overdue, today, this week, no date)
   - Clear all filters button
   - Show active filter count

2. **Filter State:**
   - Add to boardStore or local state
   - filters:  { assignees: [], priorities: [], labels: [], dueDate: null }

3. **Apply Filters:**
   - Filter tasks client-side (data already loaded)
   - Or filter via API (better for large boards)
   - Tasks not matching:  hide or dim (opacity)
   - Show "No tasks match filters" if empty

4. **Save Filter Preferences:**
   - Optional: save to localStorage per board
   - Restore on board load
```

---

## Git Commit for Phase 8:

```bash
git add . 
git commit -m "feat(search): add global search and board filters"
git push origin feature/phase8-search-filters
git checkout develop
git merge feature/phase8-search-filters
git push origin develop
```

---

# 📋 PHASE 9: Polish & UX Improvements

## Branch:  `feature/phase9-polish-ux`

```bash
git checkout develop
git checkout -b feature/phase9-polish-ux
```

---

## Step 9.1: Loading States & Skeletons

### Instructions for Claude Code: 

```
Add loading states and skeleton loaders throughout the app.

1. **Create Skeleton Components:**
   - src/components/ui/Skeleton.tsx (base skeleton)
   - src/components/skeletons/TaskCardSkeleton.tsx
   - src/components/skeletons/ColumnSkeleton. tsx
   - src/components/skeletons/ProjectCardSkeleton.tsx
   - src/components/skeletons/WorkspaceCardSkeleton.tsx

2. **Apply Skeletons:**
   - Show while data is loading
   - Match approximate size of real content
   - Animate with pulse effect

3. **Page Loading:**
   - Full page loader for initial app load
   - Preserve layout, show skeletons in content areas
```

---

## Step 9.2: Empty States

### Instructions for Claude Code:

```
Add empty state components for better UX. 

1. **Create Empty State Variations:**
   - No workspaces:  Illustration + "Create your first workspace"
   - No projects: "Create your first project"
   - No tasks in column: "Drop a task here" or "Add a task"
   - No search results: "No results found"
   - No assigned tasks: "You're all caught up!"

2. **Apply to all list views:**
   - Workspaces list
   - Projects grid
   - Kanban columns
   - Comments section
   - Activity feed
```

---

## Step 9.3: Error Handling

### Instructions for Claude Code:

```
Implement comprehensive error handling. 

1. **API Error Handling:**
   - Global error interceptor in axios
   - Show toast for network errors
   - Show specific message for validation errors
   - Redirect on 401/403

2. **Error Boundary:**
   - src/components/ErrorBoundary.tsx
   - Catch React errors
   - Show friendly error message
   - "Retry" button
   - Log errors (console or service)

3. **Form Errors:**
   - Display validation errors under inputs
   - Server-side validation error mapping
   - Clear errors on input change
```

---

## Step 9.4: Toast Notifications

### Instructions for Claude Code: 

```
Add toast notifications for all actions.

1. **Success Toasts:**
   - "Workspace created successfully"
   - "Task moved to [Column]"
   - "Changes saved"

2. **Error Toasts:**
   - "Failed to save changes.  Please try again."
   - "You don't have permission to do that"

3. **Info Toasts:**
   - "Connecting to real-time updates..."
   - "You've been assigned to a task"

4. **Toast Configuration:**
   - Position: top-right or bottom-right
   - Auto-dismiss after 3-5 seconds
   - Dismissable with X button
   - Stack multiple toasts
```

---

## Step 9.5: Mobile Responsiveness

### Instructions for Claude Code: 

```
Make the app responsive for mobile devices. 

1. **Sidebar:**
   - Collapse to hamburger menu on mobile
   - Full-screen overlay when open
   - Close on navigation

2. **Kanban Board:**
   - Horizontal scroll on mobile
   - Single column view option
   - Touch-friendly drag & drop

3. **Task Modal:**
   - Full screen on mobile
   - Stack columns vertically

4. **Forms:**
   - Full width inputs
   - Larger touch targets
   - Bottom sheet modals on mobile

5. **Testing:**
   - Test on Chrome DevTools mobile view
   - Common breakpoints: 640px, 768px, 1024px
```

---

## Git Commit for Phase 9:

```bash
git add . 
git commit -m "feat(ux): add loading states, empty states, error handling, and mobile responsiveness"
git push origin feature/phase9-polish-ux
git checkout develop
git merge feature/phase9-polish-ux
git push origin develop
```

---

# 📋 PHASE 10: Testing & Documentation

## Branch: `feature/phase10-testing-docs`

```bash
git checkout develop
git checkout -b feature/phase10-testing-docs
```

---

## Step 10.1: API Testing

### Instructions for Claude Code:

```
Create API testing documentation and verify all endpoints.

1. **Create docs/api-testing.md:**
   - List all endpoints with example requests
   - Include authorization headers
   - Show request/response bodies

2. **Test with Postman/Insomnia:**
   - Import or create collection
   - Test all CRUD operations
   - Test authorization (protected routes)
   - Test validation (invalid inputs)
   - Test edge cases

3. **Create seed data:**
   - php artisan make:seeder DatabaseSeeder
   - Create test user, workspace, project, board, columns, tasks
   - Make it easy to demo the app

4. **Run:  php artisan db:seed**
```

---

## Step 10.2: Documentation

### Instructions for Claude Code:

```
Create comprehensive documentation for the project.

1. **README.md** (main):
   - Project title and description
   - Features list with icons
   - Screenshots (4-5 key screens)
   - Tech stack badges
   - Quick start guide
   - Environment variables
   - API documentation link
   - Contributing guidelines
   - License

2. **docs/setup. md:**
   - Prerequisites
   - Step-by-step installation
   - Backend setup
   - Frontend setup
   - Database setup
   - Running the app

3. **docs/api.md:**
   - All endpoints documented
   - Authentication flow
   - Request/response examples

4. **Create demo GIF:**
   - Record key user flows
   - 30-60 seconds
   - Show:  login, create workspace, kanban drag&drop
   - Use ScreenToGif or similar
```

---

## Git Commit for Phase 10:

```bash
git add . 
git commit -m "docs:  add comprehensive documentation, API docs, and demo content"
git push origin feature/phase10-testing-docs
git checkout develop
git merge feature/phase10-testing-docs
git push origin develop
```

---

# 📋 PHASE 11: Deployment

## Branch: `feature/phase11-deployment`

```bash
git checkout develop
git checkout -b feature/phase11-deployment
```

---

## Step 11.1:  Prepare for Production

### Instructions for Claude Code:

```
Prepare both backend and frontend for production deployment.

**Backend (Laravel):**

1. Update .env. example with all required variables

2. Optimize Laravel: 
   - php artisan config:cache
   - php artisan route:cache
   - php artisan view:cache
   - php artisan optimize

3. Security checklist:
   - APP_DEBUG=false
   - APP_ENV=production
   - Proper CORS settings
   - Rate limiting on API

4. Create production . env template

**Frontend (Next.js):**

1. Update .env.example

2. Build for production:
   - npm run build
   - Test with npm start

3. Check for: 
   - No console. log in production
   - Environment variables properly set
   - API URL pointing to production backend
```

---

## Step 11.2: Deploy Backend

### Instructions for Claude Code:

```
Deploy Laravel backend to Railway, Render, or similar.

**Option A: Railway**
1. Create Railway account
2. Connect GitHub repository
3. Create new project from repo
4. Add MySQL database
5. Add Redis database
6. Set environment variables
7. Deploy

**Option B:  Render**
1. Create Render account
2. Create Web Service from repo
3. Set build command:  composer install
4. Set start command: php artisan serve --host=0.0.0.0 --port=$PORT
5. Add environment variables
6. Create MySQL database (or use PlanetScale)
7. Deploy

**Environment Variables to Set:**
- APP_KEY
- APP_URL
- DB_* credentials
- REDIS_* credentials
- REVERB_* settings

**Post-deployment:**
- Run migrations:  php artisan migrate
- Run seeders if needed
- Test API endpoints
```

---

## Step 11.3: Deploy Frontend

### Instructions for Claude Code: 

```
Deploy Next.js frontend to Vercel. 

1. Create Vercel account
2. Import GitHub repository
3. Framework preset: Next.js (auto-detected)
4. Set environment variables: 
   - NEXT_PUBLIC_API_URL=https://your-backend-url. com/api
   - NEXT_PUBLIC_REVERB_*
5. Deploy

**Post-deployment:**
- Test all pages
- Test API connection
- Test real-time updates
- Check mobile responsiveness

**Custom Domain (optional):**
- Add custom domain in Vercel
- Update DNS records
- Wait for SSL certificate
```

---

## Step 11.4: Final GitHub Preparation

### Instructions for Claude Code:

```
Prepare GitHub repository for public showcase.

1. **Clean up:**
   - Remove sensitive data from commits
   - Check . gitignore is complete
   - Remove debug code

2. **Update README:**
   - Add live demo link
   - Add deployment badges
   - Final screenshots

3. **Add GitHub topics:**
   - laravel, nextjs, react, typescript
   - tailwindcss, mysql, redis
   - project-management, kanban
   - real-time, websockets

4. **Create releases:**
   - Tag v1.0.0
   - Write release notes

5. **Make repository public**
```

---

## Git Commit for Phase 11:

```bash
git add .
git commit -m "chore: prepare for production deployment"
git push origin feature/phase11-deployment
git checkout develop
git merge feature/phase11-deployment
git checkout main
git merge develop
git push origin main
git tag -a v1.0.0 -m "Initial release"
git push origin v1.0.0
```

---

# ✅ Project Completion Checklist

## Features Implemented
- [ ] User authentication (register, login, logout)
- [ ] Workspaces (CRUD, invite members, roles)
- [ ] Projects (CRUD)
- [ ] Boards (CRUD)
- [ ] Columns (CRUD, reorder)
- [ ] Tasks (CRUD, move, drag & drop)
- [ ] Task details (assignees, labels, priority, due date)
- [ ] Comments
- [ ] Real-time updates
- [ ] Dashboard with statistics
- [ ] Global search
- [ ] Board filters
- [ ] Mobile responsive

## Quality Checklist
- [ ] All API endpoints working
- [ ] Real-time updates working
- [ ] No console errors
- [ ] Mobile responsive
- [ ] Loading states
- [ ] Error handling
- [ ] Empty states

## Documentation
- [ ] README with screenshots
- [ ] Setup instructions
- [ ] API documentation
- [ ] Demo GIF

## Deployment
- [ ] Backend deployed
- [ ] Frontend deployed
- [ ] Production database
- [ ] Environment variables set
- [ ] SSL enabled

## GitHub
- [ ] Repository public
- [ ] Clean commit history
- [ ] Topics added
- [ ] Release created

---

# 🎯 Daily Workflow with Claude Code

## Starting a New Phase

1. Open terminal in project folder
2. Start Claude Code: `claude`
3. Say:  "Read TASKFLOW-IMPLEMENTATION-GUIDE.md and start Phase X, Step X. X"
4. Follow Claude's implementation
5. Test each feature before moving on
6. Commit frequently

## Example Prompt for Claude Code: 

```
I'm building TaskFlow, a project management tool. 

Please read the implementation guide at TASKFLOW-IMPLEMENTATION-GUIDE. md

I want to start Phase 1, Step 1.1:  Create Eloquent Models with Relationships. 