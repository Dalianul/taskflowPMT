# TaskFlow - Frontend Component Hierarchy

## Technology Stack
- **Framework**: Next.js 15 with App Router
- **Language**: TypeScript
- **Styling**: Tailwind CSS
- **State Management**: Zustand / React Query
- **Drag & Drop**: @dnd-kit/core
- **Real-time**: Laravel Echo + Pusher
- **Forms**: React Hook Form + Zod
- **UI Components**: Shadcn/ui (Radix UI primitives)

---

## Component Architecture Overview

```
App Layout
├── Authentication Layer
│   ├── Public Pages (Login, Register)
│   └── Protected Pages (Dashboard, Workspaces)
├── Navigation Layer
│   ├── Top Navigation
│   └── Sidebar Navigation
├── Content Layer
│   ├── Workspace Views
│   ├── Project Views
│   └── Board Views
└── Shared Components
    ├── UI Components
    ├── Forms
    └── Modals
```

---

## 1. LAYOUT COMPONENTS

### 1.1 Root Layout
```
app/layout.tsx
├── Providers
│   ├── AuthProvider (authentication context)
│   ├── ThemeProvider (dark/light mode)
│   ├── QueryClientProvider (React Query)
│   └── ToastProvider (notifications)
└── children
```

### 1.2 Main Application Layout
```
app/(app)/layout.tsx
├── TopNavigation
│   ├── Logo
│   ├── WorkspaceSwitcher
│   ├── GlobalSearch
│   ├── NotificationBell
│   └── UserMenu
├── Sidebar (collapsible)
│   ├── WorkspaceInfo
│   ├── NavigationMenu
│   │   ├── DashboardLink
│   │   ├── ProjectsList
│   │   └── SettingsLink
│   └── CreateButton
└── MainContent
    └── children
```

### 1.3 Auth Layout
```
app/(auth)/layout.tsx
├── AuthCard
│   ├── Logo
│   ├── children (form)
│   └── Footer
└── BackgroundPattern
```

---

## 2. AUTHENTICATION COMPONENTS

### 2.1 Login Page
```
pages/auth/login/page.tsx
└── LoginForm
    ├── EmailInput
    ├── PasswordInput
    ├── RememberMeCheckbox
    ├── ForgotPasswordLink
    └── SubmitButton
```

### 2.2 Register Page
```
pages/auth/register/page.tsx
└── RegisterForm
    ├── NameInput
    ├── EmailInput
    ├── PasswordInput
    ├── PasswordConfirmInput
    ├── TermsCheckbox
    └── SubmitButton
```

### 2.3 Password Reset
```
pages/auth/forgot-password/page.tsx
└── ForgotPasswordForm
    ├── EmailInput
    └── SubmitButton

pages/auth/reset-password/page.tsx
└── ResetPasswordForm
    ├── PasswordInput
    ├── PasswordConfirmInput
    └── SubmitButton
```

---

## 3. DASHBOARD COMPONENTS

### 3.1 Dashboard Page
```
app/(app)/dashboard/page.tsx
├── DashboardHeader
│   ├── PageTitle
│   └── QuickActions
├── StatsGrid
│   ├── TasksStatCard
│   ├── ProjectsStatCard
│   ├── CompletedStatCard
│   └── OverdueStatCard
├── MyTasks
│   └── TaskList
│       └── TaskCard[]
├── RecentActivity
│   └── ActivityFeed
│       └── ActivityItem[]
└── UpcomingDeadlines
    └── DeadlineList
        └── DeadlineItem[]
```

---

## 4. WORKSPACE COMPONENTS

### 4.1 Workspace List
```
app/(app)/workspaces/page.tsx
├── WorkspacesHeader
│   ├── PageTitle
│   └── CreateWorkspaceButton
└── WorkspaceGrid
    └── WorkspaceCard[]
        ├── WorkspaceLogo
        ├── WorkspaceName
        ├── WorkspaceStats
        └── WorkspaceActions
```

### 4.2 Workspace Detail
```
app/(app)/workspaces/[slug]/page.tsx
├── WorkspaceHeader
│   ├── WorkspaceInfo
│   │   ├── Logo
│   │   ├── Name & Description
│   │   └── MemberAvatars
│   └── WorkspaceActions
│       ├── InviteButton
│       └── SettingsButton
├── ProjectsSection
│   └── ProjectGrid
│       └── ProjectCard[]
│           ├── ProjectIcon
│           ├── ProjectName
│           ├── ProgressBar
│           └── QuickStats
└── ActivitySection
    └── RecentActivity
```

