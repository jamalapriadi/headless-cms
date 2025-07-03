# 📚 Headless CMS – Laravel + Livewire

This is a **Content Management System** project built with Laravel 12, Livewire, TailwindCSS, and Swagger (OpenAPI) for API documentation.

---

## 🚀 Features
- Laravel 12 + Livewire (TALL Stack)
- Content Management for Posts, Pages and Categories
- Integrated Media Library
- Multi-language support for Posts
- Multi Level User (Administrator, Editor, Author, Contributor, Subscriber)
- Role-Based Access Control (RBAC)
- Swagger API documentation

---

## ⚙️ Installation

Follow the steps below to set up the project locally.

### 1. Clone the Repository
```bash
git clone https://github.com/jamalapriadi/headless-cms.git
```

### 2. Navigate into the Project Folder
```bash
cd headless-cms
```

### 3. Install the Dependencies
```bash
composer install
```

```bash
npm install
```

### 4. Copy and Configure `.env`
```bash
cp .env.example .env
```

Then open `.env` and set your database credentials:
```env
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
> **Note:** You can replace `http://127.0.0.1:8000` with your own application URL if running on a different host or port.

### 5. Configure Swagger Documentation (Optional)
In the `.env` file, set the Swagger host:
```env
L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_CONST_HOST=http://127.0.0.1:8000
```
> **Note:** You can replace `http://127.0.0.1:8000` with your own application URL if running on a different host or port.

### 6. Generate APP_KEY
```bash
php artisan key:generate
```

### 7. Run Migrations and Seeders
```bash
php artisan db:seed
```

```bash
php artisan db:seed
```
### 8. Link the Storage Directory
```bash
php artisan storage:link
```
This command creates a symbolic link from `public/storage` to `storage/app/public`, allowing you to access uploaded files.

### 9. Start the Development Server
```bash
composer run dev
```

Visit your app at: [http://127.0.0.1:8000](http://127.0.0.1:8000) 
> **Note:** You can replace `http://127.0.0.1:8000` with your own application URL if running on a different host or port.

---

## 🧑‍💻 Sample User Accounts

Below are sample user credentials you can use to log in:

| Email                | Role          | Password      |
|----------------------|---------------|---------------|
| jamal.apriadi@gmail.com    | Administrator | JulyCode2015!      |
| editor@gmail.com   | Editor        | JulyCode2015!      |
| author@gmail.com   | Author        | JulyCode2015!      |
| contributor@gmail.com | Contributor | JulyCode2015!      |

---

## 📖 API Documentation

Once the server is running, access the Swagger UI at:

```
http://127.0.0.1:8000/api/documentation
```

You’ll find all available API endpoints well-documented there.

---


## 🤝 Contributing

Contributions are welcome! To contribute:

1. Fork this repository
2. Create a new branch
3. Submit a pull request with clear changes and descriptions

---

## 📝 License

This project is open-sourced under the MIT License.

