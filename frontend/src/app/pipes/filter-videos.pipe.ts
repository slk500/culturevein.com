import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
    name: 'filterVideos',
    pure: false
})
export class FilterVideosPipe implements PipeTransform {

    transform(artists: any[], searchText: string): any[] {
        if (!artists) return [];
        if (!searchText) return artists;
        const searchTextLowerCase = searchText.toLowerCase();

        let result = [];

            artists.forEach(function (artist) {
                if (artist.name.toLowerCase().includes(searchTextLowerCase)) {
                  result.push(artist);
                } else {
                 artist.videos = artist.videos.filter(function (video) {
                    return video.name.toLowerCase().includes(searchTextLowerCase);
                  });
                  if(artist.videos.length > 0 ) result.push(artist);
                }
            });

            return result;
    }
}


