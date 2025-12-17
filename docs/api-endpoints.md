# TaskFlow - Complete API Endpoints Structure

## Base URL
```
Development: http://localhost:8000/api
Production: https://api.taskflow.com/api
```

## Authentication
All endpoints (except auth routes) require authentication via Laravel Sanctum.

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
Content-Type: application/json
```

---

## 1. AUTHENTICATION & USER MANAGEMENT

### 1.1 Authentication
```
POST   /auth/register           Register new user
POST   /auth/login              Login user
POST   /auth/logout             Logout user (revoke token)
POST   /auth/refresh            Refresh token
POST   /auth/forgot-password    Send password reset link
POST   /auth/reset-password     Reset password with token
GET    /auth/verify-email/{id}/{hash}  Verify email
POST   /auth/resend-verification       Resend verification email
```

**Example: Register**
```json
POST /api/auth/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}

Response 201:
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "avatar": null,
    "created_at": "2025-12-16T10:00:00.000000Z"
  },
  "token": "1|abc123..."
}
```

**Example: Login**
```json
POST /api/auth/login
{
  "email": "john@example.com",
  "password": "password123"
}

Response 200:
{
  "user": { ... },
  "token": "2|xyz789..."
}
```

### 1.2 User Profile
```
GET    /user                    Get authenticated user
PUT    /user/profile            Update profile
POST   /user/avatar             Upload avatar
DELETE /user/avatar             Remove avatar
PUT    /user/password           Change password
```

**Example: Update Profile**
```json
PUT /api/user/profile
{
  "name": "John Updated",
  "bio": "Full-stack developer"
}

Response 200:
{
  "data": {
    "id": 1,
    "name": "John Updated",
    "email": "john@example.com",
    "avatar": "https://...",
    "bio": "Full-stack developer"
  }
}
```

---

## 2. WORKSPACES

### 2.1 Workspace CRUD
```
GET    /workspaces              List all user's workspaces
POST   /workspaces              Create workspace
GET    /workspaces/{slug}       Get workspace details
PUT    /workspaces/{slug}       Update workspace
DELETE /workspaces/{slug}       Delete workspace
POST   /workspaces/{slug}/logo  Upload workspace logo
```

**Example: Create Workspace**
```json
POST /api/workspaces
{
  "name": "Acme Corp",
  "slug": "acme-corp",
  "description": "Our main workspace"
}

Response 201:
{
  "data": {
    "id": 1,
    "name": "Acme Corp",
    "slug": "acme-corp",
    "description": "Our main workspace",
    "logo": null,
    "owner": {
      "id": 1,
      "name": "John Doe"
    },
    "members_count": 1,
    "projects_count": 0,
    "role": "owner",
    "created_at": "2025-12-16T10:00:00.000000Z"
  }
}
```

### 2.2 Workspace Members
```
GET    /workspaces/{slug}/members           List members
POST   /workspaces/{slug}/members/{userId}  Add member (admin only)
PUT    /workspaces/{slug}/members/{userId}  Update member role
DELETE /workspaces/{slug}/members/{userId}  Remove member
POST   /workspaces/{slug}/transfer-ownership  Transfer ownership
```

**Example: List Members**
```json
GET /api/workspaces/acme-corp/members

Response 200:
{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "avatar": "https://...",
      "role": "owner",
      "joined_at": "2025-12-16T10:00:00.000000Z"
    },
    {
      "id": 2,
      "name": "Jane Smith",
      "email": "jane@example.com",
      "avatar": null,
      "role": "admin",
      "joined_at": "2025-12-16T11:00:00.000000Z"
    }
  ],
  "meta": {
    "total": 2
  }
}
```

### 2.3 Workspace Invitations
```
POST   /workspaces/{slug}/invitations       Send invitation
GET    /workspaces/{slug}/invitations       List pending invitations
DELETE /workspaces/{slug}/invitations/{id}  Cancel invitation
POST   /invitations/{token}/accept          Accept invitation
POST   /invitations/{token}/decline         Decline invitation
GET    /invitations/{token}                 Get invitation details
```

**Example: Send Invitation**
```json
POST /api/workspaces/acme-corp/invitations
{
  "email": "jane@example.com",
  "role": "member"
}

