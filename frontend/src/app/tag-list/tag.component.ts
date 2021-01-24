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
  public tagsSortedByName = [];
  public errorMsg;
  public searchText;
  public isRelations: boolean = true;
  public isNumberOfVideos: boolean = false;
  public isSortByNumberOfVideos: boolean = false;

  constructor(public _tagService: TagService, private inputSearch: InputService, private seoService: SeoService) {
  }

  ngOnInit() {
    this.seoService.setTitle('Tags in music videos | CultureVein');
    this.seoService.setMetaDescription('Music videos with Arnold Schwarzenegger,Brad Pitt,Charlie Sheen,John Deep,Keanu Reeves, Leonardo DiCaprio,Pamela Anderson,Robin Williams,Sylvester Stallone')
    this._tagService.getTags()
      .subscribe(data => {
          this.tags = data;
        },
        error => this.errorMsg = error);
    this.inputSearch.cast.subscribe(input => this.searchText = input);
  }

  flatten(data) {
    const result = [];
    recursive(data);
    return result;

    function recursive(data) {
      data.forEach(member => {
        result.push
        (
          {
            'tag_name': member.tag_name,
            'tag_slug_id': member.tag_slug_id,
            'count': member.count,
            'children': []
          }
        );
        recursive(member.children);
      });
    }
  }

  getTags() {
    this._tagService.getTags()
      .subscribe(data => {
          this.tags = (this.isRelations == true) ?
            data :
            this.flatten(data)
              .sort((a, b) => a.tag_name.localeCompare(b.tag_name));
        },
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
    if (!query) {
      return content;
    }
    return content.replace(new RegExp(query, "gi"), match => {
      return '<span class="highlight">' + match + '</span>';
    });
  }

  sortNodesAndChildren(nodes) {
    nodes.sort((a, b) => b.count - a.count)
    nodes.forEach(function (node) {
      if (node.children.length > 0) {
        this.sortNodesAndChildren(node.children);
      }
    }, this);

    return nodes;
  }

  sortByNumberOfVideos() {
    if (this.isSortByNumberOfVideos == true) {
        this.tags = this.sortNodesAndChildren(this.tags);
    } else {
      this.getTags();
    }
  }
}
