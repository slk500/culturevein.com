import {Injectable} from '@angular/core';
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import {Itag} from "../interfaces/tag";
import {throwError as obervableThrowError, Observable} from 'rxjs';
import {catchError} from 'rxjs/operators';
import {INewtTag} from "../interfaces/tag_new";
import {ITagTop} from "../interfaces/tag_top";
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

  getTagsSimple(): Observable<any> {
    return this.http.get<any>('api/tags-simple')
      .pipe(catchError(this.errorHandler))
  }


  getTag(tagSlug): Observable<any> {
    return this.http.get<any>('api/tags/' + tagSlug)
      .pipe(catchError(this.errorHandler))
  }

  getDescendants(tagSlug): Observable<any> {
    return this.http.get<any>('api/tags/' + tagSlug + '/descendants')
      .pipe(catchError(this.errorHandler))
  }

  getAncestors(tagSlug): Observable<any> {
    return this.http.get<any>('api/tags/' + tagSlug + '/ancestors')
      .pipe(catchError(this.errorHandler))
  }

  getTagsNew(): Observable<INewtTag[]> {
    return this.http.get<INewtTag[]>('api/tags-new')
      .pipe(catchError(this.errorHandler))
  }

  findAllOrderByNumberOfVideos(): Observable<ITagTop[]> {
    return this.http.get<ITagTop[]>('api/tags-top')
      .pipe(catchError(this.errorHandler))
  }

  getVideoTags(): Observable<any[]> {
    return this.http.get<any[]>('api/videos-tags')
      .pipe(catchError(this.errorHandler))
  }

  getVideoTagsForVideo(youtubeId): Observable<IVideoTag[]> {
    return this.http.get<IVideoTag[]>('api/videos/' + youtubeId + '/tags')
      .pipe(catchError(this.errorHandler))
  }

  getVideoTagsHistoryForVideo(youtubeId): Observable<any[]> {
    return this.http.get<any[]>('api/videos/' + youtubeId + '/tags-history')
      .pipe(catchError(this.errorHandler));
  }

  addVideoTag(youtubeId, name) {
    return this.http.post<IVideoTag>('api/videos/' + youtubeId + '/tags', {
      tag_name: name,
    })
  }

  addVideoTagTime(youtubeId: string, tagSlugId: string, start: number, stop: number) {
    return this.http.post<any>('api/videos/' + youtubeId + '/tags/' + tagSlugId, {
      start: start,
      stop: stop
    })
  }

  setCompleted(youtubeId: string, tagSlugId: string) {
    return this.http.patch<any>('api/videos/' + youtubeId + '/tags/' + tagSlugId + '/completed' , { });
  }

  setUncompleted(youtubeId: string, tagSlugId: string) {
    return this.http.patch<any>('api/videos/' + youtubeId + '/tags/' + tagSlugId + '/uncompleted' , { });
  }

  deleteVideoTag(youtubeId: string, tagSlugId: string): Observable<Itag> {
    return this.http.delete<Itag>('api/videos/' + youtubeId + '/tags/' + tagSlugId)
      .pipe(catchError(this.errorHandler))
  }

  deleteVideoTagTime(video_youtube_id: string, tag_slug_id: string, video_tag_time_id: number): Observable<Itag> {
    return this.http.delete<any>('api/videos/' + video_youtube_id + '/tags/' + tag_slug_id + '/' + video_tag_time_id)
      .pipe(catchError(this.errorHandler))
  }

  errorHandler(error: HttpErrorResponse) {
    return obervableThrowError(error.message || 'Server Error')
  }
}
