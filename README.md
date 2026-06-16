# Micro-Connect

A robust micro-blogging backend platform built with Laravel MVC, focusing on scalable architecture, database optimization, and secure access control.

## 🚀 Core Features & Architecture

* **Scalable OAuth 2.0 Integration:** Flexible multi-provider authentication (Google & GitHub) using Laravel Socialite with a decoupled database schema.
* **Request Lifecycle & Validation:** Clean isolation of validation profiles using specialized Form Requests to reduce code duplication.
* **Granular Access Control:** Robust security enforced through custom Laravel Policies and standard middleware.
* **Asynchronous Polymorphic Engagement:** A unified "Like" system utilizing a Polymorphic (Morph) database relationship across posts and comments via async RESTful API endpoints.

## 🛠️ Tech Stack
* **Backend:** PHP (Laravel MVC)
* **Database:** MySQL
* **Frontend:** Alpine.js, Tailwind CSS
