import {Component, Input, OnInit} from '@angular/core';
import {TagService} from "../services/tag.service";
import {InputService} from "../services/input.service";
import {SeoService} from "../seo.service";


@Component({
  selector: 'app-tag',
  templateUrl: './tag.component.html',
  styleUrls: ['./tag.component.css']
})
export class TagComponent implements OnInit {

  public tags = [];
  public errorMsg;
  public searchText;
  public isRelations : boolean = true;
  public isNumberOfVideos : boolean = false;

  constructor(public _tagService: TagService, private inputSearch: InputService, private seoService: SeoService) {}

  ngOnInit() {
    this.seoService.setTitle('Tags in music videos | CultureVein');
    this.seoService.setMetaDescription('Music videos with Arnold Schwarzenegger,Brad Pitt,Charlie Sheen,John Deep,Keanu Reeves, Leonardo DiCaprio,Pamela Anderson,Robin Williams,Sylvester Stallone')
    this._tagService.getTags()
        .subscribe(data => {this.tags = data;},
            error => this.errorMsg = error);
      this.inputSearch.cast.subscribe(input => this.searchText = input);
  }

  getTags() {

    if(!this.isRelations) this.findAllByNumberOfVideos()
    else {
      this._tagService.getTags()
        .subscribe(data => {
            this.tags = data;
          },
          error => this.errorMsg = error);
      }
    }

  findAllByNumberOfVideos() {
    this._tagService.findAllOrderByNumberOfVideos()
        .subscribe(data => {this.tags = data;},
            error => this.errorMsg = error);
  }

  getTagsCount(tags) {
    return tags
      .map(tag => this.getTagCount(tag))
      .reduce((a, b) => a + b, 0)
  }

  getTagCount(tag) {
    return tag.children
      .map(tag => this.getTagCount(tag))
      .reduce((a, b) => a + b, 1)
  }

  highlight(query, content) {
    if(!query) {
      return content;
    }
    return content.replace(new RegExp(query, "gi"), match => {
      return '<span class="highlight">' + match + '</span>';
    });
  }
}
