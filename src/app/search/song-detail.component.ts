import { Component, Input } from '@angular/core';
import { Song } from './song.service';

@Component({
  selector: 'song-detail',
  templateUrl: './song-detail.component.html'
})
export class SongDetailComponent {
  
  @Input()
  song: Song;

  @Input()
  haveSearched: boolean;

  constructor() {
    this.haveSearched = false;
  }

}
