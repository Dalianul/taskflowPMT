# TaskFlow - Backend (Laravel) Folder Structure

## Complete Directory Tree

```
backend/
├── app/
│   ├── Broadcasting/                    # WebSocket channels
│   │   ├── BoardChannel.php
│   │   ├── TaskChannel.php
│   │   ├── UserChannel.php
│   │   └── WorkspaceChannel.php
│   │
│   ├── Console/
│   │   ├── Commands/
│   │   │   ├── CleanupExpiredInvitations.php
│   │   │   └── GenerateActivityReport.php
│   │   └── Kernel.php
│   │
│   ├── Events/                          # Real-time events
│   │   ├── Board/
│   │   │   ├── BoardCreated.php
│   │   │   └── BoardUpdated.php
│   │   ├── Column/
│   │   │   ├── ColumnCreated.php
│   │   │   ├── ColumnUpdated.php
│   │   │   └── ColumnDeleted.php
│   │   ├── Task/
│   │   │   ├── TaskCreated.php
│   │   │   ├── TaskUpdated.php
│   │   │   ├── TaskMoved.php
│   │   │   ├── TaskCompleted.php
│   │   │   ├── TaskDeleted.php
│   │   │   └── TaskAssigned.php
│   │   ├── Comment/
│   │   │   ├── CommentAdded.php
│   │   │   └── CommentUpdated.php
│   │   ├── Attachment/
│   │   │   └── AttachmentAdded.php
│   │   └── Workspace/
│   │       ├── WorkspaceCreated.php
│   │       └── MemberInvited.php
│   │
│   ├── Exceptions/
│   │   ├── Handler.php
│   │   ├── InsufficientPermissionsException.php
│   │   ├── WorkspaceNotFoundException.php
│   │   └── TaskNotFoundException.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── Auth/
│   │   │   │   │   ├── AuthController.php
│   │   │   │   │   ├── PasswordResetController.php
│   │   │   │   │   └── VerificationController.php
│   │   │   │   ├── Workspace/
│   │   │   │   │   ├── WorkspaceController.php
│   │   │   │   │   ├── WorkspaceMemberController.php
│   │   │   │   │   ├── WorkspaceInvitationController.php
│   │   │   │   │   └── WorkspaceStatsController.php
│   │   │   │   ├── Project/
│   │   │   │   │   ├── ProjectController.php
│   │   │   │   │   └── ProjectArchiveController.php
│   │   │   │   ├── Board/
│   │   │   │   │   ├── BoardController.php
│   │   │   │   │   └── BoardDuplicateController.php
│   │   │   │   ├── Column/
│   │   │   │   │   ├── ColumnController.php
│   │   │   │   │   └── ColumnReorderController.php
│   │   │   │   ├── Label/
│   │   │   │   │   └── LabelController.php
│   │   │   │   ├── Task/
│   │   │   │   │   ├── TaskController.php
│   │   │   │   │   ├── TaskMoveController.php
│   │   │   │   │   ├── TaskReorderController.php
│   │   │   │   │   ├── TaskCompleteController.php
│   │   │   │   │   ├── TaskAssigneeController.php
│   │   │   │   │   ├── TaskLabelController.php
│   │   │   │   │   └── TaskSearchController.php
│   │   │   │   ├── Comment/
│   │   │   │   │   └── CommentController.php
│   │   │   │   ├── Attachment/
│   │   │   │   │   └── AttachmentController.php
│   │   │   │   ├── Activity/
│   │   │   │   │   └── ActivityController.php
│   │   │   │   ├── Notification/
│   │   │   │   │   └── NotificationController.php
│   │   │   │   ├── Dashboard/
│   │   │   │   │   └── DashboardController.php
│   │   │   │   ├── Search/
│   │   │   │   │   └── GlobalSearchController.php
│   │   │   │   └── User/
│   │   │   │       ├── UserProfileController.php
│   │   │   │       └── UserAvatarController.php
│   │   │   └── Controller.php
│   │   │
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   ├── CheckWorkspaceAccess.php
│   │   │   ├── CheckWorkspaceRole.php
│   │   │   ├── CheckProjectAccess.php
│   │   │   ├── CheckBoardAccess.php
│   │   │   ├── CheckTaskAccess.php
│   │   │   └── TrackActivity.php
│   │   │
│   │   ├── Requests/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginRequest.php
│   │   │   │   ├── RegisterRequest.php
│   │   │   │   └── ResetPasswordRequest.php
│   │   │   ├── Workspace/
│   │   │   │   ├── StoreWorkspaceRequest.php
│   │   │   │   ├── UpdateWorkspaceRequest.php
│   │   │   │   └── InviteMemberRequest.php
│   │   │   ├── Project/
│   │   │   │   ├── StoreProjectRequest.php
│   │   │   │   └── UpdateProjectRequest.php
│   │   │   ├── Board/
│   │   │   │   ├── StoreBoardRequest.php
│   │   │   │   └── UpdateBoardRequest.php
│   │   │   ├── Column/
│   │   │   │   ├── StoreColumnRequest.php
│   │   │   │   └── UpdateColumnRequest.php
│   │   │   ├── Task/
│   │   │   │   ├── StoreTaskRequest.php
│   │   │   │   ├── UpdateTaskRequest.php
│   │   │   │   └── MoveTaskRequest.php
│   │   │   ├── Comment/
│   │   │   │   ├── StoreCommentRequest.php
│   │   │   │   └── UpdateCommentRequest.php
│   │   │   └── User/
│   │   │       └── UpdateProfileRequest.php
│   │   │
│   │   └── Resources/
│   │       ├── UserResource.php
│   │       ├── WorkspaceResource.php
│   │       ├── WorkspaceDetailResource.php
│   │       ├── ProjectResource.php
│   │       ├── BoardResource.php
│   │       ├── BoardDetailResource.php
│   │       ├── ColumnResource.php
│   │       ├── LabelResource.php
│   │       ├── TaskResource.php
│   │       ├── TaskDetailResource.php
│   │       ├── CommentResource.php
│   │       ├── AttachmentResource.php
│   │       ├── ActivityResource.php
│   │       └── NotificationResource.php
│   │
│   ├── Listeners/                       # Event listeners
│   │   ├── Task/
│   │   │   ├── LogTaskCreated.php
│   │   │   ├── LogTaskMoved.php
│   │   │   ├── NotifyTaskAssigned.php
│   │   │   └── BroadcastTaskUpdate.php
│   │   ├── Comment/
│   │   │   ├── LogCommentAdded.php
│   │   │   └── NotifyCommentMention.php
│   │   └── Workspace/
│   │       └── SendInvitationEmail.php
│   │
│   ├── Models/
│   │   ├── Activity.php
│   │   ├── Attachment.php
│   │   ├── Board.php
│   │   ├── Column.php
│   │   ├── Comment.php
│   │   ├── Invitation.php
│   │   ├── Label.php
│   │   ├── Notification.php
│   │   ├── Project.php
│   │   ├── Task.php
│   │   ├── User.php
│   │   └── Workspace.php
│   │
│   ├── Notifications/                   # Email/push notifications
│   │   ├── TaskAssignedNotification.php
│   │   ├── CommentMentionNotification.php
│   │   ├── WorkspaceInvitationNotification.php
│   │   └── TaskDueNotification.php
│   │
│   ├── Observers/                       # Model observers
│   │   ├── TaskObserver.php
│   │   ├── CommentObserver.php
│   │   └── WorkspaceObserver.php
│   │
│   ├── Policies/
│   │   ├── WorkspacePolicy.php
│   │   ├── ProjectPolicy.php
│   │   ├── BoardPolicy.php
│   │   ├── ColumnPolicy.php
│   │   ├── TaskPolicy.php
│   │   ├── CommentPolicy.php
│   │   └── AttachmentPolicy.php
│   │
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   ├── BroadcastServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   └── RouteServiceProvider.php
│   │
│   ├── Services/                        # Business logic
│   │   ├── WorkspaceService.php
│   │   ├── InvitationService.php
│   │   ├── TaskService.php
│   │   ├── ActivityService.php
│   │   ├── NotificationService.php
│   │   ├── SearchService.php
│   │   └── FileStorageService.php
│   │
│   └── Traits/
│       ├── HasWorkspaceAccess.php
│       ├── HasPermissions.php
│       ├── Sluggable.php
│       └── LogsActivity.php
│
├── bootstrap/
│   ├── app.php
│   └── providers.php
│
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── broadcasting.php                 # Reverb config
│   ├── cache.php
│   ├── cors.php
│   ├── database.php
│   ├── filesystems.php
│   ├── mail.php
│   ├── queue.php
│   ├── reverb.php                       # Laravel Reverb
│   ├── sanctum.php                      # API auth
│   └── services.php
│
├── database/
│   ├── factories/
│   │   ├── UserFactory.php
│   │   ├── WorkspaceFactory.php
│   │   ├── ProjectFactory.php
│   │   ├── BoardFactory.php
│   │   ├── ColumnFactory.php
│   │   ├── TaskFactory.php
│   │   └── CommentFactory.php
│   │
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_12_16_000001_create_workspaces_table.php
│   │   ├── 2025_12_16_000002_create_workspace_user_table.php
│   │   ├── 2025_12_16_000003_create_invitations_table.php
│   │   ├── 2025_12_16_000004_create_projects_table.php
│   │   ├── 2025_12_16_000005_create_boards_table.php
│   │   ├── 2025_12_16_000006_create_columns_table.php
│   │   ├── 2025_12_16_000007_create_labels_table.php
│   │   ├── 2025_12_16_000008_create_tasks_table.php
│   │   ├── 2025_12_16_000009_create_task_user_table.php
│   │   ├── 2025_12_16_000010_create_task_label_table.php
│   │   ├── 2025_12_16_000011_create_comments_table.php
│   │   ├── 2025_12_16_000012_create_attachments_table.php
│   │   ├── 2025_12_16_000013_create_activities_table.php
│   │   └── 2025_12_16_000014_create_notifications_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       ├── WorkspaceSeeder.php
│       ├── ProjectSeeder.php
│       ├── BoardSeeder.php
│       └── DemoDataSeeder.php
│
├── public/
│   ├── index.php
│   └── storage/                         # Symlink to storage/app/public
│
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       └── emails/
│           ├── invitation.blade.php
│           └── task-assigned.blade.php
│
├── routes/
│   ├── api.php                          # API routes
│   ├── channels.php                     # Broadcasting channels
│   ├── console.php                      # Console commands
│   └── web.php                          # Web routes
│
├── storage/
│   ├── app/
│   │   ├── public/
│   │   │   ├── avatars/
│   │   │   ├── workspace-logos/
│   │   │   └── attachments/
│   │   └── private/
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   └── views/
│   └── logs/
│       └── laravel.log
│
├── tests/
│   ├── Feature/
│   │   ├── Auth/
│   │   │   ├── LoginTest.php
│   │   │   └── RegisterTest.php
│   │   ├── Workspace/
│   │   │   ├── CreateWorkspaceTest.php
│   │   │   ├── InviteMemberTest.php
│   │   │   └── WorkspacePermissionsTest.php
│   │   ├── Project/
│   │   │   ├── CreateProjectTest.php
│   │   │   └── ArchiveProjectTest.php
│   │   ├── Board/
│   │   │   └── CreateBoardTest.php
│   │   ├── Task/
│   │   │   ├── CreateTaskTest.php
│   │   │   ├── MoveTaskTest.php
│   │   │   ├── AssignTaskTest.php
│   │   │   └── CompleteTaskTest.php
│   │   └── Comment/
│   │       └── CreateCommentTest.php
│   │
│   ├── Unit/
│   │   ├── Models/
│   │   │   ├── WorkspaceTest.php
│   │   │   ├── TaskTest.php
│   │   │   └── UserTest.php
│   │   ├── Services/
│   │   │   ├── TaskServiceTest.php
│   │   │   └── InvitationServiceTest.php
│   │   └── Policies/
│   │       ├── WorkspacePolicyTest.php
│   │       └── TaskPolicyTest.php
│   │
│   ├── Pest.php                         # Pest PHP config (optional)
│   └── TestCase.php
│
├── .editorconfig
├── .env
├── .env.example
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json                         # For Vite/npm
├── package-lock.json
├── phpunit.xml
├── README.md
└── vite.config.js
```

