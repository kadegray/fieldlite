import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { CreateSubscriberDialogComponent } from '../create-subscriber-dialog/create-subscriber-dialog.component';

export interface Subscriber {
  id?: number;
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
  newSubscriber: Subscriber = {
    first_name: '',
    last_name: '',
    email_address: '',
    state: 1
  };
  displayedColumns: string[] = [
    'email_address',
    'first_name',
    'last_name',
    'state',
    'actions'
  ];

  constructor(
    private http: HttpClient,
    public dialog: MatDialog
  ) {
    this.http.get('/api/subscribers')
      .subscribe((subscribers: Array<Subscriber>) => this.subscribers = subscribers);
  }

  openCreateSubscriberDialog(subscriberData: any): void {

    const requestMethod = !!subscriberData ? 'put' : 'post';
    subscriberData = requestMethod === 'post' ? this.newSubscriber : subscriberData;
    const endpoint = requestMethod === 'post' ? '/api/subscriber' : '/api/subscriber/' + subscriberData.id;

    const dialogRef = this.dialog.open(CreateSubscriberDialogComponent, {
      width: '420px',
      data: subscriberData
    });

    dialogRef.afterClosed().subscribe(() => {
      this.http[requestMethod](endpoint, subscriberData)
        .subscribe((subscriber: Subscriber) => {
          this.subscribers.push(subscriber);
        });
    });
  }
}