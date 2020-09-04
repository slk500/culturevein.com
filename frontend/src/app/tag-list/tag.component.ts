import {Component, Input, OnInit} from '@angular/core';
import {TagService} from "../services/tag.service";
import {InputService} from "../services/input.service";


@Component({
  selector: 'app-tag',
  templateUrl: './tag.component.html',
  styleUrls: ['./tag.component.css']
})
export class TagComponent implements OnInit {

  public tags = [];
  public errorMsg;
  public searchText;

  constructor(private _tagService: TagService, private inputSearch: InputService) {}

  ngOnInit() {
    this._tagService.getTags()
        .subscribe(data => this.tags = data,
            error => this.errorMsg = error);
      this.inputSearch.cast.subscribe(input => this.searchText = input);
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
