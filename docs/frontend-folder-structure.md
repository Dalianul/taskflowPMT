# TaskFlow - Frontend (Next.js) Folder Structure

## Complete Directory Tree

```
frontend/
├── public/
│   ├── images/
│   │   ├── logo.svg
│   │   ├── logo-dark.svg
│   │   ├── auth-bg.jpg
│   │   └── empty-states/
│   │       ├── no-tasks.svg
│   │       ├── no-projects.svg
│   │       └── no-workspaces.svg
│   ├── fonts/
│   │   └── (custom fonts if any)
│   ├── favicon.ico
│   ├── manifest.json
│   └── robots.txt
│
├── src/
│   ├── app/                             # Next.js 15 App Router
│   │   ├── (auth)/                      # Auth route group
│   │   │   ├── layout.tsx               # Auth layout (centered card)
│   │   │   ├── login/
│   │   │   │   └── page.tsx
│   │   │   ├── register/
│   │   │   │   └── page.tsx
│   │   │   ├── forgot-password/
│   │   │   │   └── page.tsx
│   │   │   └── reset-password/
│   │   │       └── page.tsx
│   │   │
│   │   ├── (app)/                       # Protected app routes
│   │   │   ├── layout.tsx               # App layout (nav + sidebar)
│   │   │   ├── dashboard/
│   │   │   │   └── page.tsx
│   │   │   ├── workspaces/
│   │   │   │   ├── page.tsx             # List all workspaces
│   │   │   │   └── [slug]/
│   │   │   │       ├── page.tsx         # Workspace detail
│   │   │   │       ├── settings/
│   │   │   │       │   ├── layout.tsx   # Settings sidebar
│   │   │   │       │   ├── general/
│   │   │   │       │   │   └── page.tsx
│   │   │   │       │   ├── members/
│   │   │   │       │   │   └── page.tsx
│   │   │   │       │   └── invitations/
│   │   │   │       │       └── page.tsx
│   │   │   │       └── projects/
│   │   │   │           ├── page.tsx     # Projects list
│   │   │   │           └── [projectSlug]/
│   │   │   │               └── page.tsx # Project detail
│   │   │   ├── boards/
│   │   │   │   └── [boardId]/
│   │   │   │       └── page.tsx         # Kanban board view
│   │   │   ├── profile/
│   │   │   │   └── page.tsx
│   │   │   └── settings/
│   │   │       └── page.tsx
│   │   │
│   │   ├── invitations/
│   │   │   └── [token]/
│   │   │       └── page.tsx             # Accept invitation (public)
│   │   │
│   │   ├── api/                         # API routes (if needed)
│   │   │   └── test/
│   │   │       └── route.ts
│   │   │
│   │   ├── layout.tsx                   # Root layout
│   │   ├── page.tsx                     # Landing page
│   │   ├── loading.tsx                  # Global loading
│   │   ├── error.tsx                    # Global error
│   │   └── not-found.tsx                # 404 page
│   │
│   ├── components/                      # React components
│   │   ├── ui/                          # Shadcn/ui primitives
│   │   │   ├── button.tsx
│   │   │   ├── input.tsx
│   │   │   ├── label.tsx
│   │   │   ├── textarea.tsx
│   │   │   ├── select.tsx
│   │   │   ├── checkbox.tsx
│   │   │   ├── radio-group.tsx
│   │   │   ├── card.tsx
│   │   │   ├── avatar.tsx
│   │   │   ├── badge.tsx
│   │   │   ├── dialog.tsx
│   │   │   ├── dropdown-menu.tsx
│   │   │   ├── popover.tsx
│   │   │   ├── tooltip.tsx
│   │   │   ├── toast.tsx
│   │   │   ├── alert.tsx
│   │   │   ├── progress.tsx
│   │   │   ├── skeleton.tsx
│   │   │   ├── separator.tsx
│   │   │   ├── tabs.tsx
│   │   │   ├── calendar.tsx
│   │   │   └── command.tsx
│   │   │
│   │   ├── forms/                       # Form components
│   │   │   ├── form-field.tsx
│   │   │   ├── color-picker.tsx
│   │   │   ├── date-picker.tsx
│   │   │   ├── time-picker.tsx
│   │   │   ├── file-upload.tsx
│   │   │   ├── rich-text-editor.tsx
│   │   │   ├── user-select.tsx
│   │   │   ├── priority-select.tsx
│   │   │   └── label-select.tsx
│   │   │
│   │   ├── layouts/                     # Layout components
│   │   │   ├── app-layout.tsx
│   │   │   ├── auth-layout.tsx
│   │   │   ├── top-navigation.tsx
│   │   │   ├── sidebar.tsx
│   │   │   └── settings-sidebar.tsx
│   │   │
│   │   ├── navigation/                  # Navigation components
│   │   │   ├── top-nav/
│   │   │   │   ├── index.tsx
│   │   │   │   ├── workspace-switcher.tsx
│   │   │   │   ├── global-search.tsx
│   │   │   │   ├── notifications-dropdown.tsx
│   │   │   │   └── user-menu.tsx
│   │   │   └── sidebar/
│   │   │       ├── index.tsx
│   │   │       ├── nav-menu.tsx
│   │   │       ├── projects-list.tsx
│   │   │       └── create-button.tsx
│   │   │
│   │   ├── auth/                        # Auth components
│   │   │   ├── login-form.tsx
│   │   │   ├── register-form.tsx
│   │   │   ├── forgot-password-form.tsx
│   │   │   ├── reset-password-form.tsx
│   │   │   └── auth-guard.tsx
│   │   │
│   │   ├── dashboard/                   # Dashboard components
│   │   │   ├── stats-grid.tsx
│   │   │   ├── stat-card.tsx
│   │   │   ├── my-tasks.tsx
│   │   │   ├── recent-activity.tsx
│   │   │   └── upcoming-deadlines.tsx
│   │   │
│   │   ├── workspaces/                  # Workspace components
│   │   │   ├── workspace-card.tsx
│   │   │   ├── workspace-grid.tsx
│   │   │   ├── workspace-header.tsx
│   │   │   ├── workspace-form.tsx
│   │   │   ├── member-card.tsx
│   │   │   ├── members-list.tsx
│   │   │   ├── invitation-card.tsx
│   │   │   └── invite-member-form.tsx
│   │   │
│   │   ├── projects/                    # Project components
│   │   │   ├── project-card.tsx
│   │   │   ├── project-grid.tsx
│   │   │   ├── project-header.tsx
│   │   │   ├── project-form.tsx
│   │   │   └── project-stats.tsx
│   │   │
│   │   ├── boards/                      # Board components
│   │   │   ├── board-header.tsx
│   │   │   ├── board-filters.tsx
│   │   │   ├── kanban-board.tsx
│   │   │   ├── column.tsx
│   │   │   ├── column-header.tsx
│   │   │   ├── add-column-button.tsx
│   │   │   └── board-settings.tsx
│   │   │
│   │   ├── columns/                     # Column components
│   │   │   ├── column-form.tsx
│   │   │   └── column-menu.tsx
│   │   │
│   │   ├── labels/                      # Label components
│   │   │   ├── label-badge.tsx
│   │   │   ├── label-form.tsx
│   │   │   ├── label-list.tsx
│   │   │   └── manage-labels-modal.tsx
│   │   │
│   │   ├── tasks/                       # Task components
│   │   │   ├── task-card.tsx
│   │   │   ├── task-list.tsx
│   │   │   ├── task-form.tsx
│   │   │   ├── task-detail-modal.tsx
│   │   │   ├── task-detail/
│   │   │   │   ├── task-header.tsx
│   │   │   │   ├── task-meta.tsx
│   │   │   │   ├── task-description.tsx
│   │   │   │   ├── task-assignees.tsx
│   │   │   │   ├── task-labels.tsx
│   │   │   │   └── task-dates.tsx
│   │   │   ├── priority-badge.tsx
│   │   │   └── due-date-badge.tsx
│   │   │
│   │   ├── comments/                    # Comment components
│   │   │   ├── comment-list.tsx
│   │   │   ├── comment-item.tsx
│   │   │   ├── comment-form.tsx
│   │   │   └── comment-reply.tsx
│   │   │
│   │   ├── attachments/                 # Attachment components
│   │   │   ├── attachment-list.tsx
│   │   │   ├── attachment-item.tsx
│   │   │   └── attachment-upload.tsx
│   │   │
│   │   ├── activity/                    # Activity components
│   │   │   ├── activity-feed.tsx
│   │   │   ├── activity-item.tsx
│   │   │   ├── activity-icon.tsx
│   │   │   └── activity-filter.tsx
│   │   │
│   │   ├── search/                      # Search components
│   │   │   ├── global-search.tsx
│   │   │   ├── search-input.tsx
│   │   │   ├── search-modal.tsx
│   │   │   ├── search-filters.tsx
│   │   │   └── search-results.tsx
│   │   │
│   │   ├── notifications/               # Notification components
│   │   │   ├── notifications-bell.tsx
│   │   │   ├── notifications-dropdown.tsx
│   │   │   ├── notification-item.tsx
│   │   │   └── notification-list.tsx
│   │   │
│   │   ├── modals/                      # Modal components
│   │   │   ├── create-workspace-modal.tsx
│   │   │   ├── create-project-modal.tsx
│   │   │   ├── create-board-modal.tsx
│   │   │   ├── create-task-modal.tsx
│   │   │   ├── invite-member-modal.tsx
│   │   │   └── confirm-dialog.tsx
│   │   │
│   │   ├── dnd/                         # Drag and drop
│   │   │   ├── dnd-context.tsx
│   │   │   ├── draggable.tsx
│   │   │   ├── droppable.tsx
│   │   │   └── sortable-list.tsx
│   │   │
│   │   └── shared/                      # Shared components
│   │       ├── logo.tsx
│   │       ├── avatar-group.tsx
│   │       ├── empty-state.tsx
│   │       ├── error-state.tsx
│   │       ├── loading-spinner.tsx
│   │       ├── page-header.tsx
│   │       ├── color-dot.tsx
│   │       └── user-avatar.tsx
│   │
│   ├── hooks/                           # Custom React hooks
│   │   ├── auth/
│   │   │   ├── use-auth.ts
│   │   │   ├── use-login.ts
│   │   │   ├── use-register.ts
│   │   │   └── use-logout.ts
│   │   ├── api/
│   │   │   ├── use-workspaces.ts
│   │   │   ├── use-workspace.ts
│   │   │   ├── use-projects.ts
│   │   │   ├── use-project.ts
│   │   │   ├── use-boards.ts
│   │   │   ├── use-board.ts
│   │   │   ├── use-tasks.ts
│   │   │   ├── use-task.ts
│   │   │   ├── use-comments.ts
│   │   │   ├── use-attachments.ts
│   │   │   ├── use-activities.ts
│   │   │   └── use-notifications.ts
│   │   ├── mutations/
│   │   │   ├── use-create-workspace.ts
│   │   │   ├── use-create-project.ts
│   │   │   ├── use-create-board.ts
│   │   │   ├── use-create-task.ts
│   │   │   ├── use-update-task.ts
│   │   │   ├── use-move-task.ts
│   │   │   ├── use-delete-task.ts
│   │   │   ├── use-create-comment.ts
│   │   │   └── use-upload-attachment.ts
│   │   ├── realtime/
│   │   │   ├── use-echo.ts
│   │   │   ├── use-board-channel.ts
│   │   │   ├── use-task-channel.ts
│   │   │   └── use-user-channel.ts
│   │   ├── ui/
│   │   │   ├── use-modal.ts
│   │   │   ├── use-toast.ts
│   │   │   ├── use-confirm.ts
│   │   │   └── use-disclosure.ts
│   │   └── utils/
│   │       ├── use-debounce.ts
│   │       ├── use-throttle.ts
│   │       ├── use-media-query.ts
│   │       ├── use-local-storage.ts
│   │       ├── use-click-outside.ts
│   │       └── use-copy-to-clipboard.ts
│   │
│   ├── lib/                             # Utility libraries
│   │   ├── api/
│   │   │   ├── client.ts                # Axios instance
│   │   │   ├── auth.ts                  # Auth API calls
│   │   │   ├── workspaces.ts
│   │   │   ├── projects.ts
│   │   │   ├── boards.ts
│   │   │   ├── tasks.ts
│   │   │   ├── comments.ts
│   │   │   ├── attachments.ts
│   │   │   └── notifications.ts
│   │   ├── echo.ts                      # Laravel Echo config
│   │   ├── query-keys.ts                # React Query keys
│   │   ├── utils.ts                     # General utilities
│   │   ├── cn.ts                        # Class name merger (clsx + tailwind-merge)
│   │   ├── date.ts                      # Date utilities
│   │   ├── format.ts                    # Formatters
│   │   └── validation.ts                # Validation helpers
│   │
│   ├── stores/                          # Zustand stores
│   │   ├── auth-store.ts
│   │   ├── workspace-store.ts
│   │   ├── board-store.ts
│   │   ├── ui-store.ts
│   │   └── index.ts
│   │
│   ├── types/                           # TypeScript types
│   │   ├── index.ts
│   │   ├── api.ts                       # API response types
│   │   ├── models.ts                    # Data models
│   │   ├── auth.ts
│   │   ├── workspace.ts
│   │   ├── project.ts
│   │   ├── board.ts
│   │   ├── task.ts
│   │   ├── comment.ts
│   │   ├── attachment.ts
│   │   ├── activity.ts
│   │   └── notification.ts
│   │
│   ├── contexts/                        # React contexts
│   │   ├── auth-context.tsx
│   │   ├── workspace-context.tsx
│   │   ├── board-context.tsx
│   │   └── theme-context.tsx
│   │
│   ├── providers/                       # Provider components
│   │   ├── auth-provider.tsx
│   │   ├── query-provider.tsx
│   │   ├── theme-provider.tsx
│   │   ├── toast-provider.tsx
│   │   └── echo-provider.tsx
│   │
│   ├── config/                          # Configuration
│   │   ├── site.ts                      # Site metadata
│   │   ├── routes.ts                    # Route constants
│   │   └── constants.ts                 # App constants
│   │
│   ├── schemas/                         # Zod validation schemas
│   │   ├── auth.ts
│   │   ├── workspace.ts
│   │   ├── project.ts
│   │   ├── board.ts
│   │   ├── task.ts
│   │   └── comment.ts
│   │
│   ├── styles/                          # Global styles
│   │   ├── globals.css
│   │   └── theme.css
│   │
│   └── middleware.ts                    # Next.js middleware (auth)
│
├── .env.local                           # Environment variables
├── .env.example
├── .eslintrc.json
├── .gitignore
├── components.json                      # Shadcn config
├── next.config.ts
├── next-env.d.ts
├── package.json
├── package-lock.json
├── postcss.config.mjs
├── README.md
├── tailwind.config.ts
└── tsconfig.json
```

