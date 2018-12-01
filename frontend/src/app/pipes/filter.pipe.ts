import { Pipe, PipeTransform } from '@angular/core';
@Pipe({
    name: 'filter'
})
export class FilterPipe implements PipeTransform {
    transform(items: any[], searchText: string, fieldName1: string, fieldName2: string): any[] {
        if(!items) return [];
        if(!searchText) return items;
        searchText = searchText.toLowerCase();

        if(fieldName2){
            return items.filter( it => {
                return it[fieldName1].toLowerCase().includes(searchText) || it[fieldName2].toLowerCase().includes(searchText)
            });
        }else{
            return items.filter( it => {
                return it[fieldName1].toLowerCase().includes(searchText)
            });
        }

    }
}
