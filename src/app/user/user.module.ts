import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { LoginComponent } from './login.component';
import { SignupComponent } from './signup.component';
import { UserRoutingModule } from  './user-routing.module';

@NgModule({
  imports: [
    CommonModule,
    UserRoutingModule
  ],
  declarations: [
      LoginComponent,
      SignupComponent
  ]
})
export class UserModule { }
