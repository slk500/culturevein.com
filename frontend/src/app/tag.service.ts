import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {Itag} from "./tag";
import { throwError as obervableThrowError, Observable } from 'rxjs';
import { catchError } from 'rxjs/operators';
import {INewtTag} from "./tag_new";
import {ITopTag} from "./tag_top";
import {ITagShow} from "./tag_show";
import {ITagVideo} from "../tag_video";


@Injectable({
  providedIn: 'root'
})
export class TagService {

  constructor(private http: HttpClient ) { }

  getTags() : Observable<Itag[]> {
    return this.http.get<Itag[]>('http://localhost:8000/api/tags')
        .pipe(catchError(this.errorHandler))

  }

  getTag(tagSlug) : Observable<ITagShow[]> {
        return this.http.get<ITagShow[]>('http://localhost:8000/api/tags/' + tagSlug)
            .pipe(catchError(this.errorHandler))
    }

  getTagsNew() : Observable<INewtTag[]> {
        return this.http.get<INewtTag[]>('http://localhost:8000/api/tags-new')
            .pipe(catchError(this.errorHandler))

    }

   getTagsTop() : Observable<ITopTag[]> {
        return this.http.get<ITopTag[]>('http://localhost:8000/api/tags-top')
            .pipe(catchError(this.errorHandler))

    }

    getTagsForVideo(youtubeId) : Observable<ITagVideo[]> {
        return this.http.get<ITagVideo[]>('http://localhost:8000/api/tags?youtubeid=' + youtubeId)
            .pipe(catchError(this.errorHandler))

    }

  errorHandler(error : HttpErrorResponse) {
    return obervableThrowError(error.message || 'Server Error')
  }
}
