Feature: Lecture

  Scenario: AddClassroom
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

  Scenario: AddLectureSuccess
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                      "teacherId": "2",
                      "courseId": "2",
                      "classroomId": "2",
                      "type": "?????????",
                      "startsAt": "2016-1-27 17:00",
                      "endsAt": "2016-1-27 19:00",
                      "groups": []
                  }
    """
    Given I request "POST /lecture"
    Then I get a "200" response


  Scenario: AddLectureFail
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                      "teacherId": "5",
                      "courseId": "2",
                      "classroomId": "2",
                      "type": "?????????",
                      "startsAt": "2016-1-27 17:00",
                      "endsAt": "2016-1-27 19:00",
                      "groups": []
                  }
    """
    Given I request "POST /lecture"
    Then I get a "500" response

  Scenario: AddLectureFail
    Given I am logged in as admin
    Given I have the payload:
    """
                  {
                      "courseId": "2",
                      "classroomId": "2",
                      "type": "?????????",
                      "startsAt": "2016-1-27 17:00",
                      "endsAt": "2016-1-27 19:00",
                      "groups": []
                  }
    """
    Given I request "POST /lecture"
    Then I get a "422" response

  Scenario: GetLecture
    Given I am logged in as admin
    Given I request "GET /lecture/1"
    Then I get a "200" response


  Scenario: GetLectures
    Given I am logged in as admin
    Given I request "GET /lectures"
    Then I get a "200" response

  Scenario: EditLecture
    Given I have the payload:
    """
                  {
                      "teacherId": "2",
                      "courseId": "2",
                      "classroomId": "2",
                      "type": "?????????",
                      "startsAt": "2016-1-28 17:00",
                      "endsAt": "2016-1-28 19:00",
                      "groups": []
                  }
    """
    Given I request "PUT /classroom/1"
    Then I get a "200" response

  Scenario: DeleteLectureSuccess
    Given I am logged in as admin
    Given I request "DELETE /lecture/1"
    Then I get a "200" response

  Scenario: DeleteLectureFail
    Given I am logged in as admin
    Given I request "DELETE /lecture/2"
    Then I get a "500" response

  Scenario: DeleteCourse
    Given I am logged in as admin
    Given I request "DELETE /course/2"
    Then I get a "200" response

  Scenario: DeleteProfessor
    Given I am logged in as admin
    Given I request "DELETE /professor/2"
    Then I get a "200" response

  Scenario: DeleteClassroom
    Given I am logged in as admin
    Given I request "DELETE /classroom/2"
    Then I get a "200" response