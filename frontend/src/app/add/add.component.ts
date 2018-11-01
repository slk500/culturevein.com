import {Component, OnInit} from '@angular/core';
import {ArtistService} from "../artist.service";
import {YouTubeService} from "../you-tube.service";
import {VideoService} from "../services/video.service";
import {Router} from "@angular/router";
import {map} from "rxjs/internal/operators";

@Component({
    selector: 'app-add',
    templateUrl: './add.component.html',
    styleUrls: ['./add.component.css']
})
export class AddComponent implements OnInit {

    public youtubeId = '';

    public playerOptions;

    public input = '';

    public text = '';

    public select2Options: Select2Options;

    public selectedValue;

    public artists = [];

    public artist;

    public title = '';

    public errorMsg;

    constructor(private _artistService: ArtistService, private _youTubeService: YouTubeService,
                private _videoService: VideoService, private router: Router) {
    }

    ngOnInit() {

    }

    addVideo(){
        this._videoService.addVideo(
          this.selectedValue, this.title, this.youtubeId
        ).subscribe(data => {
            this.router.navigate([`/videos/${this.youtubeId}`]);
        },
            error => this.errorMsg = error);
    }

    onKey(event: any) {
        this.input = event.target.value;

        this.findYouTubeId();

        if (this.youtubeId) {

            this._youTubeService.getArtistAndTitle(this.youtubeId).
           subscribe(data => {
               this.artist = data.artist;

               this.title = data.title;
               },
               error => this.errorMsg = error);


            this._artistService.getArtists().
            pipe(map(arr => arr.map(el => el.name)),)
                .subscribe(
                    data => {
                        this.artists = data;
                        this.artists.push(this.artist);
                        this.artists.sort();
                        this.selectedValue = this.artist;
                    },
                    error => this.errorMsg = error);


            this.select2Options = {
                placeholder: 'Select an artist or type a new one',
                tags: true
            };


            this.playerOptions = {
                videoId: this.youtubeId,
                height: 'auto',
                width: 'auto',
            };
        }
    }

    public changed(e: any): void {
        this.selectedValue = e.value;
    }

    private findYouTubeId(): string {

        let check = "?v=";
        let check_mobile = "youtu.be/";

        if (this.input.indexOf(check) > -1) {

            return this.youtubeId = this.input.substring(this.input.indexOf("?v=") + 3);
        }

        if (this.input.indexOf(check_mobile) > -1) {

            return this.youtubeId = this.input.substring(this.input.indexOf("youtu.be/") + 9);
        }

        if (this.input.length === 11) {

            return this.youtubeId = this.input;
        }

        return this.youtubeId = '';
    }
}
