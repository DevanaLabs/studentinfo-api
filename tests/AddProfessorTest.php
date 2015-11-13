<?php

use StudentInfo\Models\Professor;
use StudentInfo\Repositories\ProfessorRepositoryInterface;

class AddProfessorTest extends TestCase
{
    /**
     * @var Professor $professor
     */
    private $professor;
    /**
     * @var ProfessorRepositoryInterface $professorRepository
     */
    private $professorRepository;

    public function __construct(ProfessorRepositoryInterface $professorRepository)
    {
        $this->professorRepository = $professorRepository;
    }

    public function setUp()
    {
        parent::setUp();

        $this->professor = new \StudentInfo\Models\Professor();
        $this->professor->setFirstName("test_firstName");
        $this->professor->setLastName("test_lastName");
        $this->professor->setTitle("test_title");

        $this->professorRepository->create($this->professor);


//        $testPofessor     = factory(StudentInfo\Models\Professor::class)->create([
//            'firstName'    => $this->firstName,
//            'lastName' => $this->lastName,
//            'title' => $this->title,
//         ]);
    }

    /**
     * API Test
     * Tests user login with valid credentials
     *
     * @return void
     */
    public function testProfessorAdding()
    {
        $this->post('/addProfessors', ['professors' => ['firstName'=> $this->professor->getFirstName(), 'lastName' => $this->professor->getLastName(), 'title' =>$this->professor->getTitle()]])
            ->assertResponseOk();
    }

//    /**
//     * API Test
//     * Test user login with invalid credentials
//     *
//     * @return void
//     */
//    public function testUserInvalidPassword()
//    {
//        $this->post('/auth', ['email' => $this->testEmail, 'password' => 'wrong_password'])
//            ->assertResponseStatus(403);
//    }
}
