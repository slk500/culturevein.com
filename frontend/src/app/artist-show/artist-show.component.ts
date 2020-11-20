import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {SubscribeService} from "../services/subscribe.service";
import {ArtistService} from "../services/artist.service";
import {SeoService} from "../seo.service";

@Component({
  selector: 'app-artist-show',
  templateUrl: './artist-show.component.html',
  styleUrls: ['./artist-show.component.css']
})
export class ArtistShowComponent implements OnInit {

  public artistSlug;

  public artist;

  public errorMsg;

  constructor(private route: ActivatedRoute, private router: Router,
              private _artistService: ArtistService, private seoService: SeoService,
              private _subscribeService: SubscribeService) {
      this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }

  ngOnInit() {
    this.route.paramMap.subscribe((params : ParamMap) => {
        this.artistSlug = params.get('slug');
    });

      this._artistService.getArtist(this.artistSlug)
        .subscribe(data => {
          this.artist = data;
            this.seoService.setTitle(data.name + ' music videos');
            this.seoService.setMetaDescription(
              data.name + ' music videos tags: '+ data.tags.map(str => str.name).join());
          },
          error => this.errorMsg = error);
  }
}
