import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {Ivideo} from "../interfaces/video";
import { throwError as obervableThrowError, Observable } from 'rxjs';
import { catchError } from 'rxjs/operators';
import {IVideoTagTop} from "../interfaces/video_tag_top";
import {IVideoNew} from "../interfaces/video_new";


@Injectable({
    providedIn: 'root'
})
export class VideoService {

    constructor(private http: HttpClient ) { }

    addVideo(artist, name, youtube_id, duration) {
        return this.http.post('api/videos', {
            artist: artist,
            name: name,
            youtube_id: youtube_id,
            duration: duration
        })
    }

    getVideos() : Observable<Ivideo[]> {
        return this.http.get<any>('api/videos')
            .pipe(catchError(this.errorHandler))

    }

    getVideo(youtubeId) : Observable<Ivideo[]> {
        return this.http.get<Ivideo[]>('api/videos/' + youtubeId)
            .pipe(catchError(this.errorHandler))
    }

    getVideosTopTag() : Observable<IVideoTagTop[]> {
        return this.http.get<IVideoTagTop[]>('api/videos-tags-top')
            .pipe(catchError(this.errorHandler))

    }

    getVideosLastAdded() : Observable<IVideoNew[]> {
        return this.http.get<IVideoNew[]>('api/videos-new')
            .pipe(catchError(this.errorHandler))

    }

    errorHandler(error : HttpErrorResponse) {
        return obervableThrowError(error.message || 'Server Error')
    }
}
