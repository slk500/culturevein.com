import {Component} from '@angular/core';
import {Router} from "@angular/router";
import {InputService} from "./services/input.service";
import {AuthService} from "./auth.service";
import {Meta, Title} from "@angular/platform-browser";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app';

  constructor(private router: Router, private inputService: InputService, public _authService: AuthService,
              private titleService: Title, private metaService: Meta)
  {
    this.titleService.setTitle('CultureVein - music video database');
    this.metaService.updateTag({ name: 'description', content: 'in music video, music video database'});
  }

  updateValue(e) {
    let inputText = e.target.value;
    this.passInputText(inputText);
  }

  passInputText(inputText: string) {
    this.inputService.search(inputText);
  }
}

