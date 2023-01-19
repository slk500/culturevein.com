import {Injectable} from '@angular/core';
import {Meta, Title} from "@angular/platform-browser";

@Injectable({
  providedIn: 'root'
})
export class SeoService {

  constructor(private titleService: Title,
              private metaService: Meta
  ) {

  }

  public setTitle(title: string) {
    this.titleService.setTitle(title);
  }

  public getTitle() {
    return this.titleService.getTitle();
  }

  public setMetaDescription(content: string) {
    this.metaService.updateTag(
      {name: 'description', content: content}
    );
  }

  public setMetaRobotsNoIndexNoFollow() {
    this.metaService.updateTag(
      {name: 'robots', content: 'noindex,nofollow'}
    );
  }

}
