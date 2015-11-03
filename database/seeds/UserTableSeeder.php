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
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     * UserTableSeeder constructor.
     * @param \StudentInfo\Repositories\UserRepositoryInterface $repository
     * @param \Faker\Generator                                  $faker
     * @param \Doctrine\ORM\EntityManager                       $_em
     */
    public function __construct(\StudentInfo\Repositories\UserRepositoryInterface $repository, Faker\Generator $faker, \Doctrine\ORM\EntityManager $_em)
    {
        $this->repository = $repository;
        $this->faker = $faker;
        $this->_em = $_em;
    }

    /**
     * Run the database seeds.
     *
     */
    public function run()
    {
        for($i=0;$i<1000;$i++)
        {
            $student = new \StudentInfo\Models\Student();
            $student->setFirstName($this->faker->name);
            $student->setLastName($this->faker->lastName);
            $student->setEmail(new \StudentInfo\ValueObjects\Email($this->faker->email));
            $student->setIndexNumber(str_random(5));
            $student->setPassword(new \StudentInfo\ValueObjects\Password(str_random(10)));
            $student->setRememberToken(str_random(10));

            $this->_em->persist($student);
        }
        $this->_em->flush();

    }
}