Response 201:
{
  "data": {
    "id": 1,
    "email": "jane@example.com",
    "role": "member",
    "token": "abc123xyz...",
    "invited_by": {
      "id": 1,
      "name": "John Doe"
    },
    "expires_at": "2025-12-23T10:00:00.000000Z",
    "created_at": "2025-12-16T10:00:00.000000Z"
  }
}
```

### 2.4 Workspace Stats
```
GET    /workspaces/{slug}/stats             Get workspace statistics
GET    /workspaces/{slug}/activity          Get recent activity
```

---

## 3. PROJECTS

### 3.1 Project CRUD
```
GET    /workspaces/{slug}/projects          List projects
POST   /workspaces/{slug}/projects          Create project
GET    /workspaces/{slug}/projects/{projectSlug}    Get project
PUT    /workspaces/{slug}/projects/{projectSlug}    Update project
DELETE /workspaces/{slug}/projects/{projectSlug}    Delete project
POST   /workspaces/{slug}/projects/{projectSlug}/archive    Archive
POST   /workspaces/{slug}/projects/{projectSlug}/restore    Restore
```

**Example: Create Project**
```json
POST /api/workspaces/acme-corp/projects
{
  "name": "Website Redesign",
  "slug": "website-redesign",
  "description": "Complete redesign of company website",
  "color": "#3B82F6",
  "icon": "globe"
}

Response 201:
{
  "data": {
    "id": 1,
    "workspace_id": 1,
    "name": "Website Redesign",
    "slug": "website-redesign",
    "description": "Complete redesign of company website",
    "color": "#3B82F6",
    "icon": "globe",
    "is_archived": false,
    "boards_count": 0,
    "created_by": {
      "id": 1,
      "name": "John Doe"
    },
    "created_at": "2025-12-16T10:00:00.000000Z"
  }
}
```

### 3.2 Project Stats
```
GET    /workspaces/{slug}/projects/{projectSlug}/stats     Get statistics
```

---

## 4. BOARDS

### 4.1 Board CRUD
```
GET    /projects/{projectId}/boards         List boards
POST   /projects/{projectId}/boards         Create board
GET    /boards/{boardId}                    Get board with columns & tasks
PUT    /boards/{boardId}                    Update board
DELETE /boards/{boardId}                    Delete board
POST   /boards/{boardId}/duplicate          Duplicate board
POST   /boards/{boardId}/set-default        Set as default board
```

**Example: Get Board (Complete Structure)**
```json
GET /api/boards/1

Response 200:
{
  "data": {
    "id": 1,
    "project_id": 1,
    "name": "Sprint 1",
    "slug": "sprint-1",
    "description": "First sprint board",
    "is_default": true,
    "created_by": {
      "id": 1,
      "name": "John Doe"
    },
    "columns": [
      {
        "id": 1,
        "name": "To Do",
        "position": 0,
        "color": "#94A3B8",
        "limit": null,
        "tasks_count": 5,
        "tasks": [
          {
            "id": 1,
            "title": "Design homepage mockup",
            "description": "Create high-fidelity mockup",
            "position": 0,
            "priority": "high",
            "due_date": "2025-12-20T00:00:00.000000Z",
            "completed_at": null,
            "assignees": [
              {
                "id": 2,
                "name": "Jane Smith",
                "avatar": "https://..."
              }
            ],
            "labels": [
              {
                "id": 1,
                "name": "Design",
                "color": "#8B5CF6"
              }
            ],
            "comments_count": 3,
            "attachments_count": 2,
            "created_by": {
              "id": 1,
              "name": "John Doe"
            },
            "created_at": "2025-12-16T10:00:00.000000Z"
          }
        ]
      },
      {
        "id": 2,
        "name": "In Progress",
        "position": 1,
        "color": "#3B82F6",
        "limit": 3,
        "tasks_count": 2,
        "tasks": [ ... ]
      },
      {
        "id": 3,
        "name": "Done",
        "position": 2,
        "color": "#10B981",
        "limit": null,
        "tasks_count": 10,
        "tasks": [ ... ]
      }
    ],
    "labels": [
      {
        "id": 1,
        "name": "Design",
        "color": "#8B5CF6"
      },
      {
        "id": 2,
        "name": "Development",
        "color": "#3B82F6"
      }
    ],
    "created_at": "2025-12-16T10:00:00.000000Z"
  }
}
```

---

## 5. COLUMNS

### 5.1 Column CRUD
```
POST   /boards/{boardId}/columns            Create column
PUT    /columns/{columnId}                  Update column
DELETE /columns/{columnId}                  Delete column
POST   /columns/{columnId}/reorder          Reorder column position
```

**Example: Create Column**
```json
POST /api/boards/1/columns
{
  "name": "Code Review",
  "position": 2,
  "color": "#F59E0B",
  "limit": 5
}

