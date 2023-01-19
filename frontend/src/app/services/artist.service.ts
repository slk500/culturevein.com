import {Injectable} from "@angular/core";
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {Observable, throwError as obervableThrowError} from "rxjs";
import {catchError} from "rxjs/operators";

@Injectable({
    providedIn: 'root'
})
export class ArtistService {

    constructor(private http: HttpClient) {
    }

    getArtist(tagSlug: string): Observable<any> {
        return this.http.get<any>('api/artists/' + tagSlug)
            .pipe(catchError(this.errorHandler))
    }

    errorHandler(error: HttpErrorResponse) {
        return obervableThrowError(error.message || 'Server Error')
    }
}
