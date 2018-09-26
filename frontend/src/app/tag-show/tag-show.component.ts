import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {TagService} from "../tag.service";

@Component({
  selector: 'app-tag-show',
  templateUrl: './tag-show.component.html',
  styleUrls: ['./tag-show.component.css']
})
export class TagShowComponent implements OnInit {

  public tagSlug;

  public tag;

  public errorMsg;

  constructor(private route: ActivatedRoute, private router: Router, private _tagService: TagService) { }

  ngOnInit() {
    this.route.paramMap.subscribe((params : ParamMap) => {
        this.tagSlug = params.get('slug');
    });
      this._tagService.getTag(this.tagSlug)
          .subscribe(data => this.tag = data,
              error => this.errorMsg = error);
  }


}