---

## Key Directories Explanation

### 1. **src/app/**
Next.js 15 App Router with route groups for auth and protected routes.

### 2. **src/components/**
All React components organized by domain and feature.

#### **ui/**
Shadcn/ui components (installed via CLI).

#### **forms/**
Reusable form components with validation.

#### **layouts/**
Page layout components.

#### **[feature]/**
Feature-specific components (workspaces, projects, boards, tasks).

### 3. **src/hooks/**
Custom React hooks organized by purpose:
- **api/**: Data fetching hooks (React Query)
- **mutations/**: Data mutation hooks
- **realtime/**: WebSocket hooks
- **ui/**: UI interaction hooks
- **utils/**: Utility hooks

### 4. **src/lib/**
Core libraries and utilities:
- **api/**: API client and endpoint functions
- **echo.ts**: Laravel Echo configuration
- **query-keys.ts**: Centralized React Query keys
- **utils.ts**: Helper functions

### 5. **src/stores/**
Zustand stores for global state management.

### 6. **src/types/**
TypeScript type definitions matching backend models.

### 7. **src/providers/**
React context providers for:
- Authentication
- React Query
- Theme (dark/light mode)
- Toast notifications
- Laravel Echo (WebSockets)

### 8. **src/schemas/**
Zod validation schemas for forms.

---

## Configuration Files

### next.config.ts
```typescript
import type { NextConfig } from 'next';

const nextConfig: NextConfig = {
  images: {
    domains: ['localhost', 'storage.taskflow.com'],
  },
  env: {
    NEXT_PUBLIC_API_URL: process.env.NEXT_PUBLIC_API_URL,
    NEXT_PUBLIC_WS_HOST: process.env.NEXT_PUBLIC_WS_HOST,
  },
};

export default nextConfig;
```

### .env.local
```env
NEXT_PUBLIC_API_URL=http://localhost:8000/api
NEXT_PUBLIC_WS_HOST=localhost
NEXT_PUBLIC_WS_PORT=8080
NEXT_PUBLIC_WS_KEY=your-reverb-key
NEXT_PUBLIC_APP_URL=http://localhost:3000
```

### tailwind.config.ts
```typescript
import type { Config } from 'tailwindcss';

const config: Config = {
  darkMode: ['class'],
  content: [
    './src/pages/**/*.{js,ts,jsx,tsx,mdx}',
    './src/components/**/*.{js,ts,jsx,tsx,mdx}',
    './src/app/**/*.{js,ts,jsx,tsx,mdx}',
  ],
  theme: {
    extend: {
      colors: {
        border: 'hsl(var(--border))',
        input: 'hsl(var(--input))',
        ring: 'hsl(var(--ring))',
        background: 'hsl(var(--background))',
        foreground: 'hsl(var(--foreground))',
        primary: {
          DEFAULT: 'hsl(var(--primary))',
          foreground: 'hsl(var(--primary-foreground))',
        },
        // ... Shadcn color system
      },
    },
  },
  plugins: [require('tailwindcss-animate')],
};

