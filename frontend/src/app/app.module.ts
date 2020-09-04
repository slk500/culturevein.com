import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule }   from '@angular/forms';

import { AppComponent } from './app.component';
import { TagComponent } from './tag-list/tag.component';
import { TagService } from "./services/tag.service";
import {HTTP_INTERCEPTORS, HttpClientModule} from "@angular/common/http";
import { VideoComponent } from './video-list/video.component';
import { AppRoutingModule } from './/app-routing.module';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { TopTenComponent } from './home-top-ten/top-ten.component';
import { AboutComponent } from './about/about.component';
import { TagShowComponent } from './tag-show/tag-show.component';
import { VideoShowComponent } from './video-show/video-show.component';
import {MinuteSecondsPipe} from "./pipes/minute-seconds.pipe";
import {NgxY2PlayerModule} from "ngx-y2-player";
import {Select2Module} from "ng2-select2";
import { FilterTagsPipe }from './pipes/filter-tags.pipe';
import {InputService} from "./services/input.service";
import {APIInterceptor} from "./http-interceptor";
import {SliderModule} from 'primeng/slider';
import { AddComponent } from './video-add/add.component';
import { RegisterComponent } from './user-register/register.component';
import { LoginComponent } from './user-login/login.component';
import {AuthService} from "./auth.service";
import { ActivityComponent } from './activity/activity.component';
import {ArtistShowComponent} from "./artist-show/artist-show.component";
import {FilterVideosPipe} from "./pipes/filter-videos.pipe";
import {VideoEditComponent} from "./video-edit/video-edit.component";

@NgModule({
  declarations: [
    AppComponent,
    TagComponent,
    VideoComponent,
    PageNotFoundComponent,
    TopTenComponent,
    AboutComponent,
    TagShowComponent,
    VideoShowComponent,
    MinuteSecondsPipe,
    FilterTagsPipe,
    FilterVideosPipe,
    AddComponent,
    RegisterComponent,
    LoginComponent,
    ActivityComponent,
    ArtistShowComponent,
    VideoEditComponent
  ],
  imports: [
    BrowserModule,
       HttpClientModule,
       AppRoutingModule,
      NgxY2PlayerModule,
      Select2Module,
      FormsModule,
      SliderModule
  ],
  providers: [AuthService, TagService, InputService, {
      provide: HTTP_INTERCEPTORS,
      useClass: APIInterceptor,
      multi: true,
  }],
  bootstrap: [AppComponent]
})
export class AppModule { }
