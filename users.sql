CREATE USER 'phpmyadmin'@'localhost' IDENTIFIED BY 'Il0velamp!';
GRANT ALL PRIVILEGES ON *.* TO 'phpmyadmin'@'localhost';
CREATE USER 'simlab'@'localhost' IDENTIFIED BY 'Icould$1mallday!';
GRANT ALL PRIVILEGES ON sudo_meds.* TO 'simlab'@'localhost';
FLUSH PRIVILEGES;
select user from mysql.user;
