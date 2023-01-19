import { Component, OnInit } from '@angular/core';
import {AuthService} from "../auth.service";
import {Router} from "@angular/router";
import {SeoService} from "../seo.service";

class RegisterUserData implements IRegisterUserData {
    email: string;
    password: string;
    username: string;
}

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})

export class RegisterComponent implements OnInit {

  public registerUserData: IRegisterUserData = new RegisterUserData();

  public errors;

  constructor(private _auth: AuthService, private _route: Router, private seoService: SeoService) { }

  ngOnInit() {
    this.seoService.setTitle('Register | CultureVein');
    this.seoService.setMetaRobotsNoIndexNoFollow();
  }

  registerUser(){
    this._auth.registerUser(this.registerUserData)
        .subscribe(
        res => {
                localStorage.setItem('token', res.token);
                this._route.navigate(['/']);
        },
            err => this.errors = err.error
    )
  }
}
