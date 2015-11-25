Feature: Classroom

  Scenario: AddClassroom
    Given I am logged in as admin
    Given I have the payload:
    """
           { "classrooms":
              [
                  {
                    "name": "r12",
                    "directions": "levo"
                  }
              ]
           }
    """
    Given I request "POST /addClassrooms"
    Then I get a "200" response
    Given I have the payload:
    """
           { "classrooms":
              [
                  {
                    "name": "r12"
                  }
              ]
           }
    """
    Given I request "POST /addClassrooms"
    Then I get a "422" response

  Scenario: GetClassroom
    Given I am logged in as admin
    Given I request "GET /classrooms"
    Then I get a "200" response

  Scenario: GetClassroomFail
    Given I am logged in as student
    Given I request "GET /classroom"
    Then I get a "500" response


  Scenario: EditClassroom
    Given I am logged in as admin
    Given I have the payload:
    """
           { "classrooms":
              [
                  {
                    "name": "r12",
                    "directions": "levo"
                  }
              ]
           }
    """
    Given I request "POST /addClassrooms"
    Given I request "GET /classroom/1"
    Then I get a "200" response
    Given I request "GET /classroom/2"
    Then I get a "500" response

  Scenario: DeleteClassroom
    Given I am logged in as admin