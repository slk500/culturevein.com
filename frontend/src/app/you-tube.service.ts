import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {catchError} from "rxjs/operators";
import {Observable, throwError as obervableThrowError} from "rxjs/index";

interface IArtistAndTitle {
  artist: string,
  title: string
}

@Injectable({
  providedIn: 'root'
})
export class YouTubeService {

    constructor(private http: HttpClient ) { }

    getArtistAndTitle(youtubeId) : Observable<IArtistAndTitle> {
        return this.http.get<IArtistAndTitle>('api/youtube/' + youtubeId)
            .pipe(catchError(this.errorHandler))

    }

    errorHandler(error : HttpErrorResponse) {
        return obervableThrowError(error.message || 'Server Error')
    }
}
