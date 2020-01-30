import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
    name: 'filter'
})
export class FilterPipe implements PipeTransform {

    transform(items: any[], searchText: string): any[] {
        if (!items) return [];
        if (!searchText) return items;
        searchText = searchText.toLowerCase();

        function filter(items, searchText) {
            let result = [];

            items.forEach(function (item) {
                if (item.name.toLowerCase().includes(searchText)) result.push(item);
                if (filter(item.children, searchText).length) result.push(item);
            });

            return result;
        }

        return filter(items, searchText)
    }
}


