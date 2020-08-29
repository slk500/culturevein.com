import {Component, OnInit, ViewChild} from '@angular/core';
import {ArtistService} from "../artist.service";
import {YouTubeService} from "../you-tube.service";
import {VideoService} from "../services/video.service";
import {Router} from "@angular/router";
import {map} from "rxjs/internal/operators";
import {NgxY2PlayerComponent} from "ngx-y2-player";

@Component({
    selector: 'app-add',
    templateUrl: './add.component.html',
    styleUrls: ['./add.component.css']
})
export class AddComponent implements OnInit {

    @ViewChild('video') video;

    public youtubeId = '';

    public playerOptions;

    public input = '';

    public select2Options: Select2Options;

    public selectedArtist;

    public artists = [];

    public tempArtists = [];

    public artist;

    public title = '';

    public duration = 0;

    public errors;

    constructor(private _artistService: ArtistService, private _youTubeService: YouTubeService,
                private _videoService: VideoService, private router: Router) {
    }

    ngOnInit() {
        this._artistService.getArtists().
        pipe(map(arr => arr.map(el => el.name)),)
            .subscribe(
                data => {
                    this.tempArtists = data;
                },
                error => this.errors = error);
    }

    onPaste(event: ClipboardEvent) {
        let clipboardData = event.clipboardData;
        this.input = clipboardData.getData('text');
        this.embedIfYoutubeId();
    }

    onKey(event: any) {
        this.input = event.target.value;
        this.embedIfYoutubeId();
    }

    private embedIfYoutubeId() {
        this.findYouTubeId();

        if (this.youtubeId) {
            this.playerOptions = {
                videoId: this.youtubeId,
                height: 'auto',
                width: 'auto',
            };
        }
    }

    public getTitleAndDuration() {
      let artistAndTitle = this.video.videoPlayer.getVideoData().title.split("-");
      this.duration = this.video.videoPlayer.getDuration();

      this.artist = artistAndTitle[0].trim();
      this.title = artistAndTitle[1].trim();
      this.tempArtists.push(this.artist);
      this.tempArtists.sort();
      this.artists = this.tempArtists;
      this.selectedArtist = this.artist;

      this.select2Options = {
        placeholder: 'Select an artist or type a new one',
        tags: true
      };

    }

    public changed(e: any): void {
        this.selectedArtist = e.value;
    }

    private findYouTubeId(): void {
            let regEx = "^(?:https?:)?//[^/]*(?:youtube(?:-nocookie)?\.com|youtu\.be).*[=/]([-\\w]{11})(?:\\?|=|&|$)";
            let matches = this.input.match(regEx);
            if(matches){
                this.youtubeId = matches[1];
            }else{
                this.youtubeId = '';
            }
    }

    addVideo(){
        this._videoService.addVideo(
            this.selectedArtist, this.title, this.youtubeId, this.duration
        ).subscribe(data => {
                this.router.navigate([`/videos/${this.youtubeId}`]);
            },
            error => {
              this.router.navigate([`/videos/${this.youtubeId}`]);
        });
    }
}
