import {Component, OnInit} from '@angular/core';

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

    constructor() {
    }

    ngOnInit() {

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
