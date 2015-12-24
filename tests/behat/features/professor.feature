Feature: Professor

  Scenario: AddProfessorSuccess
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                    "firstName": "Nebojsa",
                    "email": "testing@test.com",
                    "lastName": "Urosevic",
                    "title": "dr"
                  }
    """
    Given I request "POST /professor"
    Then I get a "200" response

  Scenario: AddProfessorFail
    Given I have the payload:
    """
                  {
                    "lastName": "Urosevic",
                    "title": "dr"
                  }
    """
    Given I request "POST /professor"
    Then I get a "403" response

  Scenario: GetProfessor
    Given I am logged in as admin
    Given I request "GET /professors"
    Then I get a "200" response

  Scenario: GetProfessorFail
    Given I am logged in as student
    Given I request "GET /professors"
    Then I get a "200" response


  Scenario: EditProfessor
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                    "firstName": "Nebojsa",
                    "email": "testing@test.com",
                    "lastName": "Urosevic",
                    "title": "dr"
                  }
    """
    Given I request "POST /professor"
    Given I request "GET /professor/1"
    Then I get a "200" response
    Given I have the payload:
    """
                  {
                    "firstName": "Nebojsa",
                    "email": "testing@test.com",
                    "lastName": "Urosevic",
                    "title": "mr"
                  }
    """
    Given I request "PUT /professor/1"
    Then I get a "200" response
    Given I request "GET /professor/5"
    Then I get a "500" response

  Scenario: DeleteProfessorSuccess
    Given I am logged in as admin
    Given I request "DELETE /professor/1"
    Then I get a "200" response

  Scenario: DeleteProfessorSuccess
    Given I am logged in as admin
    Given I request "DELETE /professor/2"
    Then I get a "200" response

  Scenario: DeleteProfessorFail
    Given I am logged in as admin
    Given I request "DELETE /professor/3"
    Then I get a "500" response