# [User Management Page](https://gitlab.edge-works.net/thinh/learn-angular)

## How to use

1. Install and Start Apache, MySQL service
2. Import database

	mysql -u [username] -p [database name] < [sql file name].sql

3. Change connect database [link project]/php/person.php

	$connect = new mysqli('[host]', '[username]', '[password]', '[database]');

4. Access to http://localhost/[folder_project]/

## Functions of Project

1. Add new user
2. Edit user
3. Delete user
4. Sort by firstname, lastname, username when click that column
5. When you input at Keyword field, it will show search result.