
# Jobsity Challenge
 This is the challenge requested to me by Jobsity. Coded in PHP by me using:
- Composer
- Laravel
- SASS
- Bootstrap 4
- MariaDB database
- Apache server
- PHP version 7.2

# Install instructions
Update dependencies and upgrade

    sudo apt update

Install Apache web server if you don't have it already

    sudo apt install apache2
    #also enable mod_rewrite
    sudo a2enmod rewrite
Install PHP 7.2 and required dependencies

    sudo apt install php7.2 php7.2-bcmath openssl php7.2-ctype php7.2-json php7.2-mbstring php7.2-mysql php7.2-xml php7.2-zip
Install composer

    sudo apt install composer
Change your directory to the desired folder on which to install the server files

    cd /home/user/jobsity/hectorviov
Clone this git repository to the current folder

    git clone git@github.com:hectorviov/jobsitychallenge.git
    
    #install all dependencies
    composer install
    
You need to create a virtual host for the Apache server

    sudo vim /etc/apache2/sites-available/jobsity-challenge.conf
Follow the example configuration below changing the needed folders to meet your needs

    <VirtualHost *:80>
	     ServerName hectorviov.jobsitychallenge.com
	     ServerAdmin webmaster@localhost
	     DocumentRoot /home/user/jobsitychallenge/hectorviov/public

	     ErrorLog ${APACHE_LOG_DIR}/error.log
	     CustomLog ${APACHE_LOG_DIR}/access.log combined

	     <Directory /home/user/jobsitychallenge/hectorviov/public>
	            AllowOverride All                
	            Order allow,deny
	            Allow from all
	            Require all granted
	     </Directory>
	</VirtualHost>
Enable the virtual host

    sudo a2ensite jobsity-challenge.conf

Yo need to edit your hosts file depending on your OS. You can follow a [guide in here](https://support.rackspace.com/how-to/modify-your-hosts-file/). With the example virtual host configuration above you would add something like:

    127.0.0.1		hectorviov.jobsitychallenge.com
    ::1             hectorviov.jobsitychallenge.com
Restart the Apache server

    sudo service apache2 restart
Install the MariaDB server

    sudo apt install mariadb-server
    
    #start the server
    sudo service mysql start
Open the MySQL client as root
	
    sudo mysql
Inside the MySQL shell let's create a user which will be an admin with only access on the localhost and the database for our data:

    CREATE USER 'www-data'@'localhost' IDENTIFIED BY 'changeme';
	GRANT ALL PRIVILEGES ON *.* TO 'www-data'@'localhost';
	FLUSH PRIVILEGES;
	
	CREATE DATABASE jobsity
	CHARACTER SET utf8
	COLLATE utf8_unicode_ci;
	exit;

You should now change the environment variables of the project to match your settings. First copy the file .env.example as .env and edit that file, for example:

    APP_NAME="Jobsity hectorviov"
    APP_ENV=local
    
    #We will generate the APP_KEY later
    APP_KEY= 
    APP_DEBUG=true
    APP_URL=http://hectorviov.jobsitychallenge.com
    
    #You need a Twitter Bearer Token to acces a read API.
    TWITTER_TOKEN=
	
	LOG_CHANNEL=stack
	
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=jobsity
	DB_USERNAME=www-data
	DB_PASSWORD=changeme

Now generate the random APP_KEY:

    php artisan key:generate
Now for some example data you should run the database seeder:

    composer dump-autoload
    php artisan migrate --seed

Now this will create 3 users that you can login with (username:password):

 - hectorviov@gmail.com:changeme
 - mkbhd@gmail.com:changeme
 - billgates@outlook.com:changeme

Inside the app you can create more users if desired.

If everything went well you should be able to access [http://hectorviov.jobsitychallenge.com/](http://hectorviov.jobsitychallenge.com/) and browse the app.

You can contact me via email if you need help with anything. Thank you!