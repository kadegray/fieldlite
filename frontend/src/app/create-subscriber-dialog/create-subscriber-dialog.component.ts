import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Subscriber } from '../subscribers/subscribers.component';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import _ from 'lodash';
import { MatSelectChange } from '@angular/material';
import { delay } from 'q';
import { Observable, Observer } from 'rxjs';

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
  field_type_id: number;
}

@Component({
  selector: 'app-create-subscriber-dialog',
  templateUrl: './create-subscriber-dialog.component.html',
  styleUrls: ['./create-subscriber-dialog.component.scss']
})
export class CreateSubscriberDialogComponent {

  fieldTypes: Array<FieldType> = [];
  formGroup: FormGroup;
  formControls = {};
  updatingFormGroup: boolean;

  phoneNumber: any;
  country: any;
  postCode: any;
  dateOfBirth: any;
  engagedCustomer: any;

  constructor(
    public dialogRef: MatDialogRef<CreateSubscriberDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: Subscriber,
    private formBuilder: FormBuilder,
    private http: HttpClient
  ) {
    this.http.get('/api/field-types')
      .subscribe((fieldTypes: Array<FieldType>) => {
        this.fieldTypes = fieldTypes;
        this.updateFieldVariables();
      });

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

  updateFieldVariables() {

    _.forEach(this.fieldTypes, (fieldType) => {
      let field = this.subscriberHasFieldOfType(fieldType.id);
      let fieldName = _.camelCase(fieldType.title);
      _.set(this, fieldName, field);
    });
  }

  addFieldToFormGroup(field) {

    this.updatingFormGroup = true;
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
    this.updatingFormGroup = false;

    this.updateFieldVariables();
  }

  cancelButtonClick(): void {
    this.dialogRef.close('cancel');
    if (!_.get(this, 'data.id')) {
      this.formGroup.reset();
    }
  }

  saveButtonClick(): void {
    this.dialogRef.close('save');
  }

  getFieldTypesForSelect() {

    const existingFieldTypes = _.map(this.data.fields, 'field_type_id');

    return _.filter(this.fieldTypes, (fieldType) => {
      return !_.includes(existingFieldTypes, fieldType.id);
    });
  }

  addFieldType(event: MatSelectChange): void {

    const fieldTypeId = event.value;
    let fieldType = _.filter(this.fieldTypes, (fieldType) => {
      return fieldType.id === fieldTypeId;
    });
    fieldType = _.get(fieldType, '0');

    const fields = this.data.fields ? this.data.fields : [];
    const newField = {
      id: null,
      title: fieldType.title,
      type: fieldType.type,
      data: '',
      field_type_id: fieldTypeId
    };
    fields.push(newField);

    this.addFieldToFormGroup(newField);
    this.data.fields = fields;
  }

  getFormControlName(name) {

    return _.snakeCase(name);
  }

  subscriberHasFieldOfType(fieldTypeId: number) {

    return _.first(_.filter(this.data.fields, (field) => {
      return field.field_type_id == fieldTypeId;
    }));
  }

}
