Feature: Course

  Scenario: AddCourseSuccess
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                    "code": "M1",
                    "semester": "3"
                  }
    """
    Given I request "POST /course"
    Then I get a "200" response
    And scope into the "success" property
    And the "data" property contains 1 items


  Scenario: AddCourseFail
    Given I have the payload:
    """
                  {
                    "semester": "3"
                  }
    """
    Given I request "POST /course"
    Then I get a "403" response

  Scenario: GetCourse
    Given I am logged in as admin
    Given I request "GET /courses"
    Then I get a "200" response

  Scenario: GetCourseFail
    Given I am logged in as student
    Given I request "GET /courses"
    Then I get a "200" response

  Scenario: EditCourse
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                    "code": "M2",
                    "semester": "4"
                  }
    """
    Given I request "POST /course"
    Given I request "GET /course/2"
    Then I get a "200" response
    Given I have the payload:
    """
                  {
                    "code": "M2",
                    "semester": "2"
                  }
    """
    Given I request "PUT /course/2"
    Then I get a "200" response
    Given I request "GET /course/5"
    Then I get a "500" response

  Scenario: DeleteCourseSuccess
    Given I am logged in as admin
    Given I request "DELETE /course/1"
    Then I get a "200" response

  Scenario: DeleteCourseSuccess
    Given I am logged in as admin
    Given I request "DELETE /course/2"
    Then I get a "200" response

  Scenario: DeleteCourseFail
    Given I am logged in as admin
    Given I request "DELETE /course/3"
    Then I get a "500" response