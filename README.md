# Job Application Tracker

A simple PHP-based web app to track job applications. This app allows users to add job applications, including company name, location, description, date of application, and a URL to the job listing.

## Features
- **Submit job applications** with:
  - Company Name
  - Location
  - Description
  - Date of Application (default to today's date if not provided)
  - Job Listing URL (automatically prepends `https://` if missing)
- **View success message** upon submitting a job application.
- **Prevents resubmission** of the form when the page is refreshed (using PHP's POST/Redirect/GET pattern).

## Requirements
- PHP 7.0 or higher
- MySQL database
- PDO (PHP Data Objects) for database connection

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/yourusername/job-application-tracker.git
   ```

2. **Set up the database:**
   - Create a new MySQL database (`job_applications`).
   - Create a table for the applications by running the following SQL:

   ```sql
   CREATE TABLE applications (
       id INT AUTO_INCREMENT PRIMARY KEY,
       company_name VARCHAR(255) NOT NULL,
       company_location VARCHAR(255),
       description TEXT,
       date_applied DATE NOT NULL,
       vacancy_url VARCHAR(255) NOT NULL
   );
   ```

3. **Configure your database connection:**
   - Open the `db.php` file and update the following variables with your database credentials:
     - `$host`
     - `$user`
     - `$pass`
     - `$db`

4. **Run the app:**
   - You can now run the app locally by navigating to the project folder and running it on a local PHP server.

   ```bash
   php -S localhost:8000
   ```

   Open your browser and visit [http://localhost:8000](http://localhost:8000) to use the app.

## How It Works

- **Form Submission**:  
  When the user submits the form, the application validates and sanitizes the URL, prepends `https://` if needed, and stores the job application data in the database.

- **Prevent Resubmission**:  
  After submitting the form, the user is redirected to the same page (using the POST/Redirect/GET pattern) to avoid resubmitting the form if the page is refreshed.

- **Success Message**:  
  Once the data is successfully inserted, a success message is shown to the user indicating the application was added successfully.

## TODO

- **Display a list of all applications**: Create a page or section that retrieves and displays all submitted job applications from the database.
- **Edit and Delete functionality**: Allow users to edit and delete their submitted job applications.
- **Styling**: Integrate CSS for a better user interface. (Currently, no styling is implemented)

---

### Credits

- **PHP**: PHP version 7.0 or higher.
- **MySQL**: Database used for storing job application details.
- **PDO**: PHP Data Objects (PDO) used for database interaction.
