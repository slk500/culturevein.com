import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TagShowComponent } from './tag-show.component';

describe('TagShowComponent', () => {
  let component: TagShowComponent;
  let fixture: ComponentFixture<TagShowComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TagShowComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TagShowComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
