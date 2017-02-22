import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { AlertModule } from 'ng2-bootstrap/alert';
import { UiSwitchModule } from 'angular2-ui-switch';
import { AppComponent } from './app.component';
import { SearchComponent } from './search/search.component';
import { SongDetailComponent } from './song-detail/song-detail.component';

@NgModule({
  declarations: [
    AppComponent,
    SearchComponent,
    SongDetailComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    AlertModule.forRoot(),
    UiSwitchModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