Response 201:
{
  "data": {
    "id": 4,
    "board_id": 1,
    "name": "Code Review",
    "position": 2,
    "color": "#F59E0B",
    "limit": 5,
    "tasks_count": 0
  }
}
```

**Example: Reorder Columns**
```json
POST /api/columns/4/reorder
{
  "position": 1
}

Response 200:
{
  "message": "Column reordered successfully"
}
```

---

## 6. LABELS

### 6.1 Label CRUD
```
GET    /boards/{boardId}/labels             List labels
POST   /boards/{boardId}/labels             Create label
PUT    /labels/{labelId}                    Update label
DELETE /labels/{labelId}                    Delete label
```

**Example: Create Label**
```json
POST /api/boards/1/labels
{
  "name": "Bug",
  "color": "#EF4444"
}

Response 201:
{
  "data": {
    "id": 3,
    "board_id": 1,
    "name": "Bug",
    "color": "#EF4444"
  }
}
```

---

## 7. TASKS

### 7.1 Task CRUD
```
POST   /columns/{columnId}/tasks            Create task
GET    /tasks/{taskId}                      Get task details
PUT    /tasks/{taskId}                      Update task
DELETE /tasks/{taskId}                      Delete task
POST   /tasks/{taskId}/move                 Move task to another column
POST   /tasks/{taskId}/reorder              Reorder task within column
POST   /tasks/{taskId}/complete             Mark as complete
POST   /tasks/{taskId}/uncomplete           Mark as incomplete
POST   /tasks/{taskId}/duplicate            Duplicate task
```

**Example: Create Task**
```json
POST /api/columns/1/tasks
{
  "title": "Implement user authentication",
  "description": "Set up Laravel Sanctum for API authentication",
  "priority": "high",
  "due_date": "2025-12-25",
  "assignees": [2, 3],
  "labels": [1, 2]
}

Response 201:
{
  "data": {
    "id": 15,
    "column_id": 1,
    "board_id": 1,
    "title": "Implement user authentication",
    "description": "Set up Laravel Sanctum for API authentication",
    "position": 0,
    "priority": "high",
    "due_date": "2025-12-25T00:00:00.000000Z",
    "completed_at": null,
    "assignees": [ ... ],
    "labels": [ ... ],
    "comments_count": 0,
    "attachments_count": 0,
    "created_by": { ... },
    "created_at": "2025-12-16T10:00:00.000000Z"
  }
}
```

**Example: Move Task**
```json
POST /api/tasks/15/move
{
  "column_id": 2,
  "position": 1
}

Response 200:
{
  "data": { ... updated task ... },
  "message": "Task moved successfully"
}
```

### 7.2 Task Assignments
```
POST   /tasks/{taskId}/assignees            Assign users to task
DELETE /tasks/{taskId}/assignees/{userId}   Unassign user
```

**Example: Assign Users**
```json
POST /api/tasks/15/assignees
{
  "user_ids": [2, 3, 4]
}

