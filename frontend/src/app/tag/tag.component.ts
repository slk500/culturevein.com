import {Component, Input, OnInit} from '@angular/core';
import {TagService} from "../tag.service";


@Component({
  selector: 'app-tag',
  templateUrl: './tag.component.html',
  styleUrls: ['./tag.component.css']
})
export class TagComponent implements OnInit {

  @Input() searchText: any;

  public tags = [];
  public errorMsg;

  constructor(private _tagService: TagService) {}

  ngOnInit() {
    this._tagService.getTags()
        .subscribe(data => this.tags = data,
            error => this.errorMsg = error)
  }

    transform(searchText: string): any[] {
        if(!this.tags) return [];
        if(!searchText) return this.tags;
        searchText = searchText.toLowerCase();
        return this.tags.filter( it => {
            return it.name.toLowerCase().includes(searchText);
        });
    }
}
