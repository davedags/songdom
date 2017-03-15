import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { LoginComponent } from './login.component';
import { UserRoutingModule } from  './user-routing.module';
import { FocusModule } from '../focus/focus.module';

@NgModule({
    declarations: [
        LoginComponent
    ],
    imports: [
        CommonModule,
        FormsModule,
        UserRoutingModule,
        FocusModule
  ]
})
export class UserModule { }
