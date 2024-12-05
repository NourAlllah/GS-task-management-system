# GS-Task management system 

This Laravel-based application allows users to manage tasks efficiently. The system demonstrates backend development practices, robust database handling, and secure authentication mechanisms. 
  
---------------------

*Core Features*

Authentication:

- User login and logout (registration excluded).
- Middleware for route protection.

Database Models:

- User: For authentication and task management.
- Task: Contains task details such as title, description, due date, status, and assignee.
- Comment: For task-specific user collaboration.
- Attachment: Handles task-related file uploads.

Data Migrations and Seeders:

- Migrations to define the schema.
- Seeders to create:
   - 3 users.
   - 100+ tasks for each user.

Dashboard:

- Displays tasks:
   - Assigned to the user.
   - Created by the user.

Task Management:

- Users can:
   - Create tasks.
   - Assign tasks to others.
   - Update task status (Open, In Progress, Completed).

Comments:

- Users can comment on tasks for real-time collaboration.

Search and Filter:

- Enables search by title and description.
- Filters by:
   - Status
   - Assignee
   - Priority

Email Notifications:
- Notifications for:
   - Task assignments.
   - Status updates.
   - New comments.
   
---------------------
*Components Used*

Jobs:
- This project utilizes Laravel Jobs for handling background tasks and asynchronous processing. Jobs are used for tasks such as sending emails of new achievment.

Migrations:
- Database migrations are used to manage database schema changes and ensure consistency across different environments. Migrations are used to create and modify database tables.

Seeds:
- Database seeding is used to populate the database with initial data. Seeders are used to create sample data for testing purposes.

---------------------
*versions used*

- PHP 8.2.12
- Laravel Framework 11.13.0
- Composer version 2.7.2
- Node js v20.13.1
- NPM 10.5.2

*Setup and Installation*

1- Clone the repository:

        git clone https://github.com/NourAlllah/GS-task-management-system.git

2- Install dependencies:

        composer install
        npm install

3- Configure the .env File:
  
      cp .env.example .env

4- update .env File:

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database_name
        DB_USERNAME=root
        DB_PASSWORD=

        MAIL_MAILER=smtp
        MAIL_HOST=smtp.gmail.com
        MAIL_PORT=587
        MAIL_USERNAME=yourgmail@gmail.com
        MAIL_PASSWORD=create this password using google app
        MAIL_ENCRYPTION=tls
        MAIL_FROM_ADDRESS=yourgmail@gmail.com
        MAIL_FROM_NAME="${APP_NAME}"

 ***adding gmail and password is important to push email notification, If the email was not received, check the logs of your email service provider.

5- Generate Application Key:

        php artisan key:generate

6- Run for  Vite manifest

        npm run build
        
7- php artisan migrate:

        php artisan migrate

8- Seed the database:

        php artisan db:seed

9- clearinf config cash:

        php artisan config:clear

        php artisan config:cache 

10- Link Storage to public 

        php artisan storage:link

9- Start the development server:

        php artisan serve

10- Ensure that queue workers are running to handle jobs:

        php artisan queue:work

      
