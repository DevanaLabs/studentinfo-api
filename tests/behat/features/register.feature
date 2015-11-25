Feature: Register

  Scenario: RegisterFail
    When I request "GET /register/12345"
    Then I get a "403" response