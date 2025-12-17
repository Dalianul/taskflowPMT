# TaskFlow - Complete Database Schema

## Entity Relationship Diagram (ERD) Overview

```
users (1) ──< (n) workspace_user (n) >── (1) workspaces
                                              │
                                              │ (1)
                                              │
                                              ├── (n) projects
                                              │      │
                                              │      │ (1)
                                              │      │
                                              │      └── (n) boards
                                              │             │
                                              │             │ (1)
                                              │             │
                                              │             ├── (n) columns
                                              │             │      │
                                              │             │      │ (1)
                                              │             │      │
                                              │             │      └── (n) tasks
                                              │             │             │
                                              │             │             ├── (n) task_user (assignees)
                                              │             │             ├── (n) task_labels
                                              │             │             ├── (n) comments
                                              │             │             ├── (n) attachments
                                              │             │             └── (n) activities
                                              │             │
                                              │             └── (n) labels
                                              │
                                              └── (n) invitations
```

## Database Tables

### 1. **users**
Primary authentication and user information
```sql
users
├── id (bigint, PK, auto_increment)
├── name (varchar 255, required)
├── email (varchar 255, unique, required)
├── email_verified_at (timestamp, nullable)
├── password (varchar 255, required)
├── avatar (varchar 255, nullable)
├── bio (text, nullable)
├── remember_token (varchar 100, nullable)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- UNIQUE: email
```

### 2. **workspaces**
Team spaces that contain projects
```sql
workspaces
├── id (bigint, PK, auto_increment)
├── name (varchar 255, required)
├── slug (varchar 255, unique, required)
├── description (text, nullable)
├── logo (varchar 255, nullable)
├── owner_id (bigint, FK -> users.id, required)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- UNIQUE: slug
- INDEX: owner_id
- FOREIGN KEY: owner_id REFERENCES users(id) ON DELETE CASCADE
```

### 3. **workspace_user** (Pivot)
Many-to-many relationship between users and workspaces with roles
```sql
workspace_user
├── id (bigint, PK, auto_increment)
├── workspace_id (bigint, FK -> workspaces.id, required)
├── user_id (bigint, FK -> users.id, required)
├── role (enum: 'owner', 'admin', 'member', 'viewer', default: 'member')
├── joined_at (timestamp)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- UNIQUE: workspace_id, user_id
- INDEX: workspace_id
- INDEX: user_id
- FOREIGN KEY: workspace_id REFERENCES workspaces(id) ON DELETE CASCADE
- FOREIGN KEY: user_id REFERENCES users(id) ON DELETE CASCADE
```

### 4. **invitations**
Workspace invitation system
```sql
invitations
├── id (bigint, PK, auto_increment)
├── workspace_id (bigint, FK -> workspaces.id, required)
├── email (varchar 255, required)
├── token (varchar 64, unique, required)
├── role (enum: 'admin', 'member', 'viewer', default: 'member')
├── invited_by (bigint, FK -> users.id, required)
├── expires_at (timestamp, required)
├── accepted_at (timestamp, nullable)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- UNIQUE: token
- INDEX: workspace_id
- INDEX: email
- FOREIGN KEY: workspace_id REFERENCES workspaces(id) ON DELETE CASCADE
- FOREIGN KEY: invited_by REFERENCES users(id) ON DELETE CASCADE
```

### 5. **projects**
Projects within workspaces
```sql
projects
├── id (bigint, PK, auto_increment)
├── workspace_id (bigint, FK -> workspaces.id, required)
├── name (varchar 255, required)
├── slug (varchar 255, required)
├── description (text, nullable)
├── color (varchar 7, nullable, e.g., '#3B82F6')
├── icon (varchar 50, nullable)
├── is_archived (boolean, default: false)
├── created_by (bigint, FK -> users.id, required)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- UNIQUE: workspace_id, slug
- INDEX: workspace_id
- INDEX: created_by
- INDEX: is_archived
- FOREIGN KEY: workspace_id REFERENCES workspaces(id) ON DELETE CASCADE
- FOREIGN KEY: created_by REFERENCES users(id) ON DELETE RESTRICT
```

### 6. **boards**
Kanban boards within projects
```sql
boards
├── id (bigint, PK, auto_increment)
├── project_id (bigint, FK -> projects.id, required)
├── name (varchar 255, required)
├── slug (varchar 255, required)
├── description (text, nullable)
├── is_default (boolean, default: false)
├── created_by (bigint, FK -> users.id, required)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- UNIQUE: project_id, slug
- INDEX: project_id
- INDEX: created_by
- FOREIGN KEY: project_id REFERENCES projects(id) ON DELETE CASCADE
- FOREIGN KEY: created_by REFERENCES users(id) ON DELETE RESTRICT
```

