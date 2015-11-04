<?php

class UserLoginTest extends TestCase
{
    private $testEmail;
    private $testPassword;

    public function setUp()
    {
        parent::setUp();
        $this->testEmail    = 'test_email' . str_random(10) . '@test.test';
        $this->testPassword = "test_password";

        $testUser     = factory(StudentInfo\Models\Student::class)->create([
            'email'    => new \StudentInfo\ValueObjects\Email($this->testEmail),
            'password' => new \StudentInfo\ValueObjects\Password($this->testPassword),
        ]);
    }

    /**
     * API Test
     * Tests user login with valid credentials
     *
     * @return void
     */
    public function testUserLogin()
    {
        $this->post('/auth', ['email' => $this->testEmail, 'password' => $this->testPassword])
            ->assertResponseOk();
    }

    /**
     * API Test
     * Test user login with invalid credentials
     *
     * @return void
     */
    public function testUserInvalidPassword()
    {
        $this->post('/auth', ['email' => $this->testEmail, 'password' => 'wrong_password'])
            ->assertResponseStatus(403);
    }
}
