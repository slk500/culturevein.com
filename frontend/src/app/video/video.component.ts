import { Component, OnInit } from '@angular/core';
import {VideoService} from "../services/video.service";
import {InputService} from "../services/input.service";

@Component({
  selector: 'app-video',
  templateUrl: './video.component.html',
  styleUrls: ['./video.component.css']
})
export class VideoComponent implements OnInit {

    public videos = [];
    public errorMsg;
    public searchText;

    constructor(private _videoService: VideoService, private inputSearch: InputService) {}

    ngOnInit() {
        this._videoService.getVideos()
            .subscribe(data => this.videos = data,
                error => this.errorMsg = error)
        this.inputSearch.cast.subscribe(input => this.searchText = input);
    }

}
