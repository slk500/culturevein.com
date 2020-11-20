import { Component, OnInit } from '@angular/core';
import {TagService} from "../services/tag.service";
import {VideoService} from "../services/video.service";
import {InputService} from "../services/input.service";
import {SeoService} from "../seo.service";

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

    public searchText;

    constructor(private _tagService: TagService, private _videoService: VideoService, private inputSearch: InputService,
                private seoService: SeoService) {}

    ngOnInit() {
      this.seoService.setTitle('Music Video Database Tagged By Subject Matter | CultureVein');
      this.seoService.setMetaDescription('A community annotated music video database on YouTube, tagged by subject matter - ' +
        'it can be a person, object, word or phrase, scene, gesture, cliche, trope.');

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

      this.inputSearch.cast.subscribe(input => this.searchText = input);
    }
}