### 4.3 Workspace Settings
```
app/(app)/workspaces/[slug]/settings/layout.tsx
├── SettingsSidebar
│   ├── GeneralLink
│   ├── MembersLink
│   ├── InvitationsLink
│   └── DangerZoneLink
└── SettingsContent

settings/general/page.tsx
└── GeneralSettingsForm
    ├── NameInput
    ├── SlugInput
    ├── DescriptionTextarea
    ├── LogoUpload
    └── SaveButton

settings/members/page.tsx
└── MembersManagement
    ├── MembersList
    │   └── MemberCard[]
    │       ├── Avatar
    │       ├── UserInfo
    │       ├── RoleBadge
    │       └── ActionsDropdown
    └── InviteMemberButton

settings/invitations/page.tsx
└── InvitationsList
    └── InvitationCard[]
        ├── Email
        ├── Role
        ├── InvitedBy
        ├── ExpiresAt
        └── CancelButton
```

---

## 5. PROJECT COMPONENTS

### 5.1 Project Detail
```
app/(app)/workspaces/[slug]/projects/[projectSlug]/page.tsx
├── ProjectHeader
│   ├── ProjectInfo
│   │   ├── Icon & Name
│   │   ├── Description
│   │   └── ColorIndicator
│   └── ProjectActions
│       ├── ArchiveButton
│       └── SettingsButton
└── BoardsList
    └── BoardCard[]
        ├── BoardName
        ├── BoardStats
        └── OpenButton
```

---

## 6. BOARD COMPONENTS (Main Kanban View)

### 6.1 Board Page
```
app/(app)/boards/[boardId]/page.tsx
├── BoardHeader
│   ├── BoardInfo
│   │   ├── Name
│   │   └── Description
│   ├── BoardFilters
│   │   ├── SearchInput
│   │   ├── FilterButton
│   │   │   └── FilterDropdown
│   │   │       ├── PriorityFilter
│   │   │       ├── AssigneeFilter
│   │   │       ├── LabelFilter
│   │   │       └── DueDateFilter
│   │   └── ViewOptions
│   └── BoardActions
│       ├── CreateTaskButton
│       ├── ManageLabelsButton
│       └── BoardMenu
├── KanbanBoard (DnD Context)
│   └── ColumnList (Sortable)
│       └── Column[] (Droppable)
│           ├── ColumnHeader
│           │   ├── Name & Color
│           │   ├── TaskCount
│           │   ├── WIPLimit
│           │   └── ColumnMenu
│           │       ├── EditColumn
│           │       ├── SetLimit
│           │       └── DeleteColumn
│           ├── TaskList (Sortable)
│           │   └── TaskCard[] (Draggable)
│           │       ├── TaskTitle
│           │       ├── TaskDescription (truncated)
│           │       ├── PriorityBadge
│           │       ├── DueDateBadge
│           │       ├── LabelBadges[]
│           │       ├── AssigneeAvatars[]
│           │       ├── CommentCount
│           │       └── AttachmentCount
│           └── AddTaskButton
└── CreateColumnButton
```

### 6.2 Task Detail Modal/Drawer
```
components/tasks/TaskDetailModal.tsx
├── TaskModalHeader
│   ├── TaskTitle (editable)
│   ├── TaskActions
│   │   ├── CompleteButton
│   │   ├── DuplicateButton
│   │   └── DeleteButton
│   └── CloseButton
├── TaskModalContent
│   ├── TaskMetaSection
│   │   ├── StatusSelect (column)
│   │   ├── PrioritySelect
│   │   ├── DueDatePicker
│   │   ├── AssigneesSelect
│   │   └── LabelsSelect
│   ├── DescriptionSection
│   │   ├── DescriptionEditor (rich text)
│   │   └── SaveButton
│   ├── AttachmentsSection
│   │   ├── AttachmentList
│   │   │   └── AttachmentItem[]
│   │   │       ├── FileIcon
│   │   │       ├── FileName
│   │   │       ├── FileSize
│   │   │       ├── DownloadButton
│   │   │       └── DeleteButton
│   │   └── UploadButton
│   ├── CommentsSection
│   │   ├── CommentList
│   │   │   └── CommentItem[]
│   │   │       ├── UserAvatar
│   │   │       ├── UserName & Timestamp
│   │   │       ├── CommentContent
│   │   │       ├── ReplyButton
│   │   │       ├── EditButton (if owner)
│   │   │       ├── DeleteButton (if owner)
│   │   │       └── Replies[]
│   │   └── CommentForm
│   │       ├── RichTextEditor
│   │       └── SubmitButton
│   └── ActivitySection
│       └── ActivityTimeline
│           └── ActivityItem[]
│               ├── UserAvatar
│               ├── ActivityDescription
│               └── Timestamp
└── TaskModalFooter
    ├── CreatedInfo
    └── LastUpdatedInfo
```

---

