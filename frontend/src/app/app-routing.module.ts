import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {VideoComponent} from "./video-list/video.component";
import {TagComponent} from "./tag-list/tag.component";
import {PageNotFoundComponent} from "./page-not-found/page-not-found.component";
import {TopTenComponent} from "./home-top-ten/top-ten.component";
import {AboutComponent} from "./about/about.component";
import {TagShowComponent} from "./tag-show/tag-show.component";
import {VideoShowComponent} from "./video-show/video-show.component";
import {AddComponent} from "./video-add/add.component";
import {RegisterComponent} from "./user-register/register.component";
import {LoginComponent} from "./user-login/login.component";
import {ActivityComponent} from "./activity/activity.component";
import {ArtistShowComponent} from "./artist-show/artist-show.component";
import {VideoEditComponent} from "./video-edit/video-edit.component";

const routes: Routes = [
    { path: '', component: TopTenComponent},
    { path: 'videos', component: VideoComponent},
    { path: 'videos/:youtubeId', component: VideoShowComponent},
    { path: 'videos/:youtubeId/edit', component: VideoEditComponent},
    { path: 'tags', component: TagComponent},
    { path: 'tags/:slug', component: TagShowComponent},
    { path: 'artists/:slug', component: ArtistShowComponent},
    { path: 'about', component: AboutComponent},
    { path: 'add', component: AddComponent},
    { path: 'register', component: RegisterComponent},
    { path: 'login', component: LoginComponent},
    { path: 'activity', component: ActivityComponent},
    { path: "**", component: PageNotFoundComponent}
];

@NgModule({
    exports: [ RouterModule ],
    imports: [ RouterModule.forRoot(routes) ],
})

export class AppRoutingModule { }
