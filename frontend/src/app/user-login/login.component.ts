import { Component, OnInit } from '@angular/core';
import {AuthService} from "../auth.service";
import {Router} from "@angular/router";
import {SeoService} from "../seo.service";

class LoginUserData implements ILoginUserData {
    email: string;
    password: string;
}

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})

export class LoginComponent implements OnInit {

  public loginUserData: ILoginUserData = new LoginUserData();

  public errors;

  constructor(private _auth: AuthService, private _route: Router, private seoService: SeoService) { }

  ngOnInit() {
    this.seoService.setTitle('Login | CultureVein');
    this.seoService.setMetaRobotsNoIndexNoFollow();
  }

  loginUser(){
      this._auth.loginUser(this.loginUserData)
          .subscribe(
              res => {
                  localStorage.setItem('token', res.token);
                  this._route.navigate(['/']);
              },
              err => {
                this.errors = err.error;
              }
          );
  }

}