---

## Key Directories Explanation

### 1. **app/Broadcasting/**
Defines private channels for Laravel Reverb WebSocket authentication.

### 2. **app/Events/**
Events that trigger real-time broadcasts and listeners. Organized by domain.

### 3. **app/Http/Controllers/Api/**
RESTful API controllers organized by resource domain.

### 4. **app/Http/Middleware/**
Custom middleware for access control and activity tracking.

### 5. **app/Http/Requests/**
Form request classes with validation rules.

### 6. **app/Http/Resources/**
API resource transformers for consistent JSON responses.

### 7. **app/Listeners/**
Event listeners that log activities, send notifications, and broadcast updates.

### 8. **app/Models/**
Eloquent models with relationships, scopes, and business logic.

### 9. **app/Notifications/**
Email and push notification classes.

### 10. **app/Observers/**
Model observers for automatic logging and side effects.

### 11. **app/Policies/**
Authorization policies for resource access control.

### 12. **app/Services/**
Business logic layer for complex operations.

### 13. **database/migrations/**
Database schema migrations in chronological order.

### 14. **routes/api.php**
API route definitions grouped by resource.

### 15. **routes/channels.php**
Broadcasting channel authorization.

### 16. **storage/app/public/**
User-uploaded files (avatars, logos, attachments).

