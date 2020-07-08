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
      .map(tag => this.matchChildren(tag, searchText.toLowerCase()))
      .filter(resultTag => resultTag.children.length > 0);
  }

  private matchChildren(tag: any, lowerCasedSearchText: string) {
    if (tag.name.toLowerCase().includes(lowerCasedSearchText)) {
      return tag;
    }
    return {
      ...tag,
      children: tag.children.filter(tag => tag.name.toLowerCase().includes(lowerCasedSearchText)),
    }
  }
}


