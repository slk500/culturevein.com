Feature: Tags
  In order to manage videos
  As an API client
  I need to be able to create, see

  Scenario: CREATE
    Given I have the payload:
      """
      {
        "artist":	  "Martin Solveig,
        "name":	      "Do It Right (Official Video) ft. Tkay Maidza",
        "youtube_id": "wQRV5omnBBU"
      }
      """
    When I send a "POST" request to "videos"
    And the response status code should be 201