export default config;
```

### components.json (Shadcn)
```json
{
  "$schema": "https://ui.shadcn.com/schema.json",
  "style": "default",
  "rsc": true,
  "tsx": true,
  "tailwind": {
    "config": "tailwind.config.ts",
    "css": "src/styles/globals.css",
    "baseColor": "slate",
    "cssVariables": true
  },
  "aliases": {
    "components": "@/components",
    "utils": "@/lib/utils"
  }
}
```

### tsconfig.json
```json
{
  "compilerOptions": {
    "target": "ES2020",
    "lib": ["ES2020", "DOM", "DOM.Iterable"],
    "jsx": "preserve",
    "module": "ESNext",
    "moduleResolution": "bundler",
    "resolveJsonModule": true,
    "allowJs": true,
    "strict": true,
    "noEmit": true,
    "esModuleInterop": true,
    "skipLibCheck": true,
    "allowSyntheticDefaultImports": true,
    "forceConsistentCasingInFileNames": true,
    "incremental": true,
    "paths": {
      "@/*": ["./src/*"]
    },
    "plugins": [
      {
        "name": "next"
      }
    ]
  },
  "include": ["next-env.d.ts", "**/*.ts", "**/*.tsx", ".next/types/**/*.ts"],
  "exclude": ["node_modules"]
}
```

---

## Example File Contents

### src/lib/api/client.ts
```typescript
import axios from 'axios';

