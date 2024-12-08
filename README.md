# Project Name: Advanced Course Management

## Table of Contents

### - Installation
### - Database Setup and Seeding
### - Running the Cron Job for Weekly Email Summaries
### - Notes

# Installation

To get your project up and running, follow these steps:

1. Clone the repository: First, clone the project repository to your local machine.

```
git clone https://github.com/Ravi-arya009/AdvancedCourseManagement.git
```


2. Install dependencies: Navigate into the project directory and install the required dependencies and packages.
```
cd AdvancedCourseManagement
```
```
composer install
```
```
npm install
```
```
npm run build 
```

3. Set up environment variables: Copy the .env.example file to .env.

# Database Setup and Seeding

1. Set up the database: Create a new MySQL database for the project.

>Database name: advanced_course_management

2. Update your .env file: In the .env file, configure your database connection. Example:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=advanced_course_management
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

3. Run the migrations: Run the migration command to set up your database schema.

```
php artisan migrate
```

4. Seed the database to populate the database with initial data, run the following command:

```
php artisan db:seed
```

# Running the Cron Job for Weekly Email Summaries

## Linux setup
1. Set up the system cron job: You need to add the Laravel scheduler to your system's cron jobs. Open the crontab for your user by running:

```
crontab -e
```

Add the following line to your crontab file to run the Laravel scheduler:

```
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

Replace /path/to/your/project with the actual path to your Laravel project directory.

## Windows Setup
### 1. Create a New Task:

- Type taskschd.msc in run to open the Task Scheduler.
- Create a new task and give it a name (e.g., Laravel Weekly Summary Cron Job).
- To run the task in the background, select run whether the user is logged on or not and check the Hidden checkbox.

### 2. Triggers

- Create a new trigger.
- Set the trigger to run Weekly.
- Select the desired day (e.g., Monday) and time (e.g., 08:00 AM).

### 3. Actions

- Create a new action.
- Start php by entering the php binary location, such as C:\php\php.exe
- Set Add arguments field to C:\{project-dir}\artisan schedule:run  (replace {project-dir} with appropriate path).



### Manually trigger the cron job for testing:

You can manually run the cron job for testing using the following artisan command:

```
php artisan app:send-weekly-summary
```

This will execute the cron job immediately and send the email summaries to the instructors.

## Notes:

- Mail Configuration: This project uses a Mailtrap for development, ensure your .env file has the appropriate settings for mail delivery(temporary keys are provided in .env.example).

- This project also logs the mails so that it can be checked if the mail delivery fails(which does frequently since temporary mailing service is used). When running weekly summary, you might encounter warning saying too many mails(since we're using free mailing service).

- A dummy csv file is provided named students.csv in the project directory.

- Laravel's built in file caching is used instead of Redis or memcached to avoid multiple moving parts for now. In future it can be changed as the project grows.

- Middleware is used to restrict certain functionalities based on user roles. Additionally, as the project required the use of gates or policies, a gate is implemented in specific places (defined in AppServiceProvider.php) to demonstrate its usage.

- An extra table name 'roles' is used to keep track of user roles and make it dynamic and future proof.

- There're no such challenges faced in the project. Only challenge was to check Laravel's documentation while doing certain things because Laravel 11 changed a lot of traditional ways of doing things.

