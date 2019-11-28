import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Subscriber } from '../subscribers/subscribers.component';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import _ from 'lodash';
import { MatSelectChange } from '@angular/material';

export interface FieldType {
  id: number;
  type: string;
  title: string;
}

export interface SubscriberField {
  id: number;
  title: string;
  type: number;
  data: string;
}

@Component({
  selector: 'app-create-subscriber-dialog',
  templateUrl: './create-subscriber-dialog.component.html',
  styleUrls: ['./create-subscriber-dialog.component.scss']
})
export class CreateSubscriberDialogComponent {

  fieldTypes: FieldType[] = [];
  formGroup: FormGroup;
  formControls = {};

  constructor(
    public dialogRef: MatDialogRef<CreateSubscriberDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: Subscriber,
    private formBuilder: FormBuilder,
    private http: HttpClient
  ) {
    this.http.get('/api/field-types')
      .subscribe((fieldTypes: Array<FieldType>) => this.fieldTypes = fieldTypes);

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

    _.forEach(data.fields, (field) => {
      this.addFieldToFormGroup(field);
    });
  }

  addFieldToFormGroup(field) {
    const formControlName = this.getFormControlName(field.title);
    const validators = [
      // Validators.required
    ];

    if (field.pattern) {
      validators.push(Validators.pattern(field.pattern));
    }

    this.formGroup.addControl(
      formControlName,
      new FormControl(field.data, validators)
    );
  }

  onNoClick(): void {
    this.dialogRef.close();
    if (!_.get(this, 'data.id')) {
      this.formGroup.reset();
    }
  }

  addFieldType(event: MatSelectChange): void {
    console.log('addFieldType', event);

    const fieldTypeId = event.value;
    const fields = this.data.fields;

    const newField = {
      id: 100,
      title: 'test',
      type: 1,
      data: ''
    };
    fields.push(newField);

    this.addFieldToFormGroup(newField);
    this.data.fields = fields;
  }

  getFormControlName(name) {
    return _.snakeCase(name);
  }

}