## 7. SHARED UI COMPONENTS

### 7.1 Navigation Components
```
components/navigation/TopNavigation.tsx
├── Logo
├── WorkspaceSwitcher
│   └── WorkspaceDropdown
│       ├── CurrentWorkspace
│       ├── WorkspaceList
│       │   └── WorkspaceItem[]
│       └── CreateWorkspaceButton
├── GlobalSearch
│   └── SearchModal
│       ├── SearchInput
│       ├── SearchFilters
│       └── SearchResults
│           ├── TaskResults[]
│           ├── ProjectResults[]
│           └── BoardResults[]
├── NotificationBell
│   └── NotificationsDropdown
│       ├── NotificationsList
│       │   └── NotificationItem[]
│       │       ├── NotificationIcon
│       │       ├── NotificationMessage
│       │       ├── Timestamp
│       │       └── MarkReadButton
│       └── ViewAllLink
└── UserMenu
    └── UserDropdown
        ├── UserInfo
        ├── ProfileLink
        ├── SettingsLink
        ├── ThemeToggle
        └── LogoutButton

components/navigation/Sidebar.tsx
├── WorkspaceInfo
│   ├── Logo
│   └── Name
├── NavigationMenu
│   ├── DashboardLink
│   ├── ProjectsList
│   │   ├── ProjectsHeader
│   │   └── ProjectItem[] (collapsible)
│   │       ├── ProjectName
│   │       └── BoardsList
│   │           └── BoardLink[]
│   └── SettingsLink
└── CreateButton
```

### 7.2 Form Components
```
components/forms/
├── Input.tsx
├── Textarea.tsx
├── Select.tsx
├── Checkbox.tsx
├── RadioGroup.tsx
├── DatePicker.tsx
├── TimePicker.tsx
├── ColorPicker.tsx
├── FileUpload.tsx
├── RichTextEditor.tsx
└── FormField.tsx (wrapper)
```

### 7.3 Data Display Components
```
components/ui/
├── Avatar.tsx
├── AvatarGroup.tsx
├── Badge.tsx
├── Card.tsx
├── EmptyState.tsx
├── ErrorState.tsx
├── LoadingSpinner.tsx
├── ProgressBar.tsx
├── Tooltip.tsx
├── Popover.tsx
└── Skeleton.tsx
```

### 7.4 Feedback Components
```
components/feedback/
├── Toast.tsx
├── Alert.tsx
├── ConfirmDialog.tsx
└── LoadingOverlay.tsx
```

### 7.5 Modal Components
```
components/modals/
├── Modal.tsx (base)
├── CreateWorkspaceModal.tsx
├── CreateProjectModal.tsx
├── CreateBoardModal.tsx
├── CreateTaskModal.tsx
├── InviteMemberModal.tsx
├── ManageLabelsModal.tsx
├── TaskDetailModal.tsx
└── ConfirmDeleteModal.tsx
```

### 7.6 Dropdown Components
```
components/dropdowns/
├── Dropdown.tsx (base)
├── ActionsDropdown.tsx
├── FilterDropdown.tsx
├── PriorityDropdown.tsx
└── AssigneeDropdown.tsx
```

---

## 8. FEATURE-SPECIFIC COMPONENTS

### 8.1 Drag & Drop Components
```
components/dnd/
├── DndContext.tsx
├── Draggable.tsx
├── Droppable.tsx
├── SortableList.tsx
└── DragOverlay.tsx
```

### 8.2 Search Components
```
components/search/
├── GlobalSearch.tsx
├── SearchInput.tsx
├── SearchFilters.tsx
└── SearchResults.tsx
    ├── TaskResult.tsx
    ├── ProjectResult.tsx
    └── BoardResult.tsx
```

### 8.3 Activity Components
```
components/activity/
├── ActivityFeed.tsx
├── ActivityItem.tsx
├── ActivityIcon.tsx
└── ActivityFilter.tsx
```

### 8.4 Stats Components
```
components/stats/
├── StatCard.tsx
├── StatsGrid.tsx
├── Chart.tsx (if needed)
└── ProgressRing.tsx
```

---

## 9. CUSTOM HOOKS

```
hooks/
├── auth/
│   ├── useAuth.ts
│   ├── useLogin.ts
│   ├── useRegister.ts
│   └── useLogout.ts
├── api/
│   ├── useWorkspaces.ts
│   ├── useProjects.ts
│   ├── useBoards.ts
│   ├── useTasks.ts
│   ├── useComments.ts
│   └── useActivities.ts
├── mutations/
│   ├── useCreateTask.ts
│   ├── useUpdateTask.ts
│   ├── useMoveTask.ts
│   └── useDeleteTask.ts
├── realtime/
│   ├── useEcho.ts
│   ├── useBoardChannel.ts
│   └── useNotifications.ts
├── ui/
│   ├── useModal.ts
│   ├── useToast.ts
│   ├── useConfirm.ts
│   └── useDebounce.ts
└── utils/
    ├── useMediaQuery.ts
    ├── useLocalStorage.ts
    └── useClickOutside.ts
```