### 17. **tests/**
Feature and unit tests organized by domain.

---

## Routes Organization (routes/api.php)

```php
<?php

use Illuminate\Support\Facades\Route;

// Auth routes (public)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
    Route::post('/reset-password', [PasswordResetController::class, 'reset']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/user', [UserProfileController::class, 'show']);
    Route::put('/user/profile', [UserProfileController::class, 'update']);
    Route::post('/user/avatar', [UserAvatarController::class, 'upload']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // Workspaces
    Route::apiResource('workspaces', WorkspaceController::class);
    Route::prefix('workspaces/{workspace:slug}')->group(function () {
        Route::get('/members', [WorkspaceMemberController::class, 'index']);
        Route::post('/members/{user}', [WorkspaceMemberController::class, 'store']);
        Route::put('/members/{user}', [WorkspaceMemberController::class, 'update']);
        Route::delete('/members/{user}', [WorkspaceMemberController::class, 'destroy']);

        Route::get('/invitations', [WorkspaceInvitationController::class, 'index']);
        Route::post('/invitations', [WorkspaceInvitationController::class, 'store']);
        Route::delete('/invitations/{invitation}', [WorkspaceInvitationController::class, 'destroy']);

        Route::apiResource('projects', ProjectController::class);
    });

    // Projects
    Route::apiResource('projects.boards', BoardController::class);

    // Boards
    Route::prefix('boards/{board}')->group(function () {
        Route::apiResource('columns', ColumnController::class);
        Route::apiResource('labels', LabelController::class);
        Route::get('/tasks/search', [TaskSearchController::class, 'search']);
    });

    // Columns
    Route::prefix('columns/{column}')->group(function () {
        Route::post('/reorder', [ColumnReorderController::class, 'reorder']);
        Route::apiResource('tasks', TaskController::class);
    });

    // Tasks
    Route::prefix('tasks/{task}')->group(function () {
        Route::post('/move', [TaskMoveController::class, 'move']);
        Route::post('/reorder', [TaskReorderController::class, 'reorder']);
        Route::post('/complete', [TaskCompleteController::class, 'complete']);
        Route::post('/uncomplete', [TaskCompleteController::class, 'uncomplete']);

        Route::post('/assignees', [TaskAssigneeController::class, 'attach']);
        Route::delete('/assignees/{user}', [TaskAssigneeController::class, 'detach']);

        Route::post('/labels', [TaskLabelController::class, 'attach']);
        Route::delete('/labels/{label}', [TaskLabelController::class, 'detach']);

        Route::apiResource('comments', CommentController::class);
        Route::apiResource('attachments', AttachmentController::class);
        Route::get('/activities', [ActivityController::class, 'index']);
    });

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

    // Search
    Route::get('/search', [GlobalSearchController::class, 'search']);
});

// Invitation acceptance (public with token)
Route::post('/invitations/{token}/accept', [WorkspaceInvitationController::class, 'accept']);
Route::get('/invitations/{token}', [WorkspaceInvitationController::class, 'show']);
```

---

## Key Design Patterns

### 1. **Repository Pattern** (Optional)
For complex queries, consider adding a `app/Repositories/` directory.

### 2. **Service Layer**
Complex business logic lives in `app/Services/` classes.

### 3. **Resource Pattern**
All API responses use Resources for consistent formatting.

### 4. **Observer Pattern**
Automatic activity logging via Model Observers.

### 5. **Event-Driven Architecture**
Events/Listeners for real-time updates and decoupled logic.

### 6. **Policy-Based Authorization**
All access control via Policies.

---

## Environment Configuration

### Required .env Variables
```env
APP_NAME=TaskFlow
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025

QUEUE_CONNECTION=redis

BROADCAST_DRIVER=reverb
REVERB_APP_ID=...
REVERB_APP_KEY=...
REVERB_APP_SECRET=...
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME=http

SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost

FILESYSTEM_DISK=local
```

---

This structure provides a clean, organized Laravel backend ready for scaling and maintaining a production-grade project management application.
