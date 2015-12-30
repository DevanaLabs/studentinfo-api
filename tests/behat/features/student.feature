Feature: Student

  Scenario: AddStudentSuccess
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                  "firstName": "firstName",
                  "lastName": "lastName",
                  "email": "mail1@mail.com",
                  "indexNumber": "123",
                  "year": "3",
                  "lectures": []
                  }
    """
    When I request "POST /student"
    Then I get a "200" response

  Scenario: AddStudentFail
    Given I have the payload:
    """
                  {
                  "lastName": "lastName",
                  "email": "mail1@mail.com",
                  "indexNumber": "123",
                  "year": "3"
                  }
    """
    Given I request "POST /student"
    Then I get a "403" response

  Scenario: GetStudent
    Given I am logged in as admin
    Given I request "GET /student/4"
    Then I get a "200" response

  Scenario: GetStudents
    Given I am logged in as admin
    Given I request "GET /students"
    Then I get a "200" response

  Scenario: GetStudentFail
    Given I am logged in as student
    Given I request "GET /students"
    Then I get a "200" response


  Scenario: EditStudent
    Given I have the payload:
    """
                  {
                  "firstName": "firstNameName",
                  "lastName": "lastName",
                  "email": "mail2@mail.com",
                  "indexNumber": "124",
                  "year": "3",
                  "lectures": []
                  }
    """
    Given I request "PUT /student/4"
    Then I get a "200" response

  Scenario: DeleteStudentSuccess
    Given I am logged in as admin
    Given I request "DELETE /student/4"
    Then I get a "200" response

  Scenario: DeleteStudentFail
    Given I am logged in as admin
    Given I request "DELETE /student/5"
    Then I get a "500" response