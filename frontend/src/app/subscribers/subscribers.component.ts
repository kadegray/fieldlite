import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { CreateSubscriberDialogComponent, SubscriberField } from '../create-subscriber-dialog/create-subscriber-dialog.component';
import _ from 'lodash';

export interface Subscriber {
  id?: number;
  email_address: string;
  first_name: string;
  last_name: string;
  state: number;
  fields: Array<SubscriberField>;
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
    state: 1,
    fields: []
  };
  displayedColumns: string[] = [
    'email_address',
    'first_name',
    'last_name',
    'state',
    'actions'
  ];

  stateNames: string[] = [
    'Active',
    'Unsubscribed',
    'Junk',
    'Bounced',
    'Unconfirmed'
  ];

  constructor(
    private http: HttpClient,
    public dialog: MatDialog
  ) {
    this.http.get('/api/subscribers')
      .subscribe((subscribers: Array<Subscriber>) => this.subscribers = subscribers);
  }

  openSubscriberDialog(subscriberData: any): void {

    const requestMethod = !!subscriberData ? 'put' : 'post';
    subscriberData = requestMethod === 'post' ? this.newSubscriber : subscriberData;
    const endpoint = requestMethod === 'post' ? '/api/subscriber' : '/api/subscriber/' + subscriberData.id;

    const dialogRef = this.dialog.open(CreateSubscriberDialogComponent, {
      width: '420px',
      data: subscriberData
    });

    dialogRef.afterClosed().subscribe((buttonClicked) => {

      if (buttonClicked === 'cancel') {
        return;
      }

      this.http[requestMethod](endpoint, subscriberData)
        .subscribe((subscriber: Subscriber) => {

          const subscriberId = _.get(subscriber, 'id');
          const subscribers: Array<any> = _.clone(this.subscribers);

          let existingSubscriber = _.find(subscribers, (s) => {
            return s.id === subscriberId;
          });
          if (existingSubscriber) {
            existingSubscriber = subscriber;
            this.subscribers = subscribers;

            return;
          }

          subscribers.push(subscriber);
          this.subscribers = subscribers;
        });
    });
  }

  getStateFromSubscriberData(subscriberData: any): string {

    const stateId = subscriberData.state;

    return _.get(this.stateNames, stateId - 1);
  }
}
