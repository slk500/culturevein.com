import {Component, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {VideoService} from "../services/video.service";
import {TagService} from "../services/tag.service";
import {NgxY2PlayerComponent} from "ngx-y2-player";
import {Ivideo} from "../interfaces/video";

@Component({
    selector: 'app-video-show',
    templateUrl: './video-edit.component.html',
    styleUrls: ['./video-edit.component.css']
})

export class VideoEditComponent implements OnInit {

    @ViewChild('video') video: NgxY2PlayerComponent;

    public youtubeId: string;

    public videoInfo: Ivideo;

    public errorMsg;

    public videoTags = [];

    public tags;

    public playerOptions;

    public Math;

    public select2Options: Select2Options;

    public isSelect2ChangedValue = false;

    public isVideoTagExist = false;

    public timeRange: number[] = [0, 0];

    public selectedTagSlugId: string;

    public tagWasAddedText: boolean;

    public interval;

    public selectedTagName: string;

    public isVideoTagTimeExistForSelectedVideoTag: boolean;

    public isTagComplete: boolean;

    public startValue = '';

    public temp = '';

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

        this._tagService.getTagsSimple()
            .subscribe(data => {
                this.tags = this.convertToFormat(data);
                },
                error => this.errorMsg = error);

        this.playerOptions = {
            videoId: this.youtubeId,
            height: 'auto',
            width: 'auto',
        };

        this.select2Options = {
            placeholder: { id: '', text: 'Select TAG or type a new one' },
            tags: true
        };
    }

    public deleteVideoTag(youtube_id: string, tag_slug_id: string) {

        this._tagService.deleteVideoTag(youtube_id, tag_slug_id)
            .subscribe((data: any) => {
                this._tagService.getVideoTagsForVideo(this.youtubeId)
                    .subscribe(data => {
                            this.videoTags = data;
                            this.isVideoTagExist = false;
                        },
                        error => this.errorMsg = error);
            });
    }

    public deleteVideoTagTime(video_youtube_id: string, tag_slug_id: string, video_tag_time_id: number) {
        this._tagService.deleteVideoTagTime(video_youtube_id, tag_slug_id, video_tag_time_id)
            .subscribe((data: any) => {
                this._tagService.getVideoTagsForVideo(this.youtubeId)
                    .subscribe(data => {
                            this.videoTags = data;
                            this.isVideoTagExist = this.isSelectedVideoTagExist(this.selectedTagName);
                        },
                        error => this.errorMsg = error);
            });
    }

    public changed(e: any): void {
        this.selectedTagSlugId = e.value;
        this.selectedTagName = e.data[0].text;

        if(this.selectedTagSlugId){
            this.isSelect2ChangedValue = true;
        }

        this.isVideoTagTimeExistForSelectedVideoTag = false;
        this.isTagComplete = false;

        this.isVideoTagExist = this.isSelectedVideoTagExist(this.selectedTagName);
    }

    convertToFormat(data) {

        data.unshift({slug: '', name: ''}); //placeholder select2

        return data.map(tag => {
            return {
                id: tag.slug,
                text: tag.name
            };
        });

    }

    isSelectedVideoTagExist(selected: string): boolean {
        for (let index = 0; index < this.videoTags.length; ++index) {
            if (this.videoTags[index].tag_name == selected) {
                this.isVideoTagTimeExistForSelectedVideoTag = this.videoTags[index].video_tags_time.length > 0;
                this.isTagComplete = this.videoTags[index].is_complete;

                if(this.videoTags[index].video_tags_time.length == 0){
                    this.setVideoTagAsUncompleted(this.videoInfo.video_youtube_id, this.videoTags[index].tag_slug_id)
                }

                return true;
            }
        }
        return false;
    }

    setVideoTagAsCompleted(video_youtube_id: string, tag_slug_id: string) {
        this._tagService.setCompleted(video_youtube_id, tag_slug_id)
            .subscribe((data: any) => {
                this._tagService.getVideoTagsForVideo(this.youtubeId)
                    .subscribe(data => {
                            this.videoTags = data;
                            this.isTagComplete = true;
                        },
                        error => this.errorMsg = error);
            });
    }

    setVideoTagAsUncompleted(video_youtube_id: string, tag_slug_id: string) {
        this._tagService.setUncompleted(video_youtube_id, tag_slug_id)
            .subscribe((data: any) => {
                this._tagService.getVideoTagsForVideo(this.youtubeId)
                    .subscribe(data => {
                            this.videoTags = data;
                            this.isTagComplete = false;
                        },
                        error => this.errorMsg = error);
            });
    }

    addVideoTag(): void {
        this._tagService.addVideoTag(this.videoInfo.video_youtube_id, this.selectedTagName)
            .subscribe((data: any) => {

              let newTag = Object.assign([], this.tags);
              newTag.unshift({id: data.tag_slug_id, text: data.tag_name});
              this.tags = newTag;

            this._tagService.getVideoTagsForVideo(this.youtubeId)
                .subscribe(data => {
                        this.videoTags = data;
                        this.isVideoTagExist = true;
                        this.tagWasAddedText = true;
                    },
                    error => this.errorMsg = error);
        });



        setTimeout(() => {
            this.tagWasAddedText = false
        }, 3000);
    }

    addVideoTagTime(start: number, stop: number) {

        this._tagService.addVideoTagTime(this.videoInfo.video_youtube_id, this.selectedTagSlugId, start, stop)
          .subscribe((data: any) => {
            this._tagService.getVideoTagsForVideo(this.youtubeId)
                .subscribe(data => {
                        this.videoTags = data;
                        this.tagWasAddedText = true;
                        this.isVideoTagTimeExistForSelectedVideoTag = true;

                    },
                    error => this.errorMsg = error);
        });

        setTimeout(() => {
            this.tagWasAddedText = false;
        }, 3000);
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
        if(arr) {
            if (arr.start == 0 && arr.stop == this.videoInfo.duration) {
                return 'label-danger'
            }
        }

        return 'label-warning'
    }
}

