import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-links',
  template: `
      <div class='col-xs-10 col-xs-offset-1 white_container'>
          <ol>
              <li><a href="http://tvtropes.org/">TV Tropes</a>
                  Biggest "tropes" database in the Internet.
                  A trope "can be a plot trick, a setup, a narrative structure, a character type, a linguistic idiom."

              <li> <a href="http://www.imcdb.org/">Internet Movie Cars Database</a>
                  The most complete list on the web about cars, bikes, trucks and other
                  vehicles seen in movies and TV series, image captures and information about them.</li>
          </ol>
      </div>
  `,
  styles: []
})
export class LinksComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

}
