Feature: Test

  Scenario: Homepage
    When I request "GET /"
    Then I get a "200" response

  Scenario: LoginWrong
    Given I have the payload:
    """
           {
               "email": "wrong@gmail.com",
                "password": "wrongpassword"
           }
    """
    When I request "POST /auth"
    Then I get a "403" response

  Scenario: LoginSuccess
    Given I have the payload:
    """
           {
              "email": "nu@gmail.com",
              "password": "blabla"
           }
    """
    When I request "POST /auth"
    Then I get a "200" response