Response 200:
{
  "data": {
    "assignees": [
      { "id": 2, "name": "Jane Smith", "avatar": "..." },
      { "id": 3, "name": "Bob Johnson", "avatar": "..." },
      { "id": 4, "name": "Alice Brown", "avatar": "..." }
    ]
  }
}
```

### 7.3 Task Labels
```
POST   /tasks/{taskId}/labels               Attach labels
DELETE /tasks/{taskId}/labels/{labelId}     Detach label
```

### 7.4 Task Search & Filter
```
GET    /boards/{boardId}/tasks/search       Search tasks
GET    /boards/{boardId}/tasks/filter       Filter tasks
```

**Example: Filter Tasks**
```json
GET /api/boards/1/tasks/filter?priority=high&assignee=2&label=1,2&overdue=true

Response 200:
{
  "data": [ ... filtered tasks ... ],
  "meta": {
    "total": 5,
    "per_page": 20,
    "current_page": 1
  }
}
```

---

## 8. COMMENTS

### 8.1 Comment CRUD
```
GET    /tasks/{taskId}/comments             List comments
POST   /tasks/{taskId}/comments             Create comment
PUT    /comments/{commentId}                Update comment
DELETE /comments/{commentId}                Delete comment
```

**Example: Create Comment**
```json
POST /api/tasks/15/comments
{
  "content": "I'll start working on this tomorrow",
  "parent_id": null
}

Response 201:
{
  "data": {
    "id": 1,
    "task_id": 15,
    "user": {
      "id": 2,
      "name": "Jane Smith",
      "avatar": "https://..."
    },
    "content": "I'll start working on this tomorrow",
    "parent_id": null,
    "replies": [],
    "created_at": "2025-12-16T10:00:00.000000Z",
    "updated_at": "2025-12-16T10:00:00.000000Z"
  }
}
```

**Example: Reply to Comment**
```json
POST /api/tasks/15/comments
{
  "content": "Sounds good! Let me know if you need help",
  "parent_id": 1
}
```

---

## 9. ATTACHMENTS

### 9.1 Attachment Management
```
GET    /tasks/{taskId}/attachments          List attachments
POST   /tasks/{taskId}/attachments          Upload attachment
GET    /attachments/{attachmentId}/download Download attachment
DELETE /attachments/{attachmentId}          Delete attachment
```

**Example: Upload Attachment**
```json
POST /api/tasks/15/attachments
Content-Type: multipart/form-data

file: [binary data]

Response 201:
{
  "data": {
    "id": 1,
    "task_id": 15,
    "filename": "abc123.pdf",
    "original_name": "requirements.pdf",
    "mime_type": "application/pdf",
    "size": 1048576,
    "url": "https://storage.taskflow.com/attachments/abc123.pdf",
    "user": {
      "id": 1,
      "name": "John Doe"
    },
    "created_at": "2025-12-16T10:00:00.000000Z"
  }
}
```

---

## 10. ACTIVITY TIMELINE

### 10.1 Activity Feed
```
GET    /workspaces/{slug}/activities        Workspace activity feed
GET    /projects/{projectId}/activities     Project activity feed
GET    /boards/{boardId}/activities         Board activity feed
GET    /tasks/{taskId}/activities           Task activity feed
GET    /users/{userId}/activities           User activity feed
```

**Example: Task Activity**
```json
GET /api/tasks/15/activities

Response 200:
{
  "data": [
    {
      "id": 1,
      "type": "task.created",
      "description": "John Doe created this task",
      "user": {
        "id": 1,
        "name": "John Doe",
        "avatar": "https://..."
      },
      "metadata": {
        "task_title": "Implement user authentication"
      },
      "created_at": "2025-12-16T10:00:00.000000Z"
    },
    {
      "id": 2,
      "type": "task.assigned",
      "description": "John Doe assigned Jane Smith",
      "user": {
        "id": 1,
        "name": "John Doe"
      },
      "metadata": {
        "assigned_user": {
          "id": 2,
          "name": "Jane Smith"
        }
      },
      "created_at": "2025-12-16T10:05:00.000000Z"
    },
    {
      "id": 3,
      "type": "task.moved",
      "description": "Jane Smith moved this task from To Do to In Progress",
      "user": {
        "id": 2,
        "name": "Jane Smith"
      },
      "metadata": {
        "from_column": "To Do",
        "to_column": "In Progress"
      },
      "created_at": "2025-12-16T11:00:00.000000Z"
    }
  ],
  "meta": {
    "total": 3,
    "per_page": 20
  }
}
```

---

## 11. NOTIFICATIONS

### 11.1 Notification Management
```
GET    /notifications                       List user notifications
GET    /notifications/unread                List unread notifications
POST   /notifications/{id}/read             Mark as read
POST   /notifications/read-all              Mark all as read
DELETE /notifications/{id}                  Delete notification
```

**Example: List Notifications**
```json
GET /api/notifications

