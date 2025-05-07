# Task Management Application

This is a **Task Management Application** built with **Laravel 12** and **Vue 3** using **Inertia.js** and **TailwindCSS**. It allows users to manage tasks efficiently by creating, updating, deleting, and reordering tasks with a smooth drag-and-drop interface. Each task can be associated with a specific project, and tasks are filtered accordingly.

## 🚀 Features

* Create, Update, and Delete tasks
* Drag-and-drop reorder of tasks
* Project-based filtering of tasks
* Responsive design with TailwindCSS
* Real-time updates with Inertia.js
* Permission-based access control with Spatie Permissions

## 🛠️ Technologies Used

* **Laravel 12** - Backend framework
* **Vue 3** - Frontend framework
* **Inertia.js** - For frontend-backend communication
* **TailwindCSS** - For styling
* **Vue Draggable Next** - For drag-and-drop functionality
* **MySQL** - Database
* **Spatie Laravel Permission** - Role and Permission management

## 📦 Installation

1. **Clone the repository**:

```bash
    git clone https://github.com/your-repo/task-manager.git
    cd task-manager
```

2. **Install dependencies**:

```bash
    composer install
    npm install
```

3. **Create `.env` file**:

```bash
    cp .env.example .env
```

4. **Generate application key**:

```bash
    php artisan key:generate
```

5. **Configure your database** in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

6. **Run database migrations**:

```bash
    php artisan migrate
```

7. **Launch the application**:

```bash
    npm run dev
    php artisan serve
```

Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

## 📝 Usage

* Navigate to the dashboard.
* Create a new project and add tasks.
* Drag and drop tasks to reorder them.
* Edit or delete tasks as needed.
* Filter tasks by project using the dropdown menu.

## 🧪 Testing

To run tests:

```bash
    php artisan test
```

All tests are located in the `tests/Feature` and `tests/Unit` directories.

## 🚀 Deployment

To deploy the application:

1. **Build assets**:

```bash
    npm run build
```

2. **Migrate the database**:

```bash
    php artisan migrate --force
```

3. **Run the application**:

```bash
    php artisan serve --env=production
```

## 👥 Contributing

Feel free to submit pull requests or open issues for improvements.

## 📜 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---


### ℹ️ Notes

Ensure that your database is properly configured before running migrations. If you encounter any issues, check your `.env` configuration and database connections.
