# RailSafar-Online-Railway-Reservtion
Contributors :<br> Megha : https://github.com/MeghaSingh-5634 <br>
               Anmol: https://github.com/arssite
### Railsafar: Online Rail Reservation Software

**Railsafar** is an online rail reservation software designed to streamline the process of booking train tickets. Built using PHP and MySQL, it leverages dynamic HTML to provide an interactive and user-friendly experience. The software includes features such as train schedules, seat availability, booking, cancellation, and user management. Its web-based nature ensures that users can access the service from any location with an internet connection, making it a convenient solution for travelers and administrators alike.

### Features

1. **User Management**: Allows users to register, log in, and manage their profiles.
2. **Search and Booking**: Users can search for trains, check seat availability, and book tickets.
3. **Cancellation**: Provides options to cancel reservations and process refunds.
4. **Admin Panel**: Admins can manage train schedules, monitor bookings, and generate reports.
5. **Payment Integration**: Supports online payment gateways for secure transactions.

### Installation Process

**Prerequisites:**

1. A web server (Apache or Nginx).
2. PHP 7.4 or higher.
3. MySQL 5.7 or higher.
4. A web browser.
5. Composer (PHP package manager).

**Steps:**

1. **Set Up the Server Environment:**
   - Install a web server (Apache/Nginx), PHP, and MySQL.
   - On Ubuntu, you can use the following commands:
     ```sh
     sudo apt update
     sudo apt install apache2
     sudo apt install php libapache2-mod-php php-mysql
     sudo apt install mysql-server
     ```
   - Ensure the web server is running:
     ```sh
     sudo systemctl start apache2
     sudo systemctl start mysql
     ```

2. **Download Railsafar:**
   - Clone the Railsafar repository from GitHub or download it directly.
     ```sh
     git clone https://github.com/yourusername/railsafar.git
     ```

3. **Configure the Database:**
   - Log in to MySQL and create a database for Railsafar.
     ```sh
     mysql -u root -p
     CREATE DATABASE railsafar_db;
     CREATE USER 'railsafar_user'@'localhost' IDENTIFIED BY 'password';
     GRANT ALL PRIVILEGES ON railsafar_db.* TO 'railsafar_user'@'localhost';
     FLUSH PRIVILEGES;
     EXIT;
     ```
   - Import the initial database schema.
     ```sh
     mysql -u railsafar_user -p railsafar_db < path_to_railsafar/sql/schema.sql
     ```

4. **Configure the Application:**
   - Update the configuration file with your database credentials.
     ```php
     // In config.php or similar configuration file
     define('DB_SERVER', 'localhost');
     define('DB_USERNAME', 'railsafar_user');
     define('DB_PASSWORD', 'password');
     define('DB_NAME', 'railsafar_db');
     ```

5. **Install Dependencies:**
   - Navigate to the project directory and install dependencies using Composer.
     ```sh
     cd railsafar
     composer install
     ```

6. **Set Up Virtual Host (Optional):**
   - Create a new virtual host configuration for Railsafar.
     ```sh
     sudo nano /etc/apache2/sites-available/railsafar.conf
     ```
   - Add the following configuration:
     ```apache
     <VirtualHost *:80>
         ServerAdmin webmaster@localhost
         DocumentRoot /path_to_railsafar/public

         <Directory /path_to_railsafar/public>
             Options Indexes FollowSymLinks
             AllowOverride All
             Require all granted
         </Directory>

         ErrorLog ${APACHE_LOG_DIR}/error.log
         CustomLog ${APACHE_LOG_DIR}/access.log combined
     </VirtualHost>
     ```
   - Enable the new site and rewrite module:
     ```sh
     sudo a2ensite railsafar.conf
     sudo a2enmod rewrite
     sudo systemctl restart apache2
     ```

7. **Access Railsafar:**
   - Open a web browser and navigate to `http://localhost` (or your configured domain).

### Conclusion

Railsafar is a comprehensive solution for online rail reservations, providing essential features for users and administrators. By following the installation process, you can set up Railsafar on your server and start managing rail bookings efficiently.
