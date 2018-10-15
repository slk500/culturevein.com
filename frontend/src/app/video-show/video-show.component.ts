import {Component, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {VideoService} from "../services/video.service";
import {TagService} from "../services/tag.service";
import {NgxY2PlayerComponent, NgxY2PlayerOptions} from "ngx-y2-player";
import {Select2OptionData} from "ng2-select2";
import {SliderModule} from 'primeng/slider';
import {Ivideo} from "../interfaces/video";

@Component({
    selector: 'app-video-show',
    templateUrl: './video-show.component.html',
    styleUrls: ['./video-show.component.css']
})

export class VideoShowComponent implements OnInit {

    @ViewChild('video') video: NgxY2PlayerComponent;

    public youtubeId;

    public videoInfo: Ivideo;

    public errorMsg;

    public videoTags;

    public tags;

    public playerOptions;

    public timer;

    public Math;

    public select2Options: Select2Options;

    public isExposureTime = null;

    public isSelect2ChangedValue = false;

    public rangeValues: number[] = [0, 100];

    public selectedValue;

    constructor(private route: ActivatedRoute, private router: Router, private _videoService: VideoService,
                private _tagService: TagService) {
        this.Math = Math;
    }

    ngOnInit() {
        this.route.paramMap.subscribe((params: ParamMap) => {
            this.youtubeId = params.get('youtubeId');
        });

        this._videoService.getVideo(this.youtubeId)
            .subscribe(data => this.videoInfo = data,
                error => this.errorMsg = error);

        this._tagService.getVideoTags(this.youtubeId)
            .subscribe(data => this.videoTags = data,
                error => this.errorMsg = error);

        this._tagService.getTags()
            .subscribe(data => this.tags = this.convertToFormat(data),
                error => this.errorMsg = error);

        this.playerOptions = {
            videoId: this.youtubeId,
            height: 'auto',
            width: 'auto',
            // playerVars: {
            //     autoplay: 1,
            // },
        };

        this.select2Options = {
            placeholder: 'Select TAG or type a new one',
            tags: true
        };
    }

    public changed(e: any): void {
        this.isSelect2ChangedValue = true;
        this.selectedValue = e.value;
    }

    convertToFormat(data) {
        return $.map(data, function (obj) {
            obj.text = obj.text || obj.name;
            return obj;
        });
    }

    setExposureTime(answer): void {
        this.isExposureTime = answer;
    }

    addTag(): void {

        let start = null;
        let stop = null;

        if(this.isExposureTime == true){
            start = this.rangeValues[0];
            stop = this.rangeValues[1];
        }

       this._tagService.addVideoTag(this.videoInfo.video_id, start, stop, this.selectedValue);
    }

    playPart(start, stop): void {

        clearTimeout(this.timer);

        this.video.videoPlayer.seekTo(start, true);
        if (this.video.videoPlayer.getPlayerState() != YT.PlayerState.PLAYING) {
            this.video.videoPlayer.playVideo();
        }

        let millisecondsInOneMinute = 1000;
        let secondsToPlay = stop - start;
        let hackAddTimeToPauseOnStopTime = 1000;
        this.timer = setTimeout(() => {
            this.video.videoPlayer.pauseVideo();
        }, secondsToPlay * millisecondsInOneMinute + hackAddTimeToPauseOnStopTime);
    }

    tagStyle(tag): string {

        if (tag.times == null) {
            return 'btn-default';
        }

        if (tag.complete) {
            return 'btn-success';
        }

        let arr = tag.times[0];
        if (arr.start == 0 && arr.stop == this.videoInfo.duration) {
            return 'btn-danger'
        }

        return 'btn-warning'
    }
}
