import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {Itag} from "../interfaces/tag";
import { throwError as obervableThrowError, Observable } from 'rxjs';
import { catchError } from 'rxjs/operators';
import {INewtTag} from "../interfaces/tag_new";
import {ITopTag} from "../interfaces/tag_top";
import {ITagShow} from "../interfaces/tag_show";
import {ITagVideo} from "../../tag_video";


@Injectable({
  providedIn: 'root'
})
export class TagService {

  constructor(private http: HttpClient ) { }

  getTags() : Observable<Itag[]> {
    return this.http.get<Itag[]>('api/tags')
        .pipe(catchError(this.errorHandler))

  }

  getTag(tagSlug) : Observable<ITagShow[]> {
        return this.http.get<ITagShow[]>('api/tags/' + tagSlug)
            .pipe(catchError(this.errorHandler))
    }

  getTagsNew() : Observable<INewtTag[]> {
        return this.http.get<INewtTag[]>('api/tags-new')
            .pipe(catchError(this.errorHandler))

    }

   getTagsTop() : Observable<ITopTag[]> {
        return this.http.get<ITopTag[]>('api/tags-top')
            .pipe(catchError(this.errorHandler))

    }

    getTagsForVideo(youtubeId) : Observable<ITagVideo[]> {
        return this.http.get<ITagVideo[]>('api/tags?youtubeid=' + youtubeId)
            .pipe(catchError(this.errorHandler))

    }

    addTagToVideo()
    {
        this.http.post('api/tags', {
            video_id : 3799,
            name : 'chess',
            start : 0,
            stop : 25
        }).subscribe((data:any) => {console.log(data)})
    }

  errorHandler(error : HttpErrorResponse) {
    return obervableThrowError(error.message || 'Server Error')
  }
}