### 7. **columns**
Columns within boards (e.g., To Do, In Progress, Done)
```sql
columns
├── id (bigint, PK, auto_increment)
├── board_id (bigint, FK -> boards.id, required)
├── name (varchar 255, required)
├── position (integer, required, default: 0)
├── color (varchar 7, nullable)
├── limit (integer, nullable) -- WIP limit
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- INDEX: board_id
- INDEX: board_id, position
- FOREIGN KEY: board_id REFERENCES boards(id) ON DELETE CASCADE
```

### 8. **labels**
Reusable labels for tasks within boards
```sql
labels
├── id (bigint, PK, auto_increment)
├── board_id (bigint, FK -> boards.id, required)
├── name (varchar 100, required)
├── color (varchar 7, required, e.g., '#10B981')
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- INDEX: board_id
- UNIQUE: board_id, name
- FOREIGN KEY: board_id REFERENCES boards(id) ON DELETE CASCADE
```

### 9. **tasks**
Individual tasks/cards within columns
```sql
tasks
├── id (bigint, PK, auto_increment)
├── column_id (bigint, FK -> columns.id, required)
├── board_id (bigint, FK -> boards.id, required) -- denormalized for faster queries
├── title (varchar 500, required)
├── description (text, nullable)
├── position (integer, required, default: 0)
├── priority (enum: 'low', 'medium', 'high', 'urgent', nullable)
├── due_date (timestamp, nullable)
├── completed_at (timestamp, nullable)
├── created_by (bigint, FK -> users.id, required)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- INDEX: column_id
- INDEX: board_id
- INDEX: column_id, position
- INDEX: due_date
- INDEX: priority
- INDEX: created_by
- FOREIGN KEY: column_id REFERENCES columns(id) ON DELETE CASCADE
- FOREIGN KEY: board_id REFERENCES boards(id) ON DELETE CASCADE
- FOREIGN KEY: created_by REFERENCES users(id) ON DELETE RESTRICT
```

### 10. **task_user** (Pivot)
Task assignees (many-to-many)
```sql
task_user
├── id (bigint, PK, auto_increment)
├── task_id (bigint, FK -> tasks.id, required)
├── user_id (bigint, FK -> users.id, required)
├── assigned_by (bigint, FK -> users.id, nullable)
├── assigned_at (timestamp)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- UNIQUE: task_id, user_id
- INDEX: task_id
- INDEX: user_id
- FOREIGN KEY: task_id REFERENCES tasks(id) ON DELETE CASCADE
- FOREIGN KEY: user_id REFERENCES users(id) ON DELETE CASCADE
- FOREIGN KEY: assigned_by REFERENCES users(id) ON DELETE SET NULL
```

### 11. **task_label** (Pivot)
Task labels (many-to-many)
```sql
task_label
├── id (bigint, PK, auto_increment)
├── task_id (bigint, FK -> tasks.id, required)
├── label_id (bigint, FK -> labels.id, required)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- UNIQUE: task_id, label_id
- INDEX: task_id
- INDEX: label_id
- FOREIGN KEY: task_id REFERENCES tasks(id) ON DELETE CASCADE
- FOREIGN KEY: label_id REFERENCES labels(id) ON DELETE CASCADE
```

### 12. **comments**
Comments on tasks
```sql
comments
├── id (bigint, PK, auto_increment)
├── task_id (bigint, FK -> tasks.id, required)
├── user_id (bigint, FK -> users.id, required)
├── content (text, required)
├── parent_id (bigint, FK -> comments.id, nullable) -- for threaded comments
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- INDEX: task_id
- INDEX: user_id
- INDEX: parent_id
- FOREIGN KEY: task_id REFERENCES tasks(id) ON DELETE CASCADE
- FOREIGN KEY: user_id REFERENCES users(id) ON DELETE CASCADE
- FOREIGN KEY: parent_id REFERENCES comments(id) ON DELETE CASCADE
```

### 13. **attachments**
File attachments for tasks
```sql
attachments
├── id (bigint, PK, auto_increment)
├── task_id (bigint, FK -> tasks.id, required)
├── user_id (bigint, FK -> users.id, required)
├── filename (varchar 255, required)
├── original_name (varchar 255, required)
├── mime_type (varchar 100, required)
├── size (integer, required) -- bytes
├── path (varchar 500, required)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- INDEX: task_id
- INDEX: user_id
- FOREIGN KEY: task_id REFERENCES tasks(id) ON DELETE CASCADE
- FOREIGN KEY: user_id REFERENCES users(id) ON DELETE CASCADE
```

