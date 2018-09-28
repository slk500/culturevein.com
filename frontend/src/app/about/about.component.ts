import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-about',
  template: `
      <div class='col-xs-10 col-xs-offset-1 white_container'>
          <p>Tagging means describing the content with relevant keywords</p>
          <ol id='lista'>
              <li>On this site you can search through music videos which have been embedded from YouTube</li><br>
              <li>You can add a new music video or tag without registration</li><br>
              <ul>
                  Tags are divided into 4 groups/colors:
                  <li><span class="label label-default">Grey</span> tag without exposure time </li>
                  <li><span class="label label-danger">Red</span> tag with exposure time equal to duration of the video. Tag can describe whole video - like lyric video</li>
                  <li><span class="label label-warning">Orange</span> tag with at least one exposure time added but there are more to tag</li>
                  <li><span class="label label-success">Green</span> tag with completly all exposure times added</li>
              </ul><br>
              <li>You can follow a tag and get notifications every time someone adds
                  it to a video. To do so, you need to be registered user..</li><br>
              <li>If you like this site please let me know - give a like on <a href="https://www.facebook.com/CultureVein">FACEBOOK</a> or contact me.</li><br>
              <li>It's still very early experimental version of site. Not everything works ;)   </li><br>
          </ol>
          <br>
          <p><strong>CONTACT</strong><br>
              slawomir.grochowski@gmail.com<br>
              
              <a class="btn btn-social-icon btn-facebook" href="http://www.facebook.com/SlawomirGrochowski" >
                  <span class="fa fa-facebook"></span>
              </a>

              <a class="btn btn-social-icon btn-twitter" href="http://www.twitter.com/s_grochowski" >
                  <span class="fa fa-twitter"></span>
              </a>

          </p>
      </div>
      
  `,
  styles: ['#lista {\n' +
  'padding-left:20px;\n' +
  '}']
})
export class AboutComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

}
