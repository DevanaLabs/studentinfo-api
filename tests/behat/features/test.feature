Feature: Test



  Scenario: RegisterSuccess
    Given I am logged in as admin
    Given I have the payload:
    """
           { "emails":
              [
                  {
                  "email": "mv@gmail1.com"
                  }
              ]
           }
    """
    When I request "POST /register"
    Then I get a "200" response



