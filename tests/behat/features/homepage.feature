Feature: Homepage

  Scenario: HomePage
    Given I request "GET /"
    Then I get a "200" response