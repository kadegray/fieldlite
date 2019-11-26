import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { SubscribersComponent } from './subscribers/subscribers.component';


const routes: Routes = [
  { path: '', component: SubscribersComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
