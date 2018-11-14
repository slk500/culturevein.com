import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {VideoComponent} from "./video/video.component";
import {TagComponent} from "./tag/tag.component";
import {PageNotFoundComponent} from "./page-not-found/page-not-found.component";
import {TopTenComponent} from "./top-ten/top-ten.component";
import {AboutComponent} from "./about/about.component";
import {LinksComponent} from "./links/links.component";
import {TagShowComponent} from "./tag-show/tag-show.component";
import {VideoShowComponent} from "./video-show/video-show.component";
import {AddComponent} from "./add/add.component";
import {RegisterComponent} from "./register/register.component";
import {LoginComponent} from "./login/login.component";

const routes: Routes = [
    { path: '', component: TopTenComponent},
    { path: 'videos', component: VideoComponent},
    { path: 'videos/:youtubeId', component: VideoShowComponent},
    { path: 'tags', component: TagComponent},
    { path: 'tags/:slug', component: TagShowComponent},
    { path: 'about', component: AboutComponent},
    { path: 'links', component: LinksComponent},
    { path: 'add', component: AddComponent},
    { path: 'register', component: RegisterComponent},
    { path: 'login', component: LoginComponent},
    { path: "**", component: PageNotFoundComponent}
];

@NgModule({
    exports: [ RouterModule ],
    imports: [ RouterModule.forRoot(routes) ],
})

export class AppRoutingModule { }
