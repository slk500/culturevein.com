Feature: Tags descendants
  In order to manage tags
  As an API client
  I need to be able to create, see, edit, delete tags

  Scenario: SHOW
    Given there is an tag with name "Bomberman"
    Given there is an tag with name "Video Game"
    And "bomberman" is descendant of "video-game"
    When I send a "GET" request to "tags/video-game/descendants"
    Then the response should be in JSON
    And the response status code should be 200
    And the response should be
    """
    {"data":[{"tag_slug_id":"bomberman","name":"Bomberman"}]}
    """