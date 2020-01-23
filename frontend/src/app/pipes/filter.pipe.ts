import { Pipe, PipeTransform } from '@angular/core';
@Pipe({
    name: 'filter'
})
export class FilterPipe implements PipeTransform {
    transform(items: any[], searchText: string, fieldName: string): any[] {
        if(!items) return [];
        if(!searchText) return items;
        searchText = searchText.toLowerCase();

      return items.filter( item => {
        return item[fieldName].toLowerCase().includes(searchText)
          || items[fieldName]['childrens'].filter( item => {
            return item[fieldName].toLowerCase().includes(searchText)
          })
      });
    }
}
