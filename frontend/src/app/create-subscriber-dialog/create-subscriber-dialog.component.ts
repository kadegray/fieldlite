import { Component, OnInit, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Subscriber } from '../subscribers/subscribers.component';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-create-subscriber-dialog',
  templateUrl: './create-subscriber-dialog.component.html',
  styleUrls: ['./create-subscriber-dialog.component.scss']
})
export class CreateSubscriberDialogComponent {

  formGroup: FormGroup;

  constructor(
    public dialogRef: MatDialogRef<CreateSubscriberDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: Subscriber,
    private formBuilder: FormBuilder,
    private http: HttpClient
  ) {
    this.formGroup = this.formBuilder.group({
      email_address: new FormControl(data.email_address, [
        Validators.required,
        Validators.email,
        Validators.maxLength(255)
      ]),
      first_name: new FormControl(data.first_name, [
        Validators.required,
        Validators.maxLength(255)
      ]),
      last_name: new FormControl(data.last_name, [
        Validators.required,
        Validators.maxLength(255)
      ]),
      state: new FormControl(data.state, [
        Validators.required
      ])
    });
  }

  onNoClick(): void {
    this.dialogRef.close();
    this.formGroup.reset();
  }

}
