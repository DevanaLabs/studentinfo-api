# Student Info

## Virtualization
For virtualization the `laravel/homestead` is use.

The intallation instruction can be found at: http://laravel.com/docs/homestead.

## Setting up the project for the first time
1. Clone this repository locally:
``` bash
git clone git@codebasehq.com:pmedia/student-info/student-info-api.git
```
2. Add the folder containing the cloned repository to your 'Homestead.yaml' file.
3. Add the site you your 'Homestead.yaml' file:

``` yaml
sites:
    - map: api.studentinfo.dev
      to: /home/vagrant/Code/api-studentinfo/public
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

7. Change your working directory to your api-studentinfo folder.
8. Rename the file `.env.example` to `.env`.
9. Install the composer packages by running:

``` bash
composer install
```

9. Migrate the database

## PHPStorm configuration:
1. To add the project go to `New Project from Existing Files > Source files are in a local directory, no Web server is yet configured`, then select the repository folder as the **Project root** and **Exclude** the `storage` directory

## Setup XDebug
- Go to: `Languages & Frameworks > PHP > Servers > New`
- Configure new Server:
    - Name: [project-name]
    - Host: [project-name].dev
    - Port: 80
    - `Check` Use path mappings:
	    - [local-path] -> /home/vagrant/Code/api-studentinfo

## Database conventions
- All tables are named in plural.
- Snake casing is used for table naming.
- Pivot tables are named in a way: `first_second`, where first is the name of the first entity and second name of the second entity, sorted in an alphabetical order.

## Add the SSH key to the Codebase account
1. Copy the entire contents of the `.ssh/id_rsa.pub` relative to your home directory.
2. Paste the public key contents to the SSH Public Keys section of the My Profile tab in Codebase.
