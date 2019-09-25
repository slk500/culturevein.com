Feature: Tags
  In order to manage tags
  As an API client
  I need to be able to create, see, edit, delete tags

  Scenario: CREATE when video dosen't exist
    Given I have the payload:
      """
      {
        "start": "10",
        "stop" : "20"
      }
      """
    When I send a "POST" request to "videos/someYTID123/tags/basketball"
    And the response status code should be 404
    And the response should be
    """
    {
      "errors": "Video: someYTID123 not found"
    }
    """

  Scenario: SHOW
    Given there is an tag with name "basketball"
    When I send a "GET" request to "tags/basketball"
    Then the response status code should be 200
    And the response "Content-Type" header should be "application/json"
    And the response should be in JSON
    And the response should be
    """
    {
      "data": {
            "id": "basketball",
            "name": "basketball",
            "subscribers": 0,
            "videos": [ ]
              }
    }
    """

  Scenario: SHOW when dosen't exist
    When I send a "GET" request to "tags/basketball"
    Then the response status code should be 404
    And the response "Content-Type" header should be "application/json"
    And the response should be in JSON
    And the response should be
    """
    {
      "errors": "Tag: basketball not found"
    }
    """