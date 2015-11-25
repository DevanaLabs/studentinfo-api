Feature: zDeleteAll

  Scenario:
    Given I am logged in as admin
    Given I request "DELETE /student/2"
    Then I get a "200" response