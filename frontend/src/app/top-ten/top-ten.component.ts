import { Component, OnInit } from '@angular/core';
import {TagService} from "../tag.service";
import {VideoService} from "../video.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-top-ten',
  templateUrl: './top-ten.component.html',
  styleUrls: ['./top-ten.component.css']
})
export class TopTenComponent implements OnInit {

    public tagsNew = [];

    public tagsTop = [];

    public videosTopTags = [];

    public videosLastAdded = [];

    public errorMsg;

    constructor(private _tagService: TagService, private _videoService: VideoService, private router: Router) {}

    ngOnInit() {
        this._tagService.getTagsNew()
            .subscribe(data => this.tagsNew = data,
                error => this.errorMsg = error);

        this._tagService.getTagsTop()
            .subscribe(data => this.tagsTop = data,
                error => this.errorMsg = error);

        this._videoService.getVideosTopTag()
            .subscribe(data => this.videosTopTags = data,
                error => this.errorMsg = error);

        this._videoService.getVideosLastAdded()
            .subscribe(data => this.videosLastAdded = data,
                error => this.errorMsg = error);
    }

    onSelect(tag){
        this.router.navigate(['/tags', tag.slug]);
    }
}
