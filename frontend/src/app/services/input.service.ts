import {Injectable} from '@angular/core';
import {BehaviorSubject} from 'rxjs';

@Injectable()
export class InputService {

    private input = new BehaviorSubject<string>('');
    public cast = this.input.asObservable();

    constructor() {
    }

    search(input) {
        this.input.next(input);
    }

}