const apiClient = axios.create({
  baseURL: process.env.NEXT_PUBLIC_API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true,
});

// Add auth token to requests
apiClient.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Handle 401 responses
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('auth_token');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

export default apiClient;
```

### src/lib/echo.ts
```typescript
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

declare global {
  interface Window {
    Pusher: typeof Pusher;
    Echo: Echo;
  }
}

window.Pusher = Pusher;

const echo = new Echo({
  broadcaster: 'reverb',
  key: process.env.NEXT_PUBLIC_WS_KEY,
  wsHost: process.env.NEXT_PUBLIC_WS_HOST,
  wsPort: parseInt(process.env.NEXT_PUBLIC_WS_PORT || '8080'),
  wssPort: parseInt(process.env.NEXT_PUBLIC_WS_PORT || '8080'),
  forceTLS: false,
  enabledTransports: ['ws', 'wss'],
  authEndpoint: `${process.env.NEXT_PUBLIC_API_URL}/broadcasting/auth`,
  auth: {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
    },
  },
});

export default echo;
```

### src/hooks/api/use-board.ts
```typescript
import { useQuery } from '@tanstack/react-query';
import { getBoard } from '@/lib/api/boards';
import { queryKeys } from '@/lib/query-keys';

export function useBoard(boardId: number) {
  return useQuery({
    queryKey: queryKeys.boards.detail(boardId),
    queryFn: () => getBoard(boardId),
    enabled: !!boardId,
  });
}
```

### src/types/task.ts
```typescript
export interface Task {
  id: number;
  column_id: number;
  board_id: number;
  title: string;
  description?: string;
  position: number;
  priority?: 'low' | 'medium' | 'high' | 'urgent';
  due_date?: string;
  completed_at?: string;
  assignees: User[];
  labels: Label[];
  comments_count: number;
  attachments_count: number;
  created_by: User;
  created_at: string;
  updated_at: string;
}

