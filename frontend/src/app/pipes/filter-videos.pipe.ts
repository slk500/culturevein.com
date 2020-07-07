import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
    name: 'filterVideos',
    pure: false
})
export class FilterVideosPipe implements PipeTransform {

  transform(artists: any[], searchText: string): any[] {
    if (!artists) {
      return [];
    }
    if (!searchText) {
      return artists;
    }
    return artists
      .map(artist => this.matchArtistVideos(artist, searchText.toLowerCase()))
      .filter(resultArtist => resultArtist.videos.length > 0);
  }

  private matchArtistVideos(artist: any, lowerCasedSearchText: string) {
    if (artist.name.toLowerCase().includes(lowerCasedSearchText)) {
      return artist;
    }
    return {
      ...artist,
      videos: artist.videos.filter(video => video.name.toLowerCase().includes(lowerCasedSearchText)),
    }
  }

}


