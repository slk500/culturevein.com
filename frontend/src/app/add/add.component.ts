import {Component, OnInit} from '@angular/core';
import {VideoService} from "../services/video.service";
import {ArtistService} from "../artist.service";

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

    public errorMsg;

    constructor(private _artistService: ArtistService) {
    }

    ngOnInit() {
        this._artistService.getArtists()
            .subscribe(data => this.artists = data,
                error => this.errorMsg = error);
    }

    onKey(event: any) {
        this.input = event.target.value;

        this.findYouTubeId();

        if (this.youtubeId) {
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

    private findYouTubeId() {

        let check = "?v=";
        let check_mobile = "youtu.be/";

        if ((this.input.indexOf(check) > -1)) {

            return this.youtubeId = this.input.substring(this.input.indexOf("?v=") + 3);
        }

        if ((this.input.indexOf(check_mobile) > -1)) {

            return this.youtubeId = this.input.substring(this.input.indexOf("youtu.be/") + 9);
        }

        if (this.input.length === 11) {

            return this.youtubeId = this.input;
        }

        return this.youtubeId = '';
    }
}
