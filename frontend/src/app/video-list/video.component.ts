import { Component, OnInit } from '@angular/core';
import {VideoService} from "../services/video.service";
import {InputService} from "../services/input.service";
import {SeoService} from "../seo.service";

@Component({
  selector: 'app-video',
  templateUrl: './video.component.html',
  styleUrls: ['./video.component.css']
})
export class VideoComponent implements OnInit {

    public videos = [];
    public errorMsg;
    public searchText;

    constructor(private _videoService: VideoService, private inputSearch: InputService, private seoService: SeoService) {}

    ngOnInit() {
      this.seoService.setTitle('Artists - Music Video Database | CultureVein');
      this.seoService.setMetaDescription('Artists - Music Video Database tagged by subject matter');

      this._videoService.getVideos()
            .subscribe(data => this.videos = data,
                error => this.errorMsg = error);
        this.inputSearch.cast.subscribe(input => this.searchText = input);
    }

  getVideosCount(artists) {
      return artists
        .map(artist => artist.videos.length)
        .reduce((a,b) => a+b, 0)
  }


  highlight(query, content) {
    if(!query) {
      return content;
    }
    return content.replace(new RegExp(query, "gi"), match => {
      return '<span class="highlight">' + match + '</span>';
    });
  }

}
