import { Component, OnInit } from '@angular/core';
import {InputService} from "../services/input.service";
import {SeoService} from "../seo.service";

@Component({
  selector: 'app-about',
  template: `
    <div *ngIf="searchText">
      <app-tag></app-tag>
      <app-video></app-video>
    </div>

    <div *ngIf="!searchText">
      <div class='col-12'>
        <p>This site is a community annotated music video database tagged by subject matter.</p> <br>
          <p>Tagging means describing the content with relevant keywords. <br>
            The tag may be an action, a scene, a person, a word or phrase, an object, a gesture, or a cliche or trope.</p>
          <ol id='lista'>
              <li>You can add a new music video or tag without registration.</li><br>
              <ul>
                  Tags are divided into 4 groups/colors:
                  <li><span class="label label-default">Grey</span> tag without exposure time </li>
                  <li><span class="label label-danger">Red</span> tag with exposure time equal to duration of the video. Tag can describe whole video - like lyric video</li>
                  <li><span class="label label-warning">Orange</span> tag with at least one exposure time added but there are more to add</li>
                  <li><span class="label label-success">Green</span> tag with completly all exposure times added</li>
              </ul> <br>
            <li>This app use YouTube API Services - please read
              <a href="https://www.youtube.com/t/terms"> YouTube Terms of Service (ToS) </a>
              and
              <a href="https://policies.google.com/privacy"> Google Privacy Policy </a> </li> <br>
            <li> Project is open source - you are welcome to add new features & improvements
              <a href="https://github.com/slk500/culturevein.com">GitHub Repository</a>.</li><br>
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

  constructor(private inputSearch: InputService, private seoService: SeoService) {
  }

  ngOnInit() {
    this.inputSearch.cast.subscribe(input => this.searchText = input);
    this.seoService.setTitle('About | CultureVein')
    this.seoService.setMetaDescription('A community annotated music video database tagged by subject matter - ' +
      'it can be a person, object, word or phrase, scene, gesture, cliche, trope.')
  }

}
