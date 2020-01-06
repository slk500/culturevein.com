Feature: Tags descendants
  In order to manage tags
  As an API client
  I need to be able to create, see, edit, delete tags

#  Scenario: SHOW
#    Given there is an tag with name "Bomberman"
#    And there is an tag with name "Video Game"
#    And "bomberman" is descendant of "video-game"
#    When I send a "GET" request to "tags/video-game/descendants"
#    Then the response should be in JSON
#    And the response status code should be 200
#    And the response should be
#    """
#    {"data":[{"tag_slug_id":"bomberman","name":"Bomberman"}]}
#    """

  Scenario: SHOW TAG WITH INCLUDED DESCENDANTS
    Given there is a video with artist name "Moby" and name "We Are All Made Of Stars"
    And there is an tag with name "Video Game"
    And there is an tag with name "Donkey Kong"
    And "donkey-kong" is descendant of "video-game"
    And this video have video tag "Donkey Kong"
    And this video have video tag time "Donkey Kong" with time start "10" and stop "20"
    When I send a "GET" request to "tags/video-game"
    Then the response should be in JSON
    And the response status code should be 200
    And the response should be
    """
    {"data":[{"tag_slug_id":"bomberman","name":"Bomberman"}]}
    """