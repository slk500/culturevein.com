import { Component, OnInit } from '@angular/core';
import {StatisticsService} from "../services/statistics.service";
import {TagService} from "../services/tag.service";

@Component({
  selector: 'app-activity',
  templateUrl: './activity.component.html',
  styleUrls: ['./activity.component.css']
})
export class ActivityComponent implements OnInit {

  public users = [];
  public videoTags = [];
  public errorMsg;

  constructor(private _statisticsService: StatisticsService, private _tagService: TagService) { }

  ngOnInit() {
    this._statisticsService.getUsers()
        .subscribe(data => this.users = data,
            error => this.errorMsg = error);

    this._tagService.getVideoTags()
        .subscribe(data => this.videoTags = data,
            error => this.errorMsg = error);
  }

}
