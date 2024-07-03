<<<<<<< HEAD
# Web House-Hunting and Rental-Management System
# Makazi Hub
Makazi Hub is a comprehensive system designed to streamline both house hunting and rental management. It provides powerful tools for landlords, caretakers, and tenants to manage rental operations efficiently, while also offering features to help house hunters find their ideal homes.

## Core Features
### 1. House Hunting:

Search Functionality: Allows house hunters to search for properties based on various criteria such as location, rent price, amenities, and more.
Privacy Protection: Ensures user privacy by enabling secure communication with landlords or property listers without sharing personal contact information.

### 2. Rental Management:

- #### Tenant Tools:
Track rent payments and rental history.
Submit maintenance requests and move-out notices.
- #### Landlord Tools:
Assign roles to property managers and maintenance staff.
Monitor property history, rental income, and expenses.
- #### Caretaker Tools:
Register new tenants.
Issue notices and analyze complaints.
Manage day-to-day operations and communications.
## Benefits
Efficiency: Streamlines both house hunting and rental management processes, saving time and effort for all users.
Privacy: Maintains the privacy of users by allowing secure communication within the system.
Organization: Keeps all rental operations organized, with clear roles and responsibilities for each user type.

Makazi Hub enhances the rental experience by providing a unified platform that caters to the needs of both property managers and house hunters, ensuring efficient management and a seamless search process.


## Installation
To install the Makazi hub project, we would recommend you to do the following:.

### Must-Have
- Laravel (version 11 or later).
- Node packet manager - used for managing JavaScript dependencies.
- composer - a dependency used for PHP. 
- PHP (v 8.2.12).
- Database Management system e.g. mySql.
- Node.js (v14 or later).
- Web server e.g. Apache.

### Process
1. Clone the repository.
  on your computer's terminal, enter the following command:
   ```bash
   git clone https://github.com/yourusername/makazi-hub.git
   cd makazi-hub
2. Install the dependencies.
   On your project's directory, install and initialize the node packet manager dependencies.
   ```bash
   npm install
   npm run build
   npm run dev
4. Install the composer and the dependencies.
   on the cloned project's directory.
   ```bash
   composer install
5. Database setup.
  Open your directory using your IDE. Configure your database settings in the .env file located in the root directory of the project. Make sure to set up your database connection details, including the database name, username, and password.
   ```dotenv
   DB_CONNECTION= name of your dbms
   DB_HOST= the IP address or hostname where your database server is running. For local development, it's usually 127.0.0.1
   DB_PORT=the port the database is running on
   DB_DATABASE=database name as named in the dbms
   DB_USERNAME=the usernamefor accessing the database. mostly for local development it is usually root.
   DB_PASSWORD= leave it empty if you don't have a password included.If you do have a password, enter it here.
6. Email Setup.
   To configure the email settings of your project, make sure you configure this in your .env file
   ```dotenv
   MAIL_MAILER=smtp ((Simple Mail Transfer Protocol) for sending emails).
   MAIL_HOST= Enter the SMTP server hostname. e.g., for Gmail, it's smtp.gmail.com
   MAIL_PORT=Specify the port for the SMTP server e.g. for gmail it's 587
   MAIL_USERNAME=the email address you want to use for sending emails.
   MAIL_PASSWORD=Enter the password for the email account e.g. you will find it in the app passwords of your gmail account.
   MAIL_ENCRYPTION=Set this to tls for TLS (Transport Layer Security) encryption.
   MAIL_FROM_ADDRESS=the email address you want to appear as the sender of the emails.
   MAIL_FROM_NAME=you can set this to the name you want to appear as the sender of the emails."${APP_NAME}"
7. Running migrations.
   After configuring the .env file, we have to run our migrations. Open the terminal of the IDE (making sure that you are in your project's directory) and run the command below to create the tables in your database.
   ```bash
   php artisan migrate
8. Server initialization.
   we have to start the server by running the following command on the terminal (making sure that you are in the project's directory).this starts the server. the 
   ```bash
   php artisan serve
  The application should now be running on 'http://localhost:8000'.
  
## Usage

After successful installation and running of the application, we'll take you through the usage of the application. 

### Accessing the website application.
Go to your application and run `http://localhost:8000` on the url part of the browser that should take you to the home page of Makazi hub.
Here, we allowed those seeking for house hunting service from the application to reach their goal. 

### 1. House Hunting.
They can search for a house depending on criteria such as:
-    location
-    Price range
-    Number of bedrooms
#### House Listings
The main page displays sample houses that users can browse. Clicking on a house shows detailed information, including images and contact options. For privacy, all communication between users and landlords is done through the application without sharing personal contact information.

### 2. User registration and login.
- Create an account by clicking on the "Register" button and filling in the required information.
- If you already have an account, click on the "Login" button and enter your credentials.
### 3. Rental Management System.
 -    For Tenants:
Track your rent payments and rental history.
Submit maintenance requests and move-out notices through your account dashboard.
-    For Landlords:
Assign roles to property managers and maintenance staff.
Monitor property history, rental income, and expenses.
-    For Caretakers:
Register new tenants and issue notices.
Analyze complaints and manage day-to-day operations and communications.

### 4. Maintenance Requests
Tenants can submit maintenance requests through their dashboard.
Caretakers and landlords can view and manage maintenance requests in the admin panel.

### 5. Notifications
Receive notifications for new messages, maintenance requests, and other important updates directly through the platform

## Contributing
We welcome contributions from the community to improve this project! If you'd like to contribute, please follow these guidelines:
1. fork the repository on the top right of the page.
2. Clone the forked repository to your local machine using Git.
   ````bash
   git clone https://github.com/your-username/your-forked-repo.git
3. Create a new branch for your contribution.
   ````bash
   git checkout -b feature/your-feature-name
4. Make the changes and test them
5. Add the new feature.
   ````bash
   git commit -am 'Add new feature: your feature description'
6. Push your changes to your forked repository.
7. Submit a pull request to the original repository. Include a detailed description of your changes and any relevant information.
8. Your pull request will be reviewed by the maintainers. Be prepared to address any feedback or changes requested during the review process.

## License. 
The project is licensed under Licenses. 
-    Laravel: [MIT License](https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt).
-    PHP: [PHP License](https://www.php.net/license/3_01.txt)
-    MySQL: [OEM](https://www.mysql.com/about/legal/licensing/oem/)
-    Node.js: [MIT License](https://github.com/nodejs/node/blob/main/LICENSE).
-    Apache: [Apache License 2.0](https://apache.org/licenses/LICENSE-2.0)

## Contact
You can contact us at [Makazi Hub Admin](mailto:dennis.wanjiku@strathmore.edu,elvis.makara@strathmore.edu?subject=Github:Makazi-hub-Support) 

## Credits
Special credits to [Pahom21](https://github.com/Pahom21) for the meticoulous job done in this project.


=======
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# RentalHousingSystem
The proposed system helps simplify work in a house rental business as it connects the tenant to the caretakers and their landlords. It offers several features like abstracted communication, maintenance report submission etc.  By allowing the choice of different criteria, a client can decide the location, amenities e.t.c., around they want around.
>>>>>>> e1a0cde64500075f1bb40cff063551e44b9d0012
