import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {Observable, throwError as obervableThrowError} from "rxjs";
import {catchError} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class SubscribeService {

  constructor(private http: HttpClient) {
  }

  isTagSubscribedByUser(tagId: string): Observable<any> {
    return this.http.get<any>('api/subscribe/tags/' + tagId)
        .pipe(catchError(this.errorHandler))
  }

  subscribe(tagId: string){
    return this.http.post('api/subscribe/tags/' + tagId,{})
        .pipe(catchError(this.errorHandler))
  }

  unsubscribe(tagId: string){
    return this.http.delete('api/subscribe/tags/' + tagId, {})
        .pipe(catchError(this.errorHandler))
  }




  errorHandler(error: HttpErrorResponse) {
    return obervableThrowError(error.message || 'Server Error')
  }
}
