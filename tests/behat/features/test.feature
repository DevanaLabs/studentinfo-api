Feature: Test

  Scenario: Homepage
    When I request "GET /"
    Then I get a "200" response

  Scenario: LoginWrong
    Given I have the payload:
    """
           {
               "email": "wrong@gmail.com",
                "password": "wrongpassword"
           }
    """
    When I request "POST /auth"
    Then I get a "403" response

  Scenario: LoginSuccess
    Given I have the payload:
    """
           {
              "email": "nu@gmail.com",
              "password": "blabla"
           }
    """
    When I request "POST /auth"
    Then I get a "200" response

  Scenario: GetUser
    When I request "GET /user/1"
    Then I get a "403" response

  Scenario: GetStudents
    When I request "GET /students"
    Then I get a "403" response

  Scenario: GetStudents
    Given I request "GET /getClassrooms"
    Then  I get a "200" response

  Scenario: RegisterWrong
    When I request "GET /register/12345"
    Then I get a "403" response
    
  Scenario: RegisterSuccess
    Given I have the payload:
    """
           { "emails":
              [
                  {
                  "email": "mv@gmail1.com"
                  },
                  {
                  "email": "mail1@mail.com"
                  }
              ]
           }
    """
    When I request "POST /register"
    Then I get a "403" response

  Scenario: AddStudents
    Given I am logged in as admin
    Given I have the payload:
    """
           { "students":
              [
                  {
                  "firstName": "firstName",
                  "lastName": "lastName",
                  "email": "mail1@mail.com",
                  "indexNumber": "123",
                  "year": "3"
                  },
                  {
                  "firstName": "firstName",
                  "lastName": "lastName",
                  "email": "mail2@mail.com",
                  "indexNumber": "124",
                  "year": "3"
                  }
              ]
           }
    """
    When I request "POST /addStudents"
    Then I get a "403" response
