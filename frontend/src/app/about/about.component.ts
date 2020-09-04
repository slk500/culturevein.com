import { Component, OnInit } from '@angular/core';
import {VideoService} from "../services/video.service";
import {InputService} from "../services/input.service";

@Component({
  selector: 'app-about',
  template: `
    <div *ngIf="searchText">
      <app-tag></app-tag>
      <app-video></app-video>
    </div>

    <div *ngIf="!searchText">
      <div class='col-xs-10 col-xs-offset-1 white_container'>
          <p>Tagging means describing the content with relevant keywords</p>
          <ol id='lista'>
              <li>On this site you can search through music videos which have been embedded from YouTube</li><br>
              <li>You can add a new music video or tag without registration</li><br>
              <ul>
                  Tags are divided into 4 groups/colors:
                  <li><span class="label label-default">Grey</span> tag without exposure time </li>
                  <li><span class="label label-danger">Red</span> tag with exposure time equal to duration of the video. Tag can describe whole video - like lyric video</li>
                  <li><span class="label label-warning">Orange</span> tag with at least one exposure time added but there are more to add</li>
                  <li><span class="label label-success">Green</span> tag with completly all exposure times added</li>
              </ul><br>
              <li>It's still very early experimental version of site. Not everything works ;)   </li><br>
              <li>This app use YouTube API Services - please read
                <a href="https://www.youtube.com/t/terms"> YouTube Terms of Service (ToS) </a>
                and
                <a href="https://policies.google.com/privacy"> Google Privacy Policy </a> </li>
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
    </div>
  `,
  styles: ['#lista {\n' +
  'padding-left:20px;\n' +
  '}']
})
export class AboutComponent implements OnInit {

  public searchText;

  constructor(private inputSearch: InputService) { }

  ngOnInit() {
    this.inputSearch.cast.subscribe(input => this.searchText = input);
  }

}
