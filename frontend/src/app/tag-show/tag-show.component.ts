import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {TagService} from "../services/tag.service";
import {AuthService} from "../auth.service";
import {SubscribeService} from "../services/subscribe.service";

@Component({
  selector: 'app-tag-show',
  templateUrl: './tag-show.component.html',
  styleUrls: ['./tag-show.component.css']
})
export class TagShowComponent implements OnInit {

  public tagSlug;

  public tag;

  public errorMsg;

  public descendents = [];

  public ancestors = [];

  public isTagSubscribedByUser = false;

  constructor(private route: ActivatedRoute, private router: Router,
              private _tagService: TagService, public _authService: AuthService,
              private _subscribeService: SubscribeService) {
      this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }

  ngOnInit() {

    this.route.paramMap.subscribe((params : ParamMap) => {
        this.tagSlug = params.get('slug');
    });

      this._tagService.getTag(this.tagSlug)
          .subscribe(data => this.tag = data.data,
              error => this.errorMsg = error);

      this._tagService.getDescendents(this.tagSlug)
          .subscribe(data => this.descendents = data.data,
              error => this.errorMsg = error);

      this._tagService.getAncestors(this.tagSlug)
          .subscribe(data => this.ancestors = data.data,
              error => this.errorMsg = error);

      if(this._authService.loggedIn()){
          this._subscribeService.isTagSubscribedByUser(this.tagSlug)
              .subscribe(data => this.isTagSubscribedByUser = data.data,
                  error => this.errorMsg = error);
      }
  }

  public subscribe(tagId: string){
      this._subscribeService.subscribe(this.tagSlug)
          .subscribe(data => {
            this.isTagSubscribedByUser = true;
            this.tag.subscribers += 1;
              },
              error => this.errorMsg = error);
  }

  public unsubscribe(tagId: string){
    this._subscribeService.unsubscribe(this.tagSlug)
        .subscribe(data => {
              this.isTagSubscribedByUser = false;
              this.tag.subscribers -= 1;
            },
            error => this.errorMsg = error);
  }

}
