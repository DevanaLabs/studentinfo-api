Feature: Log

  Scenario: logIn1Success
    Given I have the payload:
     """
           {
              "email": "nu@gmail.com",
              "password": "blabla"
           }
    """
    When I request "POST /auth"
    Then I get a "200" response

  Scenario: logOut1Success
    When I request "DELETE /auth"
    Then I get a "200" response

  Scenario: logIn2Success
    Given I have the payload:
     """
           {
              "email": "mv@gmail1.com",
              "password": "blabla"
           }
    """
    When I request "POST /auth"
    Then I get a "200" response

  Scenario: logOut2Success
    When I request "DELETE /auth"
    Then I get a "200" response

  Scenario: logIn1Fail
    Given I have the payload:
     """
           {
              "email": "nu@gmail.com",
              "password": "bla"
           }
    """
    When I request "POST /auth"
    Then I get a "403" response

  Scenario: logIn2Fail
    Given I have the payload:
     """
           {
              "email": "mv@gmail1.com",
              "password": "bla"
           }
    """
    When I request "POST /auth"
    Then I get a "403" response

  Scenario: logIn3Fail
    Given I have the payload:
     """
           {
              "password": "bla"
           }
    """
    When I request "POST /auth"
    Then I get a "422" response

  Scenario: logIn4Fail
    Given I have the payload:
     """
           {
              "email": "mv@gmail1.com"
           }
    """
    When I request "POST /auth"
    Then I get a "422" response
