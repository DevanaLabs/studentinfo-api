# Student Info API readme

## Virtualization
For virtualization the `laravel/homestead` is use.

The intallation instruction can be found at: http://laravel.com/docs/homestead.

## Setting up the project for the first time
1. Clone this repository locally:

``` bash
git clone git@github.com:DevanaLabs/studentinfo-api.git
```

2. Add the folder containing the cloned repository to your 'Homestead.yaml' file.
3. Add the site you your 'Homestead.yaml' file:

``` yaml
sites:
    - map: api.studentinfo.dev
      to: /home/vagrant/Code/student-info-api/public
```

5. Add a new database to your 'Homestead.yaml' file:

``` yaml
databases:
    - api_studentinfo
```

6. In your `Homestead` directory run:

``` bash
vagrant reload --provision
```

7. Change your working directory to your student-info-api folder.
8. Copy the file `.env.example` to `.env`.
9. Install the composer packages by running:

``` bash
composer install
```

9. Migrate the database
```
php artisan doctrine:migrations:migrate
```

## Optional

### PHPStorm configuration:
1. To add the project go to `New Project from Existing Files > Source files are in a local directory, no Web server is yet configured`, then select the repository folder as the **Project root** and **Exclude** the `storage` directory

### Setup XDebug
- Go to: `Languages & Frameworks > PHP > Servers > New`
- Configure new Server:
    - Name: `StudentInfo`
    - Host: `api.studentinfo.dev`
    - Port: 80
    - `Check` Use path mappings:
	    - `local-path` -> /home/vagrant/Code/student-info-api

### Database conventions
- All tables are named in plural.
- Snake casing is used for table naming.
- Pivot tables are named in a way: `first_second`, where first is the name of the first entity and second name of the second entity, sorted in an alphabetical order.
