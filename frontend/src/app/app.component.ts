import {Component} from '@angular/core';
import {Router} from "@angular/router";
import {InputService} from "./services/input.service";
import {AuthService} from "./auth.service";
import {Meta, Title} from "@angular/platform-browser";
import {SeoService} from "./seo.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app';

  constructor(private router: Router, private inputService: InputService, public _authService: AuthService,
              private seoService: SeoService)
  {}

  ngOnInit() {
    this.seoService.setTitle('Music Video Database Tagged By Subject Matter | CultureVein');
    this.seoService.setMetaDescription('A community annotated music video database tagged by subject matter - ' +
      'it can be a person, object, word or phrase, scene, gesture, cliche, trope.');
  }

  updateValue(e) {
    let inputText = e.target.value;
    this.passInputText(inputText);
  }

  passInputText(inputText: string) {
    this.inputService.search(inputText);
  }
}

