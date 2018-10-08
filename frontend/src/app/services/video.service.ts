import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {Ivideo} from "../interfaces/video";
import { throwError as obervableThrowError, Observable } from 'rxjs';
import { catchError } from 'rxjs/operators';
import {IVideoTopTag} from "../interfaces/video_top_tag";
import {IVideoLastAdded} from "../interfaces/video_last_added";
import {ITagShow} from "../interfaces/tag_show";


@Injectable({
    providedIn: 'root'
})
export class VideoService {

    constructor(private http: HttpClient ) { }

    getVideos() : Observable<Ivideo[]> {
        return this.http.get<Ivideo[]>('api/videos')
            .pipe(catchError(this.errorHandler))

    }

    getVideo(youtubeId) : Observable<Ivideo> {
        return this.http.get<Ivideo>('api/videos/' + youtubeId)
            .pipe(catchError(this.errorHandler))
    }

    getVideosTopTag() : Observable<IVideoTopTag[]> {
        return this.http.get<IVideoTopTag[]>('api/videos-top-tags')
            .pipe(catchError(this.errorHandler))

    }

    getVideosLastAdded() : Observable<IVideoLastAdded[]> {
        return this.http.get<IVideoLastAdded[]>('api/videos-last-added')
            .pipe(catchError(this.errorHandler))

    }

    errorHandler(error : HttpErrorResponse) {
        return obervableThrowError(error.message || 'Server Error')
    }


}