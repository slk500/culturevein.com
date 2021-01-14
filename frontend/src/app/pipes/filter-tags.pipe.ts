import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
  name: 'filterTags'
})
export class FilterTagsPipe implements PipeTransform {

  transform(tags: any[], searchText: string): any[] {
    if (!tags) {
      return [];
    }
    if (!searchText) {
      return tags;
    }

    return tags
      .filter(tag => this.search(tag, searchText.toLowerCase()))
  }

  private search(tag, search) {

    if (tag.tag_name.toLowerCase().includes(search)) {
      return true;
    }

    if (tag.children.length > 0) {
      return tag.children.some((child) => this.search(child, search));
    }

    return false;
  }
}


