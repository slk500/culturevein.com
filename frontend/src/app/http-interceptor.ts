import {Injectable, Injector} from '@angular/core';
import {HttpEvent, HttpInterceptor, HttpHandler, HttpRequest} from '@angular/common/http';
import {Observable} from 'rxjs';
import { environment } from '../environments/environment';
import {AuthService} from "./auth.service";

@Injectable()
export class APIInterceptor  implements HttpInterceptor {

    constructor(private injector: Injector) {}

    baseUrl = environment.baseUrl;

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

        let authService = this.injector.get(AuthService);

        const apiReq = req.clone({
            url: this.baseUrl + req.url,
            setHeaders: {
                Authorization: `Bearer ${authService.getToken()}`
            }
        });
        return next.handle(apiReq);
    }
}
