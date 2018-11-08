import {Injectable} from '@angular/core';
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {Itag} from "../interfaces/tag";
import {throwError as obervableThrowError, Observable} from 'rxjs';
import {catchError} from 'rxjs/operators';
import {INewtTag} from "../interfaces/tag_new";
import {ITagTop} from "../interfaces/tag_top";
import {ITagShow} from "../interfaces/tag_show";
import {IVideoTag} from "../interfaces/video_tag";


@Injectable({
    providedIn: 'root'
})
export class TagService {

    constructor(private http: HttpClient) {
    }

    getTags(): Observable<Itag[]> {
        return this.http.get<Itag[]>('api/tags')
            .pipe(catchError(this.errorHandler))

    }

    getTag(tagSlug): Observable<ITagShow[]> {
        return this.http.get<ITagShow[]>('api/tags/' + tagSlug)
            .pipe(catchError(this.errorHandler))
    }

    getTagsNew(): Observable<INewtTag[]> {
        return this.http.get<INewtTag[]>('api/tags-new')
            .pipe(catchError(this.errorHandler))

    }

    getTagsTop(): Observable<ITagTop[]> {
        return this.http.get<ITagTop[]>('api/tags-top')
            .pipe(catchError(this.errorHandler))

    }

    getVideoTags(youtubeId): Observable<IVideoTag[]> {
        return this.http.get<IVideoTag[]>('api/videos/' + youtubeId + '/tags')
            .pipe(catchError(this.errorHandler))

    }

    addVideoTag(videoId, start, stop, name) {

       return this.http.post<IVideoTag>('api/tags', {
            video_id: videoId,
            name: name,
            start: start,
            stop: stop
        })
    }

    deleteVideoTag(youtubeId: string, videoTagId: number): Observable<Itag> {
        return this.http.get<Itag>('api/videos/' + youtubeId + '/tags/' + videoTagId)
            .pipe(catchError(this.errorHandler))
    }


    errorHandler(error: HttpErrorResponse) {
        return obervableThrowError(error.message || 'Server Error')
    }
}
