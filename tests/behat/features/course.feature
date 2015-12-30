Feature: Course

  Scenario: AddCourseSuccess
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                    "name": "Analiza",
                    "code": "M1",
                    "semester": "3",
                    "espb": "6"
                  }
    """
    Given I request "POST /course"
    Then I get a "200" response

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
    Given I request "GET /course/1"
    Then I get a "200" response

  Scenario: GetCourseFail
    Given I am logged in as student
    Given I request "GET /courses"
    Then I get a "200" response

  Scenario: EditCourse
    Given I have the payload:
    """
                  {
                    "name": "Analiza",
                    "code": "M2",
                    "semester": "2",
                    "espb": "6"
                  }
    """
    Given I request "PUT /course/1"
    Then I get a "200" response

  Scenario: DeleteCourseSuccess
    Given I am logged in as admin
    Given I request "DELETE /course/1"
    Then I get a "200" response

  Scenario: DeleteCourseFail
    Given I am logged in as admin
    Given I request "DELETE /course/2"
    Then I get a "500" response