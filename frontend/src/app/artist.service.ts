import { Injectable } from '@angular/core';
import {catchError} from "rxjs/operators";
import {IVideoNew} from "./interfaces/video_new";
import {Observable, throwError as obervableThrowError} from "rxjs/index";
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {IArtist} from "./interfaces/artist";

@Injectable({
  providedIn: 'root'
})
export class ArtistService {

    constructor(private http: HttpClient ) { }

    getArtists() : Observable<IArtist[]> {
        return this.http.get<IArtist[]>('api/artists')
            .pipe(catchError(this.errorHandler))

    }

    errorHandler(error : HttpErrorResponse) {
        return obervableThrowError(error.message || 'Server Error')
    }
}
