## The Story

When we have a large file to import 
into the database, the problem of running time and 
the amount of RAM consumed occurs. To solve this problem,
I used php generators and tested with .txt files 
containing 10 million records, and the test 
result was satisfactory.

### Test result

```
Execution time : 1116 Second(s) 

The memory usage : 113.8 mb

```


I created a command to get and import the file:

```
php artisan import:log-file
```   
By running this command, our story gets to start. Just make sure that the file is in this directory:
````
storage/app/public/logs.txt
````   
This command fetches the full path of the file and takes 500 lines of it by the generator and stores it in the database.

We also have a endpoint to filter and count the imported data:
````
localhost:8000/api/logs/count
````
The example of usage:
- Filter by service name,
````
localhost:8000/api/logs/count?service_name=invoice-service
````

- Filter by status code:
````
localhost:8000/api/logs/count?status_code=201
````

- Filter by start date and end date:
````
localhost:8000/api/logs/count?start_date=2022-09-17 10:21:53&end_date=2022-09-17 10:21:54
````

- Also, you can combine filters together


You may want to make your own file with specific number of lines to test:
To do this, I created a command that by executing it and specifying the number of lines in the file as a parameter in this command, you can create your test file.
```
php artisan log:generate <numberOfLines>
php artisan log:generate 10000000

```

- Remember, I used a fixed file name 

## Installation
I used php version 8.0 and mysql version 8
Just create your own database, clone the repository, open the project directory make your own **.env** file and set the keys inside it.

Then, run the following commands:
```
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan serve
```
That's it!
