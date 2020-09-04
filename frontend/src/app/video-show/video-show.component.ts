import {Component, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {VideoService} from "../services/video.service";
import {TagService} from "../services/tag.service";
import {NgxY2PlayerComponent} from "ngx-y2-player";
import {Ivideo} from "../interfaces/video";

@Component({
  selector: 'app-video-show',
  templateUrl: './video-show.component.html',
  styleUrls: ['./video-show.component.css']
})

export class VideoShowComponent implements OnInit {

  @ViewChild('video') video: NgxY2PlayerComponent;

  public youtubeId: string;

  public videoInfo: Ivideo;

  public errorMsg;

  public videoTags = [];

  public tags;

  public playerOptions;

  public Math;

  public timeRange: number[] = [0, 0];

  public interval;

  constructor(private route: ActivatedRoute, private router: Router,
              private _videoService: VideoService,
              private _tagService: TagService) {
    this.Math = Math;
  }

  ngOnInit() {
    this.route.paramMap.subscribe((params: ParamMap) => {
      this.youtubeId = params.get('youtubeId');
    });

    this._videoService.getVideo(this.youtubeId)
      .subscribe(data => {
          this.videoInfo = data[0];
          this.timeRange[1] = data[0].duration;
          this.timeRange[0] = 0;
        },
        error => this.errorMsg = error);

    this._tagService.getVideoTagsForVideo(this.youtubeId)
      .subscribe(data => this.videoTags = data,
        error => this.errorMsg = error);

    this.playerOptions = {
      videoId: this.youtubeId,
      height: 'auto',
      width: 'auto',
    };
  }

  stopAt(stop) {

    if (this.video.videoPlayer.getCurrentTime() >= stop) {
      this.video.videoPlayer.pauseVideo();
      if (this.interval) {
        clearInterval(this.interval);
      }
    }
  }

  playPart(start, stop): void {

    if (this.interval) {
      clearInterval(this.interval);
    }

    this.video.videoPlayer.seekTo(start, true);
    if (this.video.videoPlayer.getPlayerState() != YT.PlayerState.PLAYING) {
      this.video.videoPlayer.playVideo();

      this.interval = setInterval(() => {
        this.stopAt(stop);
      }, 1000);
    }
  }

  tagStyle(tag): string {

    if (!tag['video_tags_time'].length) {
      return 'label-default';
    }

    if (tag.is_complete) {
      return 'label-success';
    }

    let arr = tag.video_tags_time[0];
    if (arr) {
      if (arr.start == 0 && arr.stop == this.videoInfo.duration) {
        return 'label-danger'
      }
    }

    return 'label-warning';
  }
}

