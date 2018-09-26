import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app';

    characters = [
        {
            id: 1,
            name: 'First item'
        },
        {
            id: 2,
            name: 'Second item'
        },
        {
            id: 3,
            name: 'Third item'
        }
    ]


}

