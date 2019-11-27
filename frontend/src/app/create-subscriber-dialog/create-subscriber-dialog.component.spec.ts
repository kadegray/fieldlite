import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateSubscriberDialogComponent } from './create-subscriber-dialog.component';

describe('CreateSubscriberDialogComponent', () => {
  let component: CreateSubscriberDialogComponent;
  let fixture: ComponentFixture<CreateSubscriberDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CreateSubscriberDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateSubscriberDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
