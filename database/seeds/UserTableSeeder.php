<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * @var \StudentInfo\Repositories\UserRepositoryInterface
     */
    protected $repository;
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * UserTableSeeder constructor.
     * @param \StudentInfo\Repositories\UserRepositoryInterface $repository
     * @param \Faker\Generator                                  $faker
     */
    public function __construct(\StudentInfo\Repositories\UserRepositoryInterface $repository, Faker\Generator $faker)
    {
        $this->repository = $repository;
        $this->faker=$faker;
    }

    /**
     * Run the database seeds.
     *
     */
    public function run()
    {

        for($i=0;$i<100;$i++)
        {
            $student = new \StudentInfo\Models\Student();
            $student->setFirstName($this->faker->name);
            $student->setLastName($this->faker->lastName);
            $student->setEmail(new \StudentInfo\ValueObjects\Email($this->faker->email));
            $student->setIndexNumber(str_random(5));
            $student->setPassword(new \StudentInfo\ValueObjects\Password(str_random(10)));
            $student->setRememberToken(str_random(10));

            $this->repository->create($student);
        }

    }

    public function generateStudent()
    {


    }
}
