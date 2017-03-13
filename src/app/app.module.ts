import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

/* App Root */
import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module'
/* Features Modules and Components */

import { SearchModule } from './search/search.module';
import { SignupComponent } from './signup/signup.component';
import { LoginComponent } from './login/login.component';

@NgModule({
  declarations: [
    AppComponent,
    SignupComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    SearchModule,
    AppRoutingModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }