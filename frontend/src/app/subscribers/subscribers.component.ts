import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';


export interface Subscriber {
  id: number;
  email_address: string;
  first_name: string;
  last_name: string;
  state: number;
}

@Component({
  selector: 'app-subscribers',
  templateUrl: './subscribers.component.html',
  styleUrls: ['./subscribers.component.scss']
})
export class SubscribersComponent {

  subscribers: Subscriber[];
  displayedColumns: string[] = [
    'email_address',
    'first_name',
    'last_name',
    'state',
    'actions'
  ];

  constructor(
    private http: HttpClient
  ) {
    this.http.get('/api/subscribers')
      .subscribe((subscribers: Array<Subscriber>) => this.subscribers = subscribers);
  }
}
