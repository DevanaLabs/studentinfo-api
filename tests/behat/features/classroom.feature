Feature: Classroom

  Scenario: AddClassroomSuccess
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                    "name": "r12",
                    "directions": "levo",
                    "floor": "11"
                  }
    """
    Given I request "POST /classroom"
    Then I get a "200" response

  Scenario: AddClassroomFail
    Given I have the payload:
    """
                  {
                    "directions": "r1222"
                  }
    """
    Given I request "POST /classroom"
    Then I get a "403" response

  Scenario: GetClassroom
    Given I am logged in as admin
    Given I request "GET /classroom/1"
    Then I get a "200" response


  Scenario: GetClassroom
    Given I am logged in as admin
    Given I request "GET /classrooms"
    Then I get a "200" response


  Scenario: EditClassroom
    Given I have the payload:
    """
                  {
                    "name": "r1231",
                    "directions": "desno",
                    "floor": "11"
                  }
    """
    Given I request "PUT /classroom/1"
    Then I get a "200" response

  Scenario: DeleteClassroomSuccess
    Given I am logged in as admin
    Given I request "DELETE /classroom/1"
    Then I get a "200" response

  Scenario: DeleteClassroomFail
    Given I am logged in as admin
    Given I request "DELETE /classroom/2"
    Then I get a "500" response