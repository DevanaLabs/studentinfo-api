Feature: Test



  Scenario: RegisterSuccess
    Given I am logged in as admin
    Given I have the payload:
    """
           { "emails":
              [
                  {
                  "email": "mv@gmail1.com"
                  }
              ]
           }
    """
    When I request "POST /register"
    Then I get a "200" response

  Scenario: AddStudents
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                  "firstName": "firstName",
                  "lastName": "lastName",
                  "email": "mail1@mail.com",
                  "indexNumber": "123",
                  "year": "3"
                  }
    """
    When I request "POST /student"
    Then I get a "200" response