Response 200:
{
  "data": [
    {
      "id": 1,
      "type": "task_assigned",
      "data": {
        "message": "You were assigned to 'Implement user authentication'",
        "task": {
          "id": 15,
          "title": "Implement user authentication"
        },
        "assigned_by": {
          "id": 1,
          "name": "John Doe"
        }
      },
      "read_at": null,
      "created_at": "2025-12-16T10:05:00.000000Z"
    },
    {
      "id": 2,
      "type": "comment_mention",
      "data": {
        "message": "Jane Smith mentioned you in a comment",
        "task": {
          "id": 15,
          "title": "Implement user authentication"
        },
        "comment": {
          "id": 5,
          "content": "@john Can you review this?"
        }
      },
      "read_at": "2025-12-16T11:00:00.000000Z",
      "created_at": "2025-12-16T10:30:00.000000Z"
    }
  ],
  "meta": {
    "total": 2,
    "unread_count": 1
  }
}
```

---

## 12. DASHBOARD & STATISTICS

### 12.1 Dashboard
```
GET    /dashboard                           User dashboard
GET    /dashboard/tasks                     My tasks
GET    /dashboard/recent-activity           Recent activity
GET    /dashboard/stats                     Personal statistics
```

**Example: Dashboard Stats**
```json
GET /api/dashboard/stats

Response 200:
{
  "data": {
    "tasks": {
      "assigned": 15,
      "completed": 8,
      "overdue": 2,
      "due_today": 3,
      "due_this_week": 7
    },
    "workspaces": {
      "total": 3,
      "owned": 1,
      "member": 2
    },
    "activity": {
      "tasks_created_this_week": 5,
      "tasks_completed_this_week": 8,
      "comments_this_week": 12
    },
    "recent_workspaces": [ ... ],
    "upcoming_tasks": [ ... ]
  }
}
```

### 12.2 Search
```
GET    /search                              Global search
GET    /workspaces/{slug}/search            Search within workspace
```

**Example: Global Search**
```json
GET /api/search?q=authentication&type=tasks,projects

Response 200:
{
  "data": {
    "tasks": [
      {
        "id": 15,
        "title": "Implement user authentication",
        "board": { "id": 1, "name": "Sprint 1" },
        "project": { "id": 1, "name": "Website Redesign" }
      }
    ],
    "projects": [
      {
        "id": 2,
        "name": "Authentication Service",
        "workspace": { "slug": "acme-corp", "name": "Acme Corp" }
      }
    ],
    "boards": [],
    "comments": []
  }
}
```

---

## 13. REAL-TIME EVENTS (Laravel Reverb / WebSockets)

### 13.1 WebSocket Connection
```
Connect to: ws://localhost:8080/app/{app_key}
```

### 13.2 Channel Subscriptions
```
Private Channels (require authentication):
- private-user.{userId}              User-specific events
- private-workspace.{workspaceId}    Workspace events
- private-board.{boardId}            Board events
- private-task.{taskId}              Task events
```

### 13.3 Real-time Events
```javascript
// Subscribe to board updates
Echo.private(`board.${boardId}`)
  .listen('TaskCreated', (e) => {
    console.log('New task:', e.task);
  })
  .listen('TaskMoved', (e) => {
    console.log('Task moved:', e.task, e.from, e.to);
  })
  .listen('TaskUpdated', (e) => {
    console.log('Task updated:', e.task);
  })
  .listen('TaskDeleted', (e) => {
    console.log('Task deleted:', e.taskId);
  })
  .listen('ColumnCreated', (e) => {
    console.log('Column created:', e.column);
  })
  .listen('ColumnUpdated', (e) => {
    console.log('Column updated:', e.column);
  });

