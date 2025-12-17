# TaskFlow

A full-stack project management app inspired by Trello and Asana. Built this to showcase my skills with Laravel and Next.js while learning some cool stuff about real-time features and drag-and-drop.

![TaskFlow](https://img.shields.io/badge/status-in%20development-blue)
![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel)
![Next.js](https://img.shields.io/badge/Next.js-16-000000?logo=next.js)
![TypeScript](https://img.shields.io/badge/TypeScript-5-3178C6?logo=typescript)

## What is this?

TaskFlow is basically a Kanban board app where teams can manage projects, tasks, and collaborate in real-time. Think Trello but with some extra features I wanted to try implementing like time tracking and custom fields.

The whole thing runs on Laravel for the backend (with WebSockets for real-time stuff) and Next.js with TypeScript on the frontend.

- Multiple workspaces to keep different teams/projects separated
- Projects with Kanban boards (drag & drop with @hello-pangea/dnd)
- Real-time updates using Laravel Reverb (WebSockets)
- Tasks with subtasks, checklists, labels, priorities, due dates
- Comments, file attachments, @mentions
- Activity tracking so you can see who did what
- Time tracking (planning to add reporting here too)
- Role-based permissions for workspaces and projects
- Responsive UI built with Tailwind CSS and Radix UI

## Tech Stack

**Backend:**
- Laravel 11 (PHP 8.3)
- MySQL for data, Redis for caching
- Laravel Reverb for WebSockets
- Sanctum for auth
- RESTful API

**Frontend:**
- Next.js 16 with App Router
- TypeScript + React 19
- Tailwind CSS + Radix UI components
- Zustand for state management
- React Query (TanStack) for server state
- React Hook Form + Zod for forms
- @hello-pangea/dnd for drag & drop

## Documentation

More details in the `docs/` folder:

- [API Endpoints](docs/api-endpoints.md)
- [Database Schema](docs/database-schema.md)
- [Frontend Components](docs/frontend-component-hierarchy.md)
- [Implementation Guide](docs/TASKFLOW-IMPLEMENTATION-GUIDE.md)

**Work in Progress** - actively building out features