export interface CreateTaskDto {
  title: string;
  description?: string;
  priority?: Task['priority'];
  due_date?: string;
  assignees?: number[];
  labels?: number[];
}
```

---

## Package Dependencies

### package.json
```json
{
  "name": "taskflow-frontend",
  "version": "0.1.0",
  "private": true,
  "scripts": {
    "dev": "next dev",
    "build": "next build",
    "start": "next start",
    "lint": "next lint"
  },
  "dependencies": {
    "@dnd-kit/core": "^6.1.0",
    "@dnd-kit/sortable": "^8.0.0",
    "@dnd-kit/utilities": "^3.2.2",
    "@radix-ui/react-avatar": "^1.0.4",
    "@radix-ui/react-checkbox": "^1.0.4",
    "@radix-ui/react-dialog": "^1.0.5",
    "@radix-ui/react-dropdown-menu": "^2.0.6",
    "@radix-ui/react-label": "^2.0.2",
    "@radix-ui/react-popover": "^1.0.7",
    "@radix-ui/react-select": "^2.0.0",
    "@radix-ui/react-tabs": "^1.0.4",
    "@radix-ui/react-tooltip": "^1.0.7",
    "@tanstack/react-query": "^5.17.0",
    "axios": "^1.6.5",
    "class-variance-authority": "^0.7.0",
    "clsx": "^2.1.0",
    "date-fns": "^3.0.6",
    "laravel-echo": "^1.16.1",
    "lucide-react": "^0.309.0",
    "next": "^15.0.0",
    "pusher-js": "^8.4.0-rc2",
    "react": "^18.3.1",
    "react-dom": "^18.3.1",
    "react-hook-form": "^7.49.3",
    "sonner": "^1.3.1",
    "tailwind-merge": "^2.2.0",
    "tailwindcss-animate": "^1.0.7",
    "zod": "^3.22.4",
    "zustand": "^4.4.7"
  },
  "devDependencies": {
    "@types/node": "^20",
    "@types/react": "^18",
    "@types/react-dom": "^18",
    "autoprefixer": "^10.4.16",
    "eslint": "^8",
    "eslint-config-next": "^15.0.0",
    "postcss": "^8",
    "tailwindcss": "^3.4.1",
    "typescript": "^5"
  }
}
```

---

## Installation Steps

1. **Install Shadcn/ui:**
```bash
npx shadcn-ui@latest init
```

2. **Add Components:**
```bash
npx shadcn-ui@latest add button input label textarea select
npx shadcn-ui@latest add card avatar badge dialog dropdown-menu
npx shadcn-ui@latest add popover tooltip toast alert calendar
```

3. **Install Additional Dependencies:**
```bash
npm install @tanstack/react-query axios zustand
npm install @dnd-kit/core @dnd-kit/sortable @dnd-kit/utilities
npm install laravel-echo pusher-js
npm install react-hook-form zod date-fns
npm install lucide-react sonner
```

---

## Code Organization Best Practices

1. **Colocate related files** - Keep component, types, and tests together
2. **Use barrel exports** - index.ts files for cleaner imports
3. **Type everything** - Full TypeScript coverage
4. **Consistent naming** - kebab-case for files, PascalCase for components
5. **Single responsibility** - Keep components focused
6. **Composition over complexity** - Small, composable components

---

This structure provides a scalable, type-safe, and maintainable Next.js frontend ready for production.