### 14. **activities**
Activity timeline/audit log
```sql
activities
├── id (bigint, PK, auto_increment)
├── workspace_id (bigint, FK -> workspaces.id, nullable)
├── project_id (bigint, FK -> projects.id, nullable)
├── board_id (bigint, FK -> boards.id, nullable)
├── task_id (bigint, FK -> tasks.id, nullable)
├── user_id (bigint, FK -> users.id, nullable)
├── type (varchar 50, required) -- e.g., 'task.created', 'task.moved', 'comment.added'
├── description (text, required)
├── metadata (json, nullable) -- store additional context
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- INDEX: workspace_id
- INDEX: project_id
- INDEX: board_id
- INDEX: task_id
- INDEX: user_id
- INDEX: type
- INDEX: created_at
- FOREIGN KEY: workspace_id REFERENCES workspaces(id) ON DELETE CASCADE
- FOREIGN KEY: project_id REFERENCES projects(id) ON DELETE CASCADE
- FOREIGN KEY: board_id REFERENCES boards(id) ON DELETE CASCADE
- FOREIGN KEY: task_id REFERENCES tasks(id) ON DELETE CASCADE
- FOREIGN KEY: user_id REFERENCES users(id) ON DELETE SET NULL
```

### 15. **notifications**
User notifications
```sql
notifications
├── id (bigint, PK, auto_increment)
├── user_id (bigint, FK -> users.id, required)
├── type (varchar 100, required)
├── notifiable_type (varchar 255, nullable) -- polymorphic
├── notifiable_id (bigint, nullable) -- polymorphic
├── data (json, required)
├── read_at (timestamp, nullable)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- INDEX: user_id
- INDEX: user_id, read_at
- INDEX: notifiable_type, notifiable_id
- FOREIGN KEY: user_id REFERENCES users(id) ON DELETE CASCADE
```

### 16. **personal_access_tokens** (Laravel Sanctum)
API tokens
```sql
personal_access_tokens
├── id (bigint, PK, auto_increment)
├── tokenable_type (varchar 255, required)
├── tokenable_id (bigint, required)
├── name (varchar 255, required)
├── token (varchar 64, unique, required)
├── abilities (text, nullable)
├── last_used_at (timestamp, nullable)
├── expires_at (timestamp, nullable)
├── created_at (timestamp)
└── updated_at (timestamp)

Indexes:
- PRIMARY: id
- UNIQUE: token
- INDEX: tokenable_type, tokenable_id
```

## Key Design Decisions

### 1. **Denormalization**
- `tasks.board_id` is denormalized for faster board-level queries
- Avoids JOIN through columns table for common queries

### 2. **Soft Deletes**
- Not implemented by default for cleaner data
- Can be added to specific tables if needed (projects, boards)

### 3. **Polymorphic Relationships**
- `notifications` uses polymorphic relations for flexibility
- `activities` can reference multiple entity types

### 4. **Position Management**
- `columns.position` and `tasks.position` use integers
- Allows drag-and-drop reordering
- Consider using decimal positions for better performance

### 5. **JSON Fields**
- `activities.metadata` stores flexible context data
- `notifications.data` stores notification payload

### 6. **Cascade Rules**
- Workspaces cascade delete to projects, boards, tasks
- User deletions are RESTRICT on created_by (preserve audit trail)
- Comments and activities can cascade or SET NULL based on requirements

## Performance Considerations

### Indexes Strategy
1. **Foreign keys**: All FKs have indexes
2. **Unique constraints**: email, slugs, pivot combinations
3. **Query optimization**: position fields, dates, status fields
4. **Composite indexes**: (board_id, position), (workspace_id, slug)

### Scaling Recommendations
1. **Partition**: Consider partitioning `activities` table by date
2. **Archive**: Move completed tasks older than X months
3. **Cache**: Use Redis for:
   - Board structure (columns + task counts)
   - User permissions
   - Activity feeds
4. **Read replicas**: For reporting and dashboard queries

## Data Integrity Rules

### Business Logic Constraints
1. A user cannot be assigned to a task in a workspace they don't belong to
2. Workspace owner cannot be removed without transferring ownership
3. Default board cannot be deleted if it's the only board
4. Column positions must be unique within a board
5. Task positions must be unique within a column

### Validation Rules (Application Level)
```php
// Workspace slug: lowercase, alphanumeric, hyphens
'slug' => 'required|alpha_dash|lowercase|max:100'

// Task title: 1-500 characters
'title' => 'required|string|min:1|max:500'

// Priority: enum validation
'priority' => 'nullable|in:low,medium,high,urgent'

// Role: enum validation
'role' => 'required|in:owner,admin,member,viewer'
```

## Migration Order
Execute migrations in this order to maintain referential integrity:

1. users (already exists)
2. workspaces
3. workspace_user
4. invitations
5. projects
6. boards
7. columns
8. labels
9. tasks
10. task_user
11. task_label
12. comments
13. attachments
14. activities
15. notifications
