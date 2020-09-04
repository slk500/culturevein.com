import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, ParamMap, Router} from "@angular/router";
import {AuthService} from "../auth.service";
import {SubscribeService} from "../services/subscribe.service";
import {ArtistService} from "../services/artist.service";

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
              private _artistService: ArtistService, public _authService: AuthService,
              private _subscribeService: SubscribeService) {
      this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  }

  ngOnInit() {

    this.route.paramMap.subscribe((params : ParamMap) => {
        this.artistSlug = params.get('slug');
    });

      this._artistService.getArtist(this.artistSlug)
        .subscribe(data => this.artist = data,
          error => this.errorMsg = error);
  }
}
