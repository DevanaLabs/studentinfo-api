Feature: zDeleteAll

  Scenario:
    Given I am logged in as admin
    Given I request "DELETE /student/1"
    Then I get a "200" response