---

## 10. STATE MANAGEMENT

### 10.1 Zustand Stores
```
stores/
├── authStore.ts
│   ├── user
│   ├── token
│   ├── login()
│   └── logout()
├── workspaceStore.ts
│   ├── currentWorkspace
│   ├── setCurrentWorkspace()
│   └── clearWorkspace()
├── boardStore.ts
│   ├── board
│   ├── columns
│   ├── tasks
│   ├── filters
│   ├── setFilters()
│   └── clearFilters()
└── uiStore.ts
    ├── sidebarOpen
    ├── theme
    ├── toggleSidebar()
    └── setTheme()
```

### 10.2 React Query Keys
```
lib/queryKeys.ts
├── workspaces
│   ├── all
│   ├── detail(slug)
│   └── members(slug)
├── projects
│   ├── byWorkspace(workspaceId)
│   └── detail(projectId)
├── boards
│   ├── byProject(projectId)
│   └── detail(boardId)
├── tasks
│   ├── byBoard(boardId)
│   ├── detail(taskId)
│   ├── comments(taskId)
│   └── attachments(taskId)
└── notifications
    ├── all
    └── unread
```

---

## 11. RESPONSIVE DESIGN

### Breakpoints (Tailwind)
```
sm: 640px   // Mobile landscape
md: 768px   // Tablet
lg: 1024px  // Desktop
xl: 1280px  // Large desktop
2xl: 1536px // Extra large
```

### Component Behavior
```
Mobile (< md):
- Sidebar: Drawer overlay
- Board: Horizontal scroll
- TaskCard: Compact view
- Filters: Bottom sheet

Tablet (md - lg):
- Sidebar: Collapsible
- Board: 2-3 columns visible
- TaskCard: Standard view

Desktop (> lg):
- Sidebar: Persistent
- Board: All columns visible
- TaskCard: Full details
- Multi-column layouts
```

---

## 12. COMPONENT COMPOSITION PATTERNS

### Example: TaskCard Composition
```tsx
// Flexible composition with slots
<TaskCard>
  <TaskCard.Header>
    <TaskCard.Title />
    <TaskCard.Actions />
  </TaskCard.Header>
  <TaskCard.Content>
    <TaskCard.Description />
    <TaskCard.Meta>
      <TaskCard.Priority />
      <TaskCard.DueDate />
    </TaskCard.Meta>
  </TaskCard.Content>
  <TaskCard.Footer>
    <TaskCard.Labels />
    <TaskCard.Assignees />
    <TaskCard.Stats />
  </TaskCard.Footer>
</TaskCard>
```

### Example: Form Pattern with React Hook Form
```tsx
<Form onSubmit={handleSubmit}>
  <FormField
    name="title"
    label="Task Title"
    error={errors.title}
  >
    <Input {...register("title")} />
  </FormField>

  <FormField
    name="priority"
    label="Priority"
    error={errors.priority}
  >
    <PrioritySelect {...register("priority")} />
  </FormField>

  <FormActions>
    <Button type="button" variant="ghost">Cancel</Button>
    <Button type="submit">Save</Button>
  </FormActions>
</Form>
```

---

## 13. ACCESSIBILITY CONSIDERATIONS

- All interactive elements have proper ARIA labels
- Keyboard navigation support (Tab, Enter, Esc, Arrow keys)
- Focus management in modals and dropdowns
- Screen reader announcements for dynamic content
- Color contrast compliance (WCAG AA)
- Skip navigation links
- Semantic HTML structure

---

## Component File Organization

```
components/
├── ui/              # Primitive UI components (Shadcn)
├── forms/           # Form inputs and controls
├── navigation/      # Navigation components
├── layouts/         # Layout components
├── modals/          # Modal dialogs
├── dropdowns/       # Dropdown menus
├── boards/          # Board-specific components
├── tasks/           # Task-specific components
├── comments/        # Comment components
├── activity/        # Activity feed components
├── stats/           # Statistics components
├── search/          # Search components
└── shared/          # Other shared components
```

Each component follows this structure:
```
ComponentName/
├── ComponentName.tsx        # Main component
├── ComponentName.types.ts   # TypeScript types
├── ComponentName.test.tsx   # Tests
└── index.ts                 # Export
```

---

This hierarchy provides a scalable, maintainable structure for building the TaskFlow frontend with Next.js, React, and TypeScript.
