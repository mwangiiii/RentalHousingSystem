# Web House-Hunting and Rental-Management System
## Makazi Hub

Makazi Hub is a comprehensive system designed to streamline both house hunting and rental management. It provides powerful tools for landlords, caretakers, and tenants to manage rental operations efficiently while also offering features to help house hunters find their ideal homes.

## Table of Contents

1. [Core Features](#core-features)
2. [Benefits](#benefits)
3. [Installation](#installation)
4. [Configuration](#configuration)
5. [Usage](#usage)
6. [Contributing](#contributing)
7. [License](#license)
8. [Contact](#contact)
9. [Credits](#credits)

## Core Features

### 1. House Hunting

- **Search Functionality**: Allows house hunters to search for properties based on various criteria such as location, rent price, amenities, and more.
- **Privacy Protection**: Ensures user privacy by enabling secure communication with landlords or property listers without sharing personal contact information.

### 2. Rental Management

#### Tenant Tools:
- Track rent payments and rental history.
- Submit maintenance requests and move-out notices.

#### Landlord Tools:
- Assign roles to property managers and maintenance staff.
- Monitor property history, rental income, and expenses.

#### Caretaker Tools:
- Register new tenants.
- Issue notices and analyze complaints.
- Manage day-to-day operations and communications.

## Benefits

- **Efficiency**: Streamlines both house hunting and rental management processes, saving time and effort for all users.
- **Privacy**: Maintains the privacy of users by allowing secure communication within the system.
- **Organization**: Keeps all rental operations organized, with clear roles and responsibilities for each user type.

Makazi Hub enhances the rental experience by providing a unified platform that caters to the needs of both property managers and house hunters, ensuring efficient management and a seamless search process.

## Installation

### Must-Have

1. **MySQL**: Database Management System.
   - Installation: [Download MySQL](https://dev.mysql.com/downloads/installer/).

2. **Node.js**:
   - Installation: [Download Node.js](https://nodejs.org/en/download/package-manager).

3. **Laravel**:
   - Installation: [Download Laravel](https://laravel.com/docs/11.x/installation).

4. **Node Package Manager (NPM)**:
   - Installation: [NPM](https://www.npmjs.com/).

5. **Composer**: Dependency manager for PHP.
   - Installation: [Composer](https://getcomposer.org/).

6. **PHP**: Server Language.
   - Installation: [PHP](https://www.php.net/downloads.php).

### Steps

1. **Fork the Repository**
   - Click on the ⁠ Fork ⁠ button at the top right corner of this page.

   - *Clone Your Fork*:
   ```bash
   git clone https://github.com/yourusername/makazi-hub.git
   cd makazi-hub
   ```

2. **Install Node Dependencies**
   ```bash
   npm install
   npm run build
   npm run dev
   ```

3. **Install Composer Dependencies**
   ```bash
   composer install
   ```

4. **Configure Database**
   - Copy `.env.example` to `.env` and configure your database connection details. Example:
     ```dotenv
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Configure Email**
   - Set up SMTP details in the `.env` file for sending emails. Example:
     ```dotenv
     MAIL_MAILER=smtp
     MAIL_HOST=smtp.gmail.com
     MAIL_PORT=587
     MAIL_USERNAME=your_email@gmail.com
     MAIL_PASSWORD=your_password
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS=no-reply@makazihub.com
     MAIL_FROM_NAME="Makazi Hub"
     ```

7. **Run Migrations and Seed Database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

## Configuration

### M-Pesa Sandbox Integration

To integrate M-Pesa Sandbox with Makazi Hub, follow these steps:

1. **Setting Up M-Pesa Sandbox**
   - Create an account and register your application on [Safaricom Developer Portal](https://developer.safaricom.co.ke/).
   - Obtain the following credentials from Safaricom for your application:
     - **Consumer Key**: Unique key provided to authenticate your application.
     - **Consumer Secret**: Secret key provided to authenticate your application.
     - **Token URL**: Use the provided URL to obtain an access token.

### Ngrok Setup

Ngrok is a tool to securely expose a local web server to the internet.

1. **Download Ngrok**
   - Download Ngrok from [Ngrok's official website](https://ngrok.com/download).

2. **Authentication (Optional)**
   - If you have an Ngrok account and want to use authentication, authenticate your Ngrok client:
     ```bash
     ./ngrok authtoken your_auth_token
     ```

3. **Start Ngrok**
   - Start Ngrok with your chosen domain:
     ```bash
     ngrok http --domain=your_static_domain_from_ngrok 8000
     ```

4. **Update `.env`**
   - Set `APP_URL` in your `.env` file to your Ngrok forwarding URL:
     ```dotenv
     APP_URL=https://abcd1234.ngrok.io
     ```

## Usage

After installation and setup, access the Makazi Hub application and utilize its features for house hunting and rental management.

## Contributing

We welcome contributions to improve Makazi Hub! Follow these steps to contribute:
1. Fork the repository.
2. Clone your fork to your local machine.
3. Create a new branch (`git checkout -b feature/your-feature-name`).
4. Make your changes and test them.
5. Commit your changes (`git commit -am 'Add new feature: your feature description'`).
6. Push to the branch (`git push origin feature/your-feature-name`).
7. Submit a pull request with a detailed description of your changes.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# RentalHousingSystem
The proposed system helps simplify work in a house rental business as it connects the tenant to the caretakers and their landlords. It offers several features like abstracted communication, maintenance report submission etc.  By allowing the choice of different criteria, a client can decide the location, amenities e.t.c., around they want around.
