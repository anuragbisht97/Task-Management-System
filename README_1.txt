1.Install XAMPP.

2.Create DB.
	Database name : task_mamager

3.Open project with your editor.

4.Run command inside project folder.
			php artisan migrate:fresh --seed
			php artisan serve

5.Register and then,
	Open DB(task_manager),
	Open table(users),
	Edit newly registered user field(role) to "super" and field(user_status) to 1.

6.Refresh your webpage.
	Now onwards no need to interact with DB tables for anything until you remember
	Super User.
