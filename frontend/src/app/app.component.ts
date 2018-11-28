import { Component } from '@angular/core';
import {Router} from "@angular/router";
import {InputService} from "./services/input.service";
import {AuthService} from "./auth.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app';

    public href: string = "";

    constructor(private router: Router, private inputService: InputService, public _authService: AuthService) {}

    updateValue(e){
        let inputText = e.target.value;
        this.passInputText(inputText);
    }

    passInputText(inputText: string){
        this.inputService.search(inputText);
    }
}

