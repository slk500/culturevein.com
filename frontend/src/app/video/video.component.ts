import { Component, OnInit } from '@angular/core';
import {VideoService} from "../video.service";

@Component({
  selector: 'app-video',
  templateUrl: './video.component.html',
  styleUrls: ['./video.component.css']
})
export class VideoComponent implements OnInit {

    public videos = [];
    public errorMsg;

    constructor(private _videoService: VideoService) {}

    ngOnInit() {
        this._videoService.getVideos()
            .subscribe(data => this.videos = data,
                error => this.errorMsg = error)
    }


}
