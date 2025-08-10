# Trip Request Management System (Laravel)

Welcome to the Trip Request Management System, a web application built with Laravel designed to streamline and automate the process of requesting, approving, and managing business trips within an organization.

## Features

- **User Authentication:** Secure login & registration for users and admins.
- **Trip Request Submission:** Employees can submit trip requests easily.
- **Approval Workflow:** Managers can review, approve, or reject trip requests.
- **Role-Based Access:** Distinct permissions for regular users, managers, and admins.
- **Contact Messages:** Users can send messages with subject lines and content which will be displayed in the admin dashboard.
- **Arabic RTL Orientation:** The website is targeted towards Arabic speaking audiences and is only available in Arabic language.


## Technologies Used

- **Framework:** [Laravel](https://laravel.com/)
- **Language:** PHP
- **Database:** MySQL with XAMPP
- **Frontend:** Blade templating
- **Authentication:** Custom authentication system without external packages for simplicity as a proof of concept.

## Getting Started

### Prerequisites

- PHP >= 8.0
- Composer
- MySQL with XAMPP
- Node.js & npm (for frontend assets)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Yazeed337/Trip-Request-Management-System-Laravel.git
   cd Trip-Request-Management-System-Laravel
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Copy and configure environment file**
   ```bash
   cp .env.example .env
   ```
   Update `.env` with your database credentials and other settings.

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```

7. **Build frontend assets**
   ```bash
   npm run dev
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Usage

- Visit the local URL shown in the terminal (typically http://127.0.0.1:8000).
- Register a new account or log in using already created accounts like "admin@sawwah.com" password: admin123. or "user@example.com" password: user123.
- Submit trip requests, view statuses from admin control panel, and manage approvals from the dashboard.
- Send contact messages using the contact us section. (Messages will be displayed in the admin dashboard).
- Known bugs: Logging out requires page refresh otherwise page will be unresponsive.
## Contributing

Contributions are welcome! Please open issues and submit pull requests for improvements or bug fixes.

## License

This project is open source and available under the [MIT License](LICENSE).

## Contact

For questions or support, please open an issue on GitHub or contact [Yazeed337](https://github.com/Yazeed337).
