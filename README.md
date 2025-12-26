# LSIS1_Grupo4

[![Language: PHP](https://img.shields.io/badge/Language-PHP-777BB4?logo=php)](https://www.php.net/)
[![Dependencies: Composer](https://img.shields.io/badge/Dependencies-Composer-885630?logo=composer)](https://getcomposer.org/)
[![Frontend: HTML/CSS/JS](https://img.shields.io/badge/Frontend-HTML%2FCSS%2FJS-E34F26?logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/Front-end_development)

This project, `LSIS1_Grupo4`, is a web-based **Employee and HR Management System**. It's designed to streamline various human resources processes, including employee data management, document handling, alerts, and access to payslips and training certificates.

## Features

-   **User Authentication & Authorization:** Secure login system for employees and potentially invited guests.
-   **Employee Profile Management:** Functionality to view and update employee profiles.
-   **Document Management:** Storage and access to sensitive documents such as ID cards, bank documents, payslips, and training certificates.
-   **Alerts System:** Management and notification of various alerts.
-   **Payslip Management:** Employees can view and access their payslips.
-   **Training Certificate Management:** Employees can view and associate training certificates.
-   **Team Management:** Features for creating and managing employee teams.
-   **Pending Requests:** System to handle and display pending requests (e.g., leave requests, document submissions).
-   **Email Integration:** Sending emails (e.g., for alerts or notifications) via PHPMailer.

## Tech Stack

-   **Backend:**
    -   **PHP** (Core logic, API endpoints)
    -   **Composer** (PHP Dependency Manager)
    -   **PHPMailer** (Email sending library)
    -   **MySQL** (Database, implied by `DAL/connection.php` and typical PHP application architecture)
-   **Frontend:**
    -   **HTML5**
    -   **CSS3**
    -   **JavaScript** (with custom scripts for interactivity)

## Prerequisites

Before setting up the project, ensure you have the following installed:

-   **PHP** (version 7.4 or higher recommended)
-   **Composer**
-   **MySQL Database Server**

## Installation and Running

Follow these steps to get the project up and running on your local machine:

### 1. Clone the Repository

```bash
git clone https://github.com/RacoonOverFlow/LSIS1_Grupo4
cd LSIS1_Grupo4
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Database Setup

1.  Create a MySQL database for the project (e.g., `lsis1_grupo4_db`).
2.  Locate `DAL/connection.php` and update the database connection details (hostname, username, password, database name) to match your MySQL setup.
3.  You will need to import the database schema. Look for `.sql` files in the project root or a `database` directory, or create the schema manually based on the DAL files.

## Project Structure

-   `API/`: Contains API endpoints, such as `alertas_api.php`.
-   `BLL/`: Business Logic Layer - Contains PHP classes and functions for business rules.
-   `CSS/`: Stylesheets for the user interface.
-   `DAL/`: Data Access Layer - Handles all interactions with the database, including `connection.php`.
-   `Dicionário/`: May contain data dictionaries or documentation.
-   `documentos/`: Stores uploaded documents (e.g., IDs, certificates, bank docs).
-   `GitAnalysis/`: Project's internal Git analysis reports per sprint.
-   `jvscript/`: JavaScript files for client-side interactivity.
-   `photos/`: Image assets used in the application.
-   `UI/`: User Interface - Contains all `.php` files responsible for rendering web pages.
-   `vendor/`: Composer-managed third-party libraries.
