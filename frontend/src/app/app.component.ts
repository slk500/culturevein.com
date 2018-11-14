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
    user:string;
    editUser:string;

    public href: string = "";

    constructor(private router: Router, private inputService: InputService, private _authService: AuthService) {}

    updateValue(e){
        this.editUser = e.target.value;
        this.editTheUser();
    }

    editTheUser(){
        this.inputService.editUser(this.editUser);
    }
}

