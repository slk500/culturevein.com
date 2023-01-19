import {Component, Input, OnInit} from '@angular/core';
import {TagService} from '../services/tag.service';

@Component({
  selector: 'app-video-tags-history',
  templateUrl: './video-tags-history.component.html',
  styleUrls: ['./video-tags-history.component.css']
})
export class VideoTagsHistoryComponent implements OnInit {

  @Input() youtubeId: string;
  public videoTagsHistory = [];
  public errorMsg;

  constructor(private _tagService: TagService) {
  }

  ngOnInit() {
    this._tagService.getVideoTagsHistoryForVideo(this.youtubeId)
      .subscribe(data => this.videoTagsHistory = data,
        error => this.errorMsg = error);
  }

}
