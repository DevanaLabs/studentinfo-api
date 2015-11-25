Feature: aTest

  Scenario: AddAll
    Given I request "GET /addFaculty"
    Then I get a "200" response
    Given I request "GET /addAdmin"
    Then I get a "200" response
    Given I request "GET /addStudent"
    Then I get a "200" response