// Subscribe to task updates
Echo.private(`task.${taskId}`)
  .listen('CommentAdded', (e) => {
    console.log('New comment:', e.comment);
  })
  .listen('TaskAssigned', (e) => {
    console.log('User assigned:', e.user);
  })
  .listen('AttachmentAdded', (e) => {
    console.log('New attachment:', e.attachment);
  });

// Subscribe to user notifications
Echo.private(`user.${userId}`)
  .listen('NewNotification', (e) => {
    console.log('New notification:', e.notification);
  });
```

---

## 14. ERROR RESPONSES

### Standard Error Format
```json
{
  "message": "Error message",
  "errors": {
    "field": ["Validation error message"]
  }
}
```

### HTTP Status Codes
```
200 OK                  - Successful GET, PUT
201 Created             - Successful POST
204 No Content          - Successful DELETE
400 Bad Request         - Invalid request
401 Unauthorized        - Authentication required
403 Forbidden           - Insufficient permissions
404 Not Found           - Resource not found
422 Unprocessable       - Validation error
429 Too Many Requests   - Rate limit exceeded
500 Server Error        - Internal server error
```

### Example Error Responses

**Validation Error (422)**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."],
    "due_date": ["The due date must be a date after today."]
  }
}
```

**Unauthorized (401)**
```json
{
  "message": "Unauthenticated."
}
```

**Forbidden (403)**
```json
{
  "message": "You do not have permission to perform this action.",
  "required_role": "admin",
  "current_role": "member"
}
```

**Not Found (404)**
```json
{
  "message": "Task not found."
}
```

---

## 15. PAGINATION

All list endpoints support pagination:

**Query Parameters:**
```
?page=1             Page number (default: 1)
?per_page=20        Items per page (default: 20, max: 100)
```

**Response Format:**
```json
{
  "data": [ ... ],
  "links": {
    "first": "https://api.taskflow.com/api/tasks?page=1",
    "last": "https://api.taskflow.com/api/tasks?page=5",
    "prev": null,
    "next": "https://api.taskflow.com/api/tasks?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "path": "https://api.taskflow.com/api/tasks",
    "per_page": 20,
    "to": 20,
    "total": 95
  }
}
```

---

## 16. FILTERING & SORTING

### Common Query Parameters
```
?sort=created_at        Sort field
?order=desc             Sort order (asc, desc)
?filter[key]=value      Filter by field
?include=relation       Include relationships
```

### Examples
```
GET /api/boards/1/tasks?sort=due_date&order=asc&filter[priority]=high&include=assignees,labels

GET /api/workspaces/acme-corp/projects?filter[is_archived]=false&sort=name

GET /api/tasks/15?include=assignees,labels,comments,attachments,activities
```

---

## 17. RATE LIMITING

```
Rate Limits:
- Authenticated: 60 requests per minute
- Unauthenticated: 10 requests per minute

Response Headers:
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1702742400
```

When rate limit is exceeded:
```json
429 Too Many Requests
{
  "message": "Too many requests. Please try again in 30 seconds."
}
```

---

## 18. WEBHOOKS (Future Feature)

```
POST   /webhooks                Create webhook
GET    /webhooks                List webhooks
DELETE /webhooks/{id}           Delete webhook
```

Webhook Events:
```
task.created
task.updated
task.deleted
task.completed
task.assigned
comment.added
project.created
board.created
```

---

## Summary

**Total Endpoints: ~120**

- Authentication: 8 endpoints
- User Profile: 5 endpoints
- Workspaces: 10 endpoints
- Projects: 7 endpoints
- Boards: 6 endpoints
- Columns: 4 endpoints
- Labels: 4 endpoints
- Tasks: 13 endpoints
- Comments: 4 endpoints
- Attachments: 4 endpoints
- Activities: 5 endpoints
- Notifications: 5 endpoints
- Dashboard: 4 endpoints
- Search: 2 endpoints
- Real-time: Multiple WebSocket channels

All endpoints follow RESTful conventions and return consistent JSON responses.
