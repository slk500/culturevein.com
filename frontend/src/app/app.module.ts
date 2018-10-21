import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule }   from '@angular/forms';

import { AppComponent } from './app.component';
import { TagComponent } from './tag/tag.component';
import { TagService } from "./services/tag.service";
import {HTTP_INTERCEPTORS, HttpClientModule} from "@angular/common/http";
import { VideoComponent } from './video/video.component';
import { AppRoutingModule } from './/app-routing.module';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import { TopTenComponent } from './top-ten/top-ten.component';
import { LinksComponent } from './links/links.component';
import { AboutComponent } from './about/about.component';
import { TagShowComponent } from './tag-show/tag-show.component';
import { VideoShowComponent } from './video-show/video-show.component';
import {MinuteSecondsPipe} from "./pipes/minute-seconds.pipe";
import {NgxY2PlayerModule} from "ngx-y2-player";
import {Select2Module} from "ng2-select2";
import { FilterPipe }from './pipes/filter.pipe';
import {InputService} from "./services/input.service";
import {APIInterceptor} from "./http-interceptor";
import {SliderModule} from 'primeng/slider';
import { AddComponent } from './add/add.component';

@NgModule({
  declarations: [
    AppComponent,
    TagComponent,
    VideoComponent,
    PageNotFoundComponent,
    TopTenComponent,
    LinksComponent,
    AboutComponent,
    TagShowComponent,
    VideoShowComponent,
    MinuteSecondsPipe,
    FilterPipe,
    AddComponent,
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
  providers: [TagService, InputService, {
      provide: HTTP_INTERCEPTORS,
      useClass: APIInterceptor,
      multi: true,
  }],
  bootstrap: [AppComponent]
})
export class AppModule { }
