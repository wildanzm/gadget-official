# Gadget Official

## Description

Gadget Official is a modern e-commerce platform built with Laravel, Livewire, and Tailwind CSS. It provides a seamless shopping experience for users and a powerful dashboard for administrators to manage products, orders, sales, and more. The application supports both cash and installment payments, and includes features for handling returns and generating reports.

---

## Key Features

### For Customers:
-   **Product Catalog:** Browse a wide range of electronic gadgets.
-   **Shopping Cart:** Add products to a cart and manage quantities.
-   **Checkout:** A smooth and secure checkout process.
-   **Payment Options:** Pay with cash/bank transfer or in installments.
-   **Transaction History:** View past orders and their statuses.
-   **Installment Tracking:** Keep track of installment payments and due dates.
-   **Order Returns:** Request to return a product.

### For Administrators:
-   **Dashboard:** Get an overview of monthly sales, total products, and transactions.
-   **Product Management:** Add, edit, and delete products from the catalog.
-   **Order Management:** View and update the status of customer orders.
-   **Sales Reporting:** Generate PDF reports of sales data with various filters.
-   **Credit Management:** Track and manage installment payments and late fees.
-   **Return Management:** Approve or reject customer return requests.
-   **Sales Recap:** View a summary of all sales, returns, and receivables.

---

## Tech Stack

-   **Backend:** PHP, Laravel
-   **Frontend:** Livewire, Tailwind CSS, Alpine.js
-   **Database:** MySQL

---

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL

### Setup and Installation


1.  **Clone the repository:**
    ```sh
    git clone [https://github.com/gadget-official.git](https://github.com/gadget-official.git)
    cd gadget-official
    ```

2.  **Install PHP dependencies:**
    ```sh
    composer install
    ```

3.  **Install NPM dependencies:**
    ```sh
    npm install
    ```

4.  **Create a copy of your .env file:**
    ```sh
    cp .env.example .env
    ```

5.  **Generate an app encryption key:**
    ```sh
    php artisan key:generate
    ```

6.  **Configure your database:**
    Open the `.env` file and set your database credentials:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=gadget_official
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7.  **Run the database migrations and seeders:**
    ```sh
    php artisan migrate --seed
    ```
    This will create the necessary tables and populate them with initial data, including an admin and a regular user.

8.  **Build the assets:**
    ```sh
    npm run build
    ```

9.  **Start the development server:**
    ```sh
    php artisan serve
    ```

---

## Usage

After installation, you can access the application in your web browser at the URL you configured (e.g., `http://localhost:8000`).

### Default Admin Credentials:
-   **Email:** `admin@gmail.com`
-   **Password:** `admin123`

### Default User Credentials:
-   **Email:** `user@gmail.com`
-   **Password:** `user1